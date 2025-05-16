<?php
session_start();
include 'koneksi.php';
include 'fungsi_log.php';

// Cek role login
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'operator')) {
    header("Location: login.php");
    exit();
}

// Cek parameter ID dan tipe
if (isset($_GET['id']) && isset($_GET['tipe'])) {
    $id = intval($_GET['id']);
    $tipe = $_GET['tipe'];

    // Inisialisasi variabel berdasarkan tipe
    switch ($tipe) {
        case 'prestasi':
            $tabel = 'prestasi';
            $kolomFoto = 'foto_berita';
            $redirect = 'semua_prestasi.php';
            break;
        case 'spmb':
            $tabel = 'spmb';
            $kolomFoto = 'foto_bukti';
            $redirect = 'semua_spmb.php';
            break;
        default:
            echo "Tipe tidak valid!";
            exit();
    }

    // Ambil data dari DB
    $query = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Hapus file foto jika ada
        if (!empty($data[$kolomFoto])) {
            $filePath = 'uploads/' . $data[$kolomFoto];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data dari database
        $delete = mysqli_query($koneksi, "DELETE FROM $tabel WHERE id = $id");
        if ($delete) {
            // Simpan log
            simpan_log($koneksi, $_SESSION['username'], "Menghapus data $tipe ID $id");
            echo "<script>alert('Data berhasil dihapus!'); window.location='$redirect';</script>";
        } else {
            echo "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        echo "Data tidak ditemukan!";
    }
} else {
    echo "ID atau tipe tidak ditemukan!";
}
?>