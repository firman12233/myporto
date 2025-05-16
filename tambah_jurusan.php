<?php
include 'koneksi.php';

if (isset($_POST['nama_jurusan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);
    $status = 'Aktif';

    $query = "INSERT INTO jurusan (nama_jurusan, status) VALUES ('$nama', '$status')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: semua_jurusan.php?pesan=tambah_sukses");
    } else {
        header("Location: semua_jurusan.php?pesan=tambah_gagal");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jurusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2>Tambah Jurusan Baru</h2>

    <form action="" method="POST">
        <label for="nama_jurusan">Nama Jurusan:</label>
        <input type="text" id="nama_jurusan" name="nama_jurusan" required>
        <button type="submit">Simpan</button>
    </form>

</body>
</html>