<?php
$koneksi = new mysqli("localhost", "root", "", "db_prestasi_siswa");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>