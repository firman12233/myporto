<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        die('Akses ditolak');
    }
    $gallery_id = (int)$_POST['gallery_id'];

    // Ambil semua foto dari galeri
    $result = $koneksi->query("SELECT nama_file FROM gallery_foto WHERE gallery_id = $gallery_id");
    while ($row = $result->fetch_assoc()) {
        $path = 'uploads/gallery/' . $row['nama_file'];
        if (file_exists($path)) unlink($path);
    }

    // Hapus foto dari DB
    $koneksi->query("DELETE FROM gallery_foto WHERE gallery_id = $gallery_id");

    // Hapus galeri
    $koneksi->query("DELETE FROM gallery WHERE id = $gallery_id");

    header("Location: gallery.php?pesan=hapus_berhasil");
    exit();
}
?>
