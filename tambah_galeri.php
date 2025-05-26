<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'operator'])) {
    header("Location: login.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal = date('Y-m-d');

    if (empty($judul) || empty($deskripsi)) {
        $error = "Judul dan deskripsi harus diisi.";
    } elseif (empty($_FILES['foto']['name'][0])) {
        $error = "Minimal satu foto harus diunggah.";
    } else {
        // Simpan data galeri
        $stmt = $koneksi->prepare("INSERT INTO gallery (judul, deskripsi, tanggal) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $judul, $deskripsi, $tanggal);

        if ($stmt->execute()) {
            $gallery_id = $stmt->insert_id;

            $foto_berhasil = 0;
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($_FILES['foto']['name'] as $key => $nama_file) {
                $tmp_name = $_FILES['foto']['tmp_name'][$key];
                $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed_ext)) {
                    $error = "File $nama_file bukan format gambar yang diperbolehkan.";
                    break;
                }

                $nama_baru = uniqid('galeri_') . '.' . $ext;
                $tujuan = 'uploads/gallery/' . $nama_baru;

                if (move_uploaded_file($tmp_name, $tujuan)) {
                    $stmtFoto = $koneksi->prepare("INSERT INTO gallery_foto (gallery_id, nama_file) VALUES (?, ?)");
                    $stmtFoto->bind_param("is", $gallery_id, $nama_baru);
                    $stmtFoto->execute();
                    $stmtFoto->close();
                    $foto_berhasil++;
                }
            }

            if ($foto_berhasil > 0 && empty($error)) {
                simpan_log($koneksi, $_SESSION['username'], "Menambahkan galeri '$judul' dengan $foto_berhasil foto");
                header("Location: gallery.php?pesan=berhasil");
                exit();
            } elseif (empty($error)) {
                $error = "Galeri berhasil dibuat, tapi gagal menyimpan foto.";
            }
        } else {
            $error = "Gagal menyimpan data galeri.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Galeri Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
        <h3 class="mb-4">Tambah Galeri Baru</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Galeri</label>
                <input type="text" name="judul" id="judul" class="form-control" required value="<?= isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : '' ?></textarea>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Upload Foto (format jpg/jpeg/png/gif/webp, jumlah bebas)</label>
                <input type="file" name="foto[]" id="foto" class="form-control" accept="image/*" multiple required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="gallery.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
