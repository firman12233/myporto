<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    // Simpan ke database atau kirim email
    // Contoh respon sederhana:
    echo "<script>alert('Pesan berhasil dikirim!'); window.location='kontak.php';</script>";
}
?>