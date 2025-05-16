<?php
include 'koneksi.php';
include 'fungsi_log.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM jurusan WHERE id_jurusan = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: semua_jurusan.php?pesan=hapus_sukses");
        exit;
    } else {
        header("Location: semua_jurusan.php?pesan=hapus_gagal");
        exit;
    }
} else {
    header("Location: semua_jurusan.php");
    exit;
}
?>