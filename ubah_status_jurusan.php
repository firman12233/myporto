<?php
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar

// Cek apakah parameter 'id' dan 'status' ada di URL dan valid
if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = intval($_GET['id']); // Mengambil ID jurusan dan memastikan itu adalah angka
    $status = $_GET['aksi']; // Mengambil status (Aktif/Nonaktif)

    // Pastikan status yang diterima adalah salah satu yang valid
    if ($status == 'aktif' || $status == 'nonaktif') {
        // Query untuk memperbarui status jurusan
        $query = mysqli_query($koneksi, "UPDATE jurusan SET status = '$status' WHERE id_jurusan = '$id'");

        // Cek apakah query berhasil dieksekusi
        if ($query) {
            header('Location: semua_jurusan.php?pesan=berhasil'); // Redirect ke halaman dengan pesan berhasil
        } else {
            header('Location: semua_jurusan.php?pesan=gagal'); // Redirect ke halaman dengan pesan gagal
        }
    } else {
        // Jika status tidak valid
        header('Location: semua_jurusan.php?pesan=invalid'); // Redirect dengan pesan invalid
    }
} else {
    // Jika parameter 'id' atau 'status' tidak ada
    header('Location: semua_jurusan.php?pesan=invalid'); // Redirect dengan pesan invalid
}
?>