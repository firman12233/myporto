<?php
include 'koneksi.php';

// Ambil jumlah total pendaftar
$total_spmb = $conn->query("SELECT COUNT(*) AS total FROM spmb")->fetch_assoc()['total'];

// Ambil jumlah berdasarkan universitas
$universitasData = [];
$q = $conn->query("SELECT universitas, COUNT(*) as jumlah FROM spmb GROUP BY universitas");
while ($row = $q->fetch_assoc()) {
    $universitasData[$row['universitas']] = $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rekap SPMB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="container py-5 mt-4">
    <h2 class="mb-4 text-center text-success">Rekap Jumlah SPMB Siswa SMKN 1 Slawi</h2>

    <div class="row">
      <?php foreach ($universitasData as $univ => $jumlah): ?>
        <div class="col-md-4 mb-3">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h5 class="card-title"><?php echo $univ; ?></h5>
              <p class="card-text fs-4"><?php echo $jumlah; ?> siswa</p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Total -->
    <div class="card bg-light border-dark mt-3">
      <div class="card-body text-center">
        <h5 class="card-title">Total Siswa yang Lolos SPMB</h5>
        <p class="fs-4 fw-bold"><?php echo $total_spmb; ?> siswa</p>
      </div>
    </div>

    <a href="index.php" class="btn btn-secondary mt-4">Kembali ke Beranda</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>