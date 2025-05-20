<?php
session_start();
include 'koneksi.php';

// Fungsi ambil tahun dan bulan unik dari data galeri
function getYearsMonths($koneksi) {
    $arr = ['years' => [], 'months' => []];
    $result = $koneksi->query("SELECT DISTINCT YEAR(tanggal) AS year, MONTH(tanggal) AS month FROM gallery ORDER BY year DESC, month DESC");
    while ($row = $result->fetch_assoc()) {
        $arr['years'][$row['year']] = $row['year'];
        $arr['months'][$row['month']] = date('F', mktime(0, 0, 0, $row['month'], 10));
    }
    return $arr;
}

// Ambil filter dari GET
$filter_year = isset($_GET['year']) ? (int)$_GET['year'] : 0;
$filter_month = isset($_GET['month']) ? (int)$_GET['month'] : 0;
$search = isset($_GET['search']) ? $koneksi->real_escape_string(trim($_GET['search'])) : '';

$where = [];
if ($filter_year > 0) $where[] = "YEAR(g.tanggal) = $filter_year";
if ($filter_month > 0) $where[] = "MONTH(g.tanggal) = $filter_month";
if ($search !== '') $where[] = "g.judul LIKE '%$search%'";

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Query galeri dan foto (LEFT JOIN)
$query = "SELECT g.id, g.judul, g.deskripsi, g.tanggal, f.nama_file 
          FROM gallery g
          LEFT JOIN gallery_foto f ON g.id = f.gallery_id
          $where_sql
          ORDER BY g.tanggal DESC";
$result = $koneksi->query($query);

$galeri = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    if (!isset($galeri[$id])) {
        $galeri[$id] = [
            'judul' => $row['judul'],
            'deskripsi' => $row['deskripsi'],
            'tanggal' => $row['tanggal'],
            'foto' => []
        ];
    }
    if (!empty($row['nama_file'])) {
        $galeri[$id]['foto'][] = $row['nama_file'];
    }
}

$yearMonthData = getYearsMonths($koneksi);

// Tentukan galeri terbaru (3 teratas berdasarkan tanggal)
$sortedByDate = $galeri;
usort($sortedByDate, function($a, $b) {
    return strtotime($b['tanggal']) - strtotime($a['tanggal']);
});
$latestIds = array_slice(array_keys($sortedByDate), 0, 3);

// Tentukan galeri populer (3 teratas berdasarkan jumlah foto)
$sortedByFotoCount = $galeri;
usort($sortedByFotoCount, function($a, $b) {
    return count($b['foto']) - count($a['foto']);
});
$popularIds = array_slice(array_keys($sortedByFotoCount), 0, 3);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Galeri Dokumentasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .galeri-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .galeri-item {
            margin-bottom: 30px;
        }
        .deskripsi-terbatas {
            max-height: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Label badge */
        .badge-terbaru {
            background-color: #198754; /* Bootstrap success */
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            font-size: 0.8rem;
            padding: 0.35em 0.6em;
        }
        .badge-populer {
            background-color: #ffc107; /* Bootstrap warning */
            color: #212529;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            font-size: 0.8rem;
            padding: 0.35em 0.6em;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="mb-3 d-flex justify-content-between flex-wrap gap-2">
        <a href="index.php" class="btn btn-secondary">&larr; Kembali</a>
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'operator')): ?>
            <a href="tambah_galeri.php" class="btn btn-success">+ Tambah Galeri</a>
        <?php endif; ?>
    </div>

    <h2 class="fw-bold mb-4">Galeri Dokumentasi</h2>

    <form method="GET" class="row g-3 mb-4 align-items-center">
        <div class="col-auto">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama lomba..."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
            />
        </div>
        <div class="col-auto">
            <select name="year" class="form-select" onchange="this.form.submit()">
                <option value="0">Semua Tahun</option>
                <?php foreach ($yearMonthData['years'] as $year): ?>
                    <option value="<?= $year ?>" <?= ($filter_year == $year) ? 'selected' : '' ?>><?= $year ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <select name="month" class="form-select" onchange="this.form.submit()">
                <option value="0">Semua Bulan</option>
                <?php foreach ($yearMonthData['months'] as $num => $name): ?>
                    <option value="<?= $num ?>" <?= ($filter_month == $num) ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="gallery.php" class="btn btn-outline-secondary">Reset Filter</a>
        </div>
    </form>

    <?php if (empty($galeri)): ?>
        <div class="alert alert-info">Belum ada galeri yang sesuai filter.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($galeri as $id => $item): ?>
                <div class="col-md-6 col-lg-4 galeri-item">
                    <div class="card h-100 shadow-sm position-relative">
                        <?php if (in_array($id, $latestIds)): ?>
                            <span class="badge badge-terbaru">Terbaru</span>
                        <?php elseif (in_array($id, $popularIds)): ?>
                            <span class="badge badge-populer">Populer</span>
                        <?php endif; ?>

                        <?php if (!empty($item['foto'])): ?>
                            <img src="uploads/gallery/<?= htmlspecialchars($item['foto'][0]) ?>" class="card-img-top" alt="Foto Galeri" />
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($item['judul']) ?></h5>
                            <p class="card-text deskripsi-terbatas"><?= nl2br(htmlspecialchars($item['deskripsi'])) ?></p>
                            <a href="detail_galeri.php?id=<?= $id ?>" class="text-decoration-none small">Lihat selengkapnya &rarr;</a>
                            <p class="card-text text-muted mt-auto"><small><?= date('d F Y', strtotime($item['tanggal'])) ?></small></p>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <form method="POST" action="hapus_galeri.php" onsubmit="return confirm('Yakin ingin menghapus galeri ini?');" class="mt-2">
                                    <input type="hidden" name="gallery_id" value="<?= $id ?>" />
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus Galeri</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
