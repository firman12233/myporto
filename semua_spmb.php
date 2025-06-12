<?php
session_start();
include 'koneksi.php';
$success = $_GET['success'] ?? '';

$role = $_SESSION['role'] ?? 'public';

$limit = 15;
$page = $_GET['page_spmb'] ?? 1;
$start = ($page - 1) * $limit;

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM spmb"))['total'];
$pages = ceil($total / $limit);

$order_spmb = ($_GET['order_spmb'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
$new_order_spmb = $order_spmb === 'ASC' ? 'desc' : 'asc';

$query = "SELECT * FROM spmb ORDER BY tahun $order_spmb LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

$jurusan_list = [];
$jurusan_query = mysqli_query($koneksi, "SELECT nama_jurusan FROM jurusan ORDER BY nama_jurusan");
while ($jur = mysqli_fetch_assoc($jurusan_query)) {
    $jurusan_list[] = $jur['nama_jurusan'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data SNBP - Smeansawi</title>
  <link rel="icon" href="logo-smkn1slawi1.png" type="image/png">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .card-img-top {
      height: 200px;
      object-fit: cover;
    }
    .navbar-brand img {
      max-height: 50px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/logo-smkn1slawi.png" alt="Logo SMK N 1 Slawi" class="img-fluid me-2">
      <span class="fw-bold">SMK Negeri 1 Slawi</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="semua_prestasi.php">Prestasi</a></li>
        <li class="nav-item"><a class="nav-link active" href="semua_spmb.php">SNBP</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">Others</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="gallery.php">Gallery</a></li>
            <li><a class="dropdown-item" href="sosmed.php">Sosmed</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a class="dropdown-item" href="log_aktivitas.php">Log Aktivitas</a></li>
              <li><a class="dropdown-item" href="tambah_siswa.php">Tambah Siswa</a></li>
              <li><a class="dropdown-item" href="semua_jurusan.php">Tambah Jurusan</a></li>
              <li><a class="dropdown-item" href="tambah_admin.php">Tambah Admin</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container pt-5 mt-5">
  <div class="d-flex justify-content-between mb-3">
    <a href="index.php" class="btn btn-secondary">&larr; Kembali</a>
    <?php if ($role === 'admin' || $role === 'operator'): ?>
      <div>
        <a href="export_spmb_excel.php" class="btn btn-success">Export Excel</a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahSnbpModal">+ Tambah SNBP</button>
      </div>
    <?php endif; ?>
  </div>

  <div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-left flex-grow-1">Data SNBP SMKN 1 SLAWI</h2>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel">
      <thead class="table-dark">
        <tr>
          <th>NIS</th>
          <th>NISN</th>
          <th>Nama</th>
          <th>Kompetensi Keahlian</th>
          <th>Universitas</th>
          <th>Program Studi</th>
          <th class="text-center">Tahun</th>
          <th>Foto</th>
          <?php if ($role === 'admin' || $role === 'operator') echo "<th>Aksi</th>"; ?>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td class="text-center"><?= htmlspecialchars($row['nis']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['nisn']) ?></td>
            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['jurusan']) ?></td>
            <td><?= htmlspecialchars($row['universitas']) ?></td>
            <td><?= htmlspecialchars($row['prodi']) ?></td>
            <td class="text-center"style="white-space: nowrap;"><?= date('Y', strtotime($row['tahun'])) ?></td>
            <td>
              <?php if (!empty($row['foto_siswa'])): ?>
                <a href="uploads/<?= $row['foto_siswa'] ?>" data-lightbox="foto-<?= $row['id'] ?>">
                  <img src="uploads/<?= $row['foto_siswa'] ?>" style="max-width: 50px;">
                </a>
              <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
              <?php endif; ?>
            </td>
            <?php if ($role === 'admin' || $role === 'operator'): ?>
              <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id'] ?>">
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </td>
            <?php endif; ?>
          </tr>

          <!-- Modal Edit -->
          <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form action="edit_spmb.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit SNBP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body row g-3">
                    <div class="col-md-6">
                      <label for="nis_edit_<?= $row['id'] ?>">NIS</label>
                      <input name="nis" id="nis_edit_<?= $row['id'] ?>" class="form-control nis-input" data-id="<?= $row['id'] ?>" value="<?= $row['nis'] ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label>NISN</label>
                      <input name="nisn" id="nisn_edit_<?= $row['id'] ?>" class="form-control" value="<?= $row['nisn'] ?>" readonly required>
                    </div>
                    <div class="col-md-6">
                      <label>Nama</label>
                      <input name="nama_siswa" id="nama_edit_<?= $row['id'] ?>" class="form-control" value="<?= $row['nama_siswa'] ?>" readonly required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Kompetensi Keahlian</label>
                      <select name="jurusan" id="jurusan_edit_<?= $row['id'] ?>" class="form-control" required>
                        <?php foreach ($jurusan_list as $jur): ?>
                          <option value="<?= $jur ?>" <?= $jur == $row['jurusan'] ? 'selected' : '' ?>><?= $jur ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Universitas</label>
                      <input name="universitas" class="form-control" value="<?= $row['universitas'] ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label>Prodi</label>
                      <input name="prodi" class="form-control" value="<?= $row['prodi'] ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label>Tahun</label>
                      <input name="tahun" class="form-control" value="<?= $row['tahun'] ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label>Foto</label>
                      <input type="file" name="foto_siswa" class="form-control">
                      <small class="text-muted"><?= $row['foto_siswa'] ?></small>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Hapus -->
          <div class="modal fade" id="hapusModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title">Konfirmasi Hapus</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  Yakin ingin menghapus data <strong><?= htmlspecialchars($row['nama_siswa']) ?></strong>?
                </div>
                <div class="modal-footer">
                  <a href="hapus.php?id=<?= $row['id'] ?>&tipe=spmb" class="btn btn-danger">Ya, Hapus</a>
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- Modal Tambah -->
<?php if ($role === 'admin' || $role === 'operator'): ?>
  <div class="modal fade" id="tambahSnbpModal" tabindex="-1" aria-labelledby="tambahSnbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="tambah_spmb.php" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahSnbpModalLabel">Tambah SNBP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>NIS</label>
              <input type="text" name="nis" id="nis" class="form-control" required />
            </div>
              <div class="col-md-6">
                <label for="nisn">NISN</label>
                <input type="text" id="nisn" name="nisn" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" readonly required />
              </div>
              <div class="col-md-6">
                <label for="jurusan">Kompetensi Keahlian</label>
                <select name="jurusan" id="jurusan" class="form-control" required>
                  <?php foreach ($jurusan_list as $jur): ?>
                    <option value="<?= htmlspecialchars($jur) ?>"><?= htmlspecialchars($jur) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="universitas">Universitas</label>
                <input type="text" name="universitas" id="universitas" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="prodi">Program Studi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" id="tahun" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label for="foto_siswa">Foto Siswa</label>
                <input type="file" name="foto_siswa" id="foto_siswa" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const nisInput = document.getElementById('nis');
  
  nisInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault(); // mencegah form submit
      const nis = nisInput.value.trim();

      if (nis !== '') {
        fetch(`get_siswa.php?nis=${nis}`)
          .then(response => response.json())
          .then(data => {
            if (data && data.nama && data.nisn && data.jurusan) {
              document.getElementById('nama_siswa').value = data.nama;
              document.getElementById('nisn').value = data.nisn;
              document.getElementById('jurusan').value = data.jurusan;
            } else {
              alert('Data siswa tidak ditemukan.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data siswa.');
          });
      }
    }
  });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    new DataTable('#tabel', {
      paging: true,
      ordering: true,
      info: false,
    });
  });
</script>
</body>
</html>
