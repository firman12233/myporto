<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

// Cek login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Arahkan sesuai role
        if ($data['role'] === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: index.php"); // kamu bisa ganti sesuai halaman operator
        }
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
  <h2 class="mb-4">Login Admin / Operator</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary" type="submit">Login</button>
  </form>
</body>
</html>