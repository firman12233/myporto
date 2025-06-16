<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Konfigurasi paginasi
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil total data
$total_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM log_aktivitas"))['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data sesuai halaman
$query = "SELECT * FROM log_aktivitas ORDER BY waktu DESC LIMIT $start, $limit";
$logs = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas</title>
    <link rel="icon" href="logo-smkn1slawi1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Log Aktivitas Pengguna</h2>

    <div class="table-responsive shadow rounded">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = $start + 1;
                while ($log = mysqli_fetch_assoc($logs)) { ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($log['user']) ?></td>
                    <td><?= htmlspecialchars($log['aktivitas']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($log['waktu'])) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next &raquo;</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <a href="index.php" class="btn btn-secondary position-fixed bottom-0 start-0 m-3">
        &larr; Kembali
    </a>
</div>
</body>
</html>
