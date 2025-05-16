<?php
session_start();
include_once 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die('Akses ditolak. Hanya admin yang dapat menambahkan akun.');
}

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($konfirmasi) || empty($role)) {
        $pesan = 'Semua field harus diisi.';
    } elseif ($password !== $konfirmasi) {
        $pesan = 'Password dan konfirmasi tidak cocok.';
    } else {
        $stmt = $koneksi->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $pesan = 'Username sudah terdaftar.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare("INSERT INTO admin (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $role);
            if ($stmt->execute()) {
                $pesan = 'Akun berhasil ditambahkan!';
            } else {
                $pesan = 'Gagal menambahkan akun.';
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin/Operator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Akun Admin / Operator</h2>
        <?php if (!empty($pesan)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($pesan) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="konfirmasi_password" class="form-label">Konfirmasi Password:</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Peran:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="operator">Operator</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Tambah Akun</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
