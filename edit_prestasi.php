<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id         = $_POST['id'];
    $nis        = $_POST['nis'];
    $nisn       = $_POST['nisn'];
    $nama       = $_POST['nama_siswa'];
    $jurusan    = $_POST['jurusan'];
    $lomba      = $_POST['nama_lomba'];
    $tingkat    = $_POST['tingkat'];
    $juara      = $_POST['juara'];
    $penyelenggara = $_POST['penyelenggara'];
    $tahun      = $_POST['tahun'];
    $kategori   = $_POST['kategori'];

    // Cek apakah upload file baru
    $foto_bukti = '';
    if (!empty($_FILES['foto_bukti']['name'])) {
        $foto_bukti = uniqid() . '_' . basename($_FILES['foto_bukti']['name']);
        move_uploaded_file($_FILES['foto_bukti']['tmp_name'], 'uploads/' . $foto_bukti);

        // Update dengan file foto baru
        $stmt = $koneksi->prepare("UPDATE prestasi SET nama_siswa=?, nis=?, nisn=?, jurusan=?, nama_lomba=?, tingkat=?, juara=?, penyelenggara=?, tahun=?, kategori=?, foto_bukti=? WHERE id=?");
        $stmt->bind_param("sssssssssssi", $nama, $nis, $nisn, $jurusan, $lomba, $tingkat, $juara, $penyelenggara, $tahun, $kategori, $foto_bukti, $id);
    } else {
        // Update tanpa mengubah foto
        $stmt = $koneksi->prepare("UPDATE prestasi SET nama_siswa=?, nis=?, nisn=?, jurusan=?, nama_lomba=?, tingkat=?, juara=?, penyelenggara=?, tahun=?, kategori=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $nama, $nis, $nisn, $jurusan, $lomba, $tingkat, $juara, $penyelenggara,  $tahun, $kategori, $id);
    }

    if ($stmt->execute()) {
        simpan_log($koneksi, $_SESSION['username'], "Mengedit data prestasi ID $id");
        header("Location: semua_prestasi.php?pesan=edit_sukses");
        exit();
    } else {
        header("Location: semua_prestasi.php?pesan=edit_gagal");
        exit();
    }
}
?>
