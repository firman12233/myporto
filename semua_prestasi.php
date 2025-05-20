<?php
session_start();
include 'koneksi.php';

$role = $_SESSION['role'] ?? 'public';

$limit = 100;
$page = $_GET['page_prestasi'] ?? 1;
$start = ($page - 1) * $limit;

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM prestasi"))['total'];
$pages = ceil($total / $limit);

$order_prestasi = ($_GET['order_prestasi'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
$new_order_prestasi = $order_prestasi === 'ASC' ? 'desc' : 'asc';

$query = "SELECT * FROM prestasi ORDER BY tahun $order_prestasi LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

$jurusan_list = [];
$jurusan_query = mysqli_query($koneksi, "SELECT nama_jurusan FROM jurusan ORDER BY nama_jurusan");
while ($jur = mysqli_fetch_assoc($jurusan_query)) {
    $jurusan_list[] = $jur['nama_jurusan'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Semua Prestasi</title>
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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Smeansawi Berprestasi</a>
  </div>
</nav>
<div class="container pt-5 mt-5">
  <div class="d-flex justify-content-between mb-3">
    <a href="index.php" class="btn btn-secondary">&larr; Kembali</a>
    <?php if ($role === 'admin' || $role === 'operator'): ?>
      <div>
        <a href="export_prestasi_excel.php" class="btn btn-success">Export Excel</a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPrestasiModal">+ Tambah Prestasi</button>
      </div>
    <?php endif; ?>
  </div>
<div class="container pt-5">
  <div class="d-flex justify-content-between mb-3">
    <h2 class="text-left flex-grow-1">Data Prestasi Siswa SMKN 1 SLAWI</h2>
  </div>
  <div class="table-responsive">
  <table class="table table-bordered table-striped table-hover" id="tabel">
    <thead class="table-dark">
      <tr>
        <th>NIS</th>
        <th>NISN</th>
        <th>Nama Siswa</th>
        <th class="text-center">Jurusan</th>
        <th class="text-center">Prestasi</th>
        <th class="text-center">Juara</th>
        <th class="text-center">Tingkat</th>
        <th class="text-center">Tahun</th>
        <th class="text-center">Kategori</th>
        <th>Foto Bukti</th>
        <?php if ($role === 'admin' || $role === 'operator') echo "
        <th>Aksi</th>"; ?>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td class="text-center"><?= htmlspecialchars($row['nis']) ?></td>
        <td><?= htmlspecialchars($row['nisn']) ?></td>
        <td class="text-start"><?= htmlspecialchars($row['nama_siswa']) ?></td>
        <td><?= htmlspecialchars($row['jurusan']) ?></td>
        <td class="text-start"><?= htmlspecialchars($row['nama_lomba']) ?></td>
        <td><?= htmlspecialchars($row['juara']) ?></td>
        <td><?= htmlspecialchars($row['tingkat']) ?></td>
        <td class="text-center"style="white-space: nowrap;"><?= date('Y', strtotime($row['tahun'])) ?></td>
        <td><?= htmlspecialchars($row['kategori']) ?></td>
        <td>
          <?php if (!empty($row['foto_bukti'])): ?>
            <a href="uploads/<?= $row['foto_bukti']; ?>" data-lightbox="foto-<?= $row['id']; ?>">
  <img src="uploads/<?= $row['foto_bukti']; ?>" style="max-width: 50px;">
</a>
          <?php else: ?>
            <span class="text-muted">Tidak ada foto</span>
          <?php endif; ?>
        </td>
        <?php if ($role === 'admin' || $role === 'operator'): ?>
        <td>
          <!-- Tombol Edit -->
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>"><i class="bi bi-pencil-square"></i></button>
          <!-- Tombol Hapus -->
          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id']; ?>"><i class="bi bi-trash3-fill"></i></button>
        </td>
        <?php endif; ?>
      </tr>

<!-- Modal Edit -->
<div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form action="edit_prestasi.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="modal-header">
          <h5 class="modal-title">Edit Prestasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">NIS</label>
              <input type="text" name="nis" class="form-control" value="<?= $row['nis'] ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NISN</label>
              <input type="text" name="nisn" class="form-control" value="<?= $row['nisn'] ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama Siswa</label>
              <input type="text" name="nama_siswa" class="form-control" value="<?= $row['nama_siswa'] ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jurusan</label>
              <select name="jurusan" class="form-control" required>
  <?php foreach ($jurusan_list as $jur): ?>
    <option value="<?= $jur ?>" <?= $jur == $row['jurusan'] ? 'selected' : '' ?>><?= $jur ?></option>
  <?php endforeach; ?>
</select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama Lomba</label>
              <input type="text" name="nama_lomba" class="form-control" value="<?= $row['nama_lomba'] ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tingkat</label>
              <select name="tingkat" class="form-control" required>
                <?php foreach (["Sekolah", "Kecamatan", "Kabupaten", "Keresidenan", "Provinsi", "Nasional"] as $tingkat): ?>
                  <option value="<?= $tingkat ?>" <?= $tingkat == $row['tingkat'] ? 'selected' : '' ?>><?= $tingkat ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Juara</label>
              <select name="juara" class="form-control" required>
                <?php foreach (["Juara 1", "Juara 2", "Juara 3", "Juara Harapan 1", "Juara Harapan 2", "Juara Harapan 3"] as $juara): ?>
                  <option value="<?= $juara ?>" <?= $juara == $row['juara'] ? 'selected' : '' ?>><?= $juara ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tahun</label>
              <input type="date" name="tahun" class="form-control" value="<?= $row['tahun'] ?>" required>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select name="kategori" class="form-control" required>
                <option value="Akademik" <?= $row['kategori'] == "Akademik" ? 'selected' : '' ?>>Akademik</option>
                <option value="NonAkademik" <?= $row['kategori'] == "NonAkademik" ? 'selected' : '' ?>>NonAkademik</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Berita</label>
              <input type="file" name="foto_bukti" class="form-control">
              <?php if (!empty($row['foto_bukti'])): ?>
                <small class="text-muted">Saat ini: <?= $row['foto_bukti'] ?></small>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

      <!-- Modal Hapus -->
      <div class="modal fade" id="hapusModal<?= $row['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title">Konfirmasi Hapus</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              Apakah kamu yakin ingin menghapus data prestasi milik <strong><?= htmlspecialchars($row['nama_siswa']); ?></strong>?
            </div>
            <div class="modal-footer">
            <a href="hapus.php?id=<?= $row['id']; ?>&tipe=prestasi" class="btn btn-danger">Ya,Hapus</a>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </tbody>
  </table>

<!-- Modal Tambah Prestasi -->
<?php if ($role === 'admin' || $role === 'operator'): ?>
<div class="modal fade" id="tambahPrestasiModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="tambah_prestasi.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Prestasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>NIS</label>
              <input type="text" name="nis" id="nis" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label>Nama Siswa</label>
              <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" readonly required />
            </div>
            <div class="col-md-6">
              <label>NISN</label>
              <input type="text" name="nisn" id="nisn" class="form-control" readonly />
            </div>
            <div class="col-md-4">
              <label>Jurusan</label>
              <select name="jurusan" id="jurusan" class="form-control" required>
                <!-- Jurusan options here -->
                <?php foreach ($jurusan_list as $jur): ?>
                  <option value="<?= $jur ?>"><?= $jur ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6"><label>Nama Lomba</label><input type="text" name="nama_lomba" class="form-control" required /></div>
            <div class="col-md-4">
              <label>Juara</label>
              <select name="juara" class="form-control" required>
                <option value="Juara 1">Juara 1</option>
                <option value="Juara 2">Juara 2</option>
                <option value="Juara 3">Juara 3</option>
                <option value="Juara Harapan 1">Juara Harapan 1</option>
                <option value="Juara Harapan 2">Juara Harapan 2</option>
                <option value="Juara Harapan 3">Juara Harapan 3</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Tingkat</label>
              <select name="tingkat" class="form-control" required>
              <option value="Sekolah">Sekolah</option>
                <option value="Kecamatan">Kecamatan</option>
                <option value="Kabupaten">Kabupaten</option>
                <option value="Keresidenan">Keresidenan</option>
                <option value="Provinsi">Provinsi</option>
                <option value="Nasional">Nasional</option>
              </select>
            </div>
            <div class="col-md-4"><label>Tahun</label><input type="date" name="tahun" class="form-control" required /></div>
            <div class="col-md-6">
              <label>Kategori</label>
              <select name="kategori" class="form-control" required>
                <option value="Akademik">Akademik</option>
                <option value="NonAkademik">NonAkademik</option>
              </select>
            </div>
            <div class="col-md-6"><label>Foto Bukti</label><input type="file" name="foto_bukti" class="form-control" /></div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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