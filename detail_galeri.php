<?php
// detail_galeri.php
session_start();
include 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gallery.php");
    exit;
}

$id = (int)$_GET['id'];

$query = "SELECT g.judul, g.deskripsi, g.tanggal, f.nama_file
          FROM gallery g
          LEFT JOIN gallery_foto f ON g.id = f.gallery_id
          WHERE g.id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$galeri = ['foto' => []];
while ($row = $result->fetch_assoc()) {
    $galeri['judul'] = $row['judul'];
    $galeri['deskripsi'] = $row['deskripsi'];
    $galeri['tanggal'] = $row['tanggal'];
    if (!empty($row['nama_file'])) {
        $galeri['foto'][] = $row['nama_file'];
    }
}

if (empty($galeri['judul'])) {
    echo "<div style='padding: 20px;'>Galeri tidak ditemukan. <a href='gallery.php'>Kembali</a></div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($galeri['judul']) ?> - Detail Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .foto-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <a href="gallery.php" class="btn btn-secondary mb-4">&larr; Kembali ke Galeri</a>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($galeri['judul']) ?></h2>
            <p class="text-muted">Tanggal: <?= date('d F Y', strtotime($galeri['tanggal'])) ?></p>
            <p><?= nl2br(htmlspecialchars($galeri['deskripsi'])) ?></p>
        </div>
    </div>

    <?php if (!empty($galeri['foto'])): ?>
        <div class="row">
            <?php foreach ($galeri['foto'] as $index => $foto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Thumbnail dengan data-bs-toggle modal -->
                        <img src="uploads/gallery/<?= htmlspecialchars($foto) ?>" 
                             class="foto-thumbnail" 
                             alt="Foto Galeri"
                             data-bs-toggle="modal"
                             data-bs-target="#previewModal"
                             data-bs-foto="uploads/gallery/<?= htmlspecialchars($foto) ?>"
                             data-bs-alt="Foto Galeri <?= $index + 1 ?>"
                        >
                        <div class="card-body text-center">
                            <a href="uploads/gallery/<?= htmlspecialchars($foto) ?>" download class="btn btn-outline-primary btn-sm">Download Foto</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Tidak ada foto dalam galeri ini.</div>
    <?php endif; ?>
</div>

<!-- Modal Preview Foto -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white" id="previewModalLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 text-center">
        <img src="" id="previewImage" alt="" style="width: 100%; max-height: 80vh; object-fit: contain; border-radius: 5px;">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Tangkap event saat modal akan muncul
const previewModal = document.getElementById('previewModal')
previewModal.addEventListener('show.bs.modal', event => {
    // Tombol/image yang memicu modal
    const triggerElement = event.relatedTarget
    // Ambil atribut data dari thumbnail
    const fotoSrc = triggerElement.getAttribute('data-bs-foto')
    const fotoAlt = triggerElement.getAttribute('data-bs-alt')
    const modalTitle = previewModal.querySelector('.modal-title')
    const modalImage = previewModal.querySelector('#previewImage')

    modalImage.src = fotoSrc
    modalImage.alt = fotoAlt
    modalTitle.textContent = fotoAlt
})
</script>
</body>
</html>
