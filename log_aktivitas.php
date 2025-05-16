<?php
session_start();
include 'koneksi.php';

// Hanya admin yang boleh mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$logs = mysqli_query($koneksi, "SELECT * FROM log_aktivitas ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas</title>
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
                $no = 1;
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

    <a href="index.php" class="btn btn-secondary position-fixed bottom-0 start-0 m-3">
    &larr; Kembali
</div>
</body>
</html>