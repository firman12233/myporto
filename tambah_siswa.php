<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman hanya untuk admin.'); window.location.href='index.php';</script>";
    exit;
}

// Proses simpan data siswa
if (isset($_POST['simpan'])) {
  $nis = $_POST['nis'];
  $nisn = $_POST['nisn'];
  $nama_siswa = $_POST['nama_siswa'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $kelas = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];
  $tempat_lahir = $_POST['tempat_lahir'];

  // Cek apakah NIS atau NISN sudah ada
  $cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis' OR nisn = '$nisn'");
  if (mysqli_num_rows($cek) > 0) {
      header("Location: tambah_siswa.php?pesan=duplikat");
      exit;
  }

  // Jika tidak duplikat, simpan
  $query = "INSERT INTO siswa (nis, nisn, nama_siswa, jenis_kelamin, kelas, jurusan, tempat_lahir) 
            VALUES ('$nis', '$nisn', '$nama_siswa', '$jenis_kelamin', '$kelas', '$jurusan', '$tempat_lahir')";
  $result = mysqli_query($koneksi, $query);

  if ($result) {
      header("Location: tambah_siswa.php?pesan=sukses");
  } else {
      header("Location: tambah_siswa.php?pesan=gagal");
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa</title>
  <link rel="icon" href="logo-smkn1slawi1.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Form Tambah Siswa</h2>
  <form method="POST" action="">
    <div class="mb-3">
      <label for="inputNIS" class="form-label">NIS</label>
      <input type="text" class="form-control" id="inputNIS" name="nis" required>
    </div>
    <div class="mb-3">
      <label for="inputNISN" class="form-label">NISN</label>
      <input type="text" class="form-control" id="inputNISN" name="nisn" required>
    </div>
    <div class="mb-3">
      <label for="inputNama" class="form-label">Nama</label>
      <input type="text" class="form-control" id="inputNama" name="nama_siswa" required>
    </div>
    <div class="mb-3 col-md-4">
      <label for="inputJK" class="form-label">Jenis Kelamin</label>
      <select name="jenis_kelamin" id="inputJK" class="form-control" required>
        <option value="" disabled selected>Pilih</option>
        <option>Laki-Laki</option>
        <option>Perempuan</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="inputKelas" class="form-label">Kelas</label>
      <input type="text" class="form-control" id="inputKelas" name="kelas" placeholder="X,Xl,Xll"required>
    </div>
    <div class="mb-3 col-md-4">
      <label for="inputJurusan" class="form-label">Kompetensi Keahlian</label>
      <select name="jurusan" id="inputJurusan" class="form-control" required>
        <option value="" disabled selected>Pilih Kompetensi Keahlian</option>
        <?php
        include 'koneksi.php';
        $query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE status = 'Aktif' ORDER BY nama_jurusan ASC");
        while ($row_jurusan = mysqli_fetch_assoc($query_jurusan)) {
            echo '<option value="' . htmlspecialchars($row_jurusan['nama_jurusan']) . '">' . htmlspecialchars($row_jurusan['nama_jurusan']) . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="inputTempatLahir" class="form-label">Tempat Lahir</label>
      <input type="text" class="form-control" id="inputTempatLahir" name="tempat_lahir" required>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data siswa berhasil ditambahkan!',
    timer: 2000,
    showConfirmButton: false
});
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: 'Data siswa gagal ditambahkan!'
});
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'duplikat'): ?>
Swal.fire({
    icon: 'warning',
    title: 'Duplikat!',
    text: 'NIS atau NISN sudah terdaftar!'
});
<?php endif; ?>
</script>
</body>
</html>
