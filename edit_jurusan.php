<?php
// edit_jurusan.php
include 'koneksi.php';
require_once 'fungsi_log.php';

if (!isset($_GET['id'])) {
    header('Location: semua_jurusan.php');
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE id_jurusan = $id");
$jurusan = mysqli_fetch_assoc($query);

if (!$jurusan) {
    echo "<script>alert('Jurusan tidak ditemukan!'); window.location='semua_jurusan.php';</script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $nama_jurusan = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);

    $update = mysqli_query($koneksi, "UPDATE jurusan SET nama_jurusan='$nama_jurusan' WHERE id_jurusan=$id");

    if ($update) {
        echo "<script>alert('Jurusan berhasil diperbarui!'); window.location='semua_jurusan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui jurusan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jurusan</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #2196F3;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #1976D2;
        }
        .kembali {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #2196F3;
            text-decoration: none;
            font-size: 14px;
        }
        .kembali:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Jurusan</h2>
    <form method="post">
        <input type="text" name="nama_jurusan" placeholder="Nama Jurusan" value="<?= htmlspecialchars($jurusan['nama_jurusan']) ?>" required>
        <button type="submit" name="update">Simpan Perubahan</button>
    </form>
    <a href="semua_jurusan.php" class="kembali">Kembali ke Daftar Jurusan</a>
</div>

</body>
</html>