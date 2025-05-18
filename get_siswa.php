<?php
include 'koneksi.php';

header('Content-Type: application/json');

if (isset($_GET['nis'])) {
    $nis = mysqli_real_escape_string($koneksi, $_GET['nis']);
    $query = "SELECT nama_siswa AS nama, nisn, jurusan FROM siswa WHERE nis = '$nis' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
