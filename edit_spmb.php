<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

// Cek apakah ada parameter id yang diterima dari POST atau GET
$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$id) {
    echo "ID tidak ditemukan.";
    exit();
}

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'operator')) {
    header("Location: login.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM spmb WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis    = $_POST['nis'];
    $nisn   = $_POST['nisn'];
    $nama   = $_POST['nama_siswa'];
    $jurusan = $_POST['jurusan'];
    $universitas = $_POST['universitas'];
    $prodi  = $_POST['prodi'];
    $tahun  = $_POST['tahun'];

    $foto_baru = $data['foto_siswa']; // default tidak diubah

    if (isset($_FILES['foto_siswa']) && $_FILES['foto_siswa']['error'] == 0) {
        $foto_baru = uniqid() . '_' . basename($_FILES['foto_siswa']['name']);
        move_uploaded_file($_FILES['foto_siswa']['tmp_name'], "uploads/" . $foto_baru);
    }

    $query_update = "UPDATE spmb SET 
        nis='$nis',
        nisn='$nisn',
        nama_siswa='$nama',
        jurusan='$jurusan',
        universitas='$universitas',
        prodi='$prodi',
        tahun='$tahun',
        foto_siswa='$foto_baru'
        WHERE id='$id'";

    if (mysqli_query($koneksi, $query_update)) {
        if (function_exists('simpan_log')) {
            simpan_log($koneksi, $_SESSION['username'], "Mengedit data SNBP ID $id");
        }
        header("Location: edit_spmb.php?id=$id&pesan=sukses");
        exit();
    } else {
        header("Location: edit_spmb.php?id=$id&pesan=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit SNPMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2>Edit Data SNPMB</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label>NISN</label>
                <input type="text" name="nisn" value="<?= $data['nisn'] ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Nama Siswa</label>
                <input type="text" name="nama_siswa" value="<?= $data['nama_siswa'] ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Jurusan</label>
                <select name="jurusan" class="form-control" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <?php
                    include 'koneksi.php'; // Pastikan koneksi ada

                    $query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE status = 'Aktif' ORDER BY nama_jurusan ASC");
                    while ($row_jurusan = mysqli_fetch_assoc($query_jurusan)) {
                        echo '<option value="' . htmlspecialchars($row_jurusan['nama_jurusan']) . '">' . htmlspecialchars($row_jurusan['nama_jurusan']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Universitas</label>
                <input type="text" name="universitas" value="<?= $data['universitas'] ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Program Studi</label>
                <input type="text" name="prodi" value="<?= $data['prodi'] ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Tahun</label>
                <input type="text" name="tahun" value="<?= $data['tahun'] ?>" class="form-control">
            </div>
            <div class="col-md-12">
                <label>Foto Bukti (upload jika ingin ganti)</label>
                <input type="file" name="foto_siswa" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        <a href="semua_spmb.php" class="btn btn-secondary mt-3">Kembali</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data siswa berhasil diubah!',
    timer: 2000,
    showConfirmButton: false
}).then(() => {
    window.location.href = 'semua_spmb.php'; // Redirect ke halaman daftar setelah sukses
});
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: 'Data siswa gagal diubah!'
}).then(() => {
    window.location.href = 'semua_spmb.php'; // Redirect ke halaman daftar jika gagal
});
<?php endif; ?>
</script>
</body>
</html>
