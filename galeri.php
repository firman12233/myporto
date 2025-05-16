<?php
include 'koneksi.php';

// Ambil data filter
$tahun_filter    = $_GET['tahun'] ?? '';
$kategori_filter = $_GET['kategori'] ?? '';
$cari            = $_GET['cari'] ?? '';

// Pagination
$batas = 6;
$hal   = $_GET['hal'] ?? 1;
$mulai = ($hal - 1) * $batas;

// Ambil data filter dropdown
$tahun_q    = mysqli_query($koneksi, "SELECT DISTINCT tahun FROM prestasi ORDER BY tahun DESC");
$kategori_q = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM prestasi ORDER BY kategori ASC");

// Query utama
$where = "WHERE 1";
if ($tahun_filter !== '') $where .= " AND tahun = '$tahun_filter'";
if ($kategori_filter !== '') $where .= " AND kategori = '$kategori_filter'";
if ($cari !== '') $where .= " AND nama_lomba LIKE '%$cari%'";

// Hitung total dan data halaman
$count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM prestasi $where");
$total = mysqli_fetch_assoc($count)['total'];
$pages = ceil($total / $batas);

$query = mysqli_query($koneksi, "SELECT * FROM prestasi $where ORDER BY tahun DESC LIMIT $mulai, $batas");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Galeri Prestasi - Coming Soon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .coming-soon {
            text-align: center;
            padding: 50px;
            background: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .coming-soon h1 {
            font-size: 3rem;
            color: #343a40;
        }
        .coming-soon p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        .btn-coming-soon {
            margin-top: 20px;
            font-size: 1.1rem;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-coming-soon:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="container py-5">

    <div class="coming-soon">
        <h1>Galeri Prestasi Kami Akan Segera Tersedia</h1>
        <p>Halaman ini sedang dalam pengembangan. Mohon tunggu, dan kami akan segera kembali dengan lebih banyak dokumentasi prestasi siswa.</p>
        <a href="index.php" class="btn-coming-soon">Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
