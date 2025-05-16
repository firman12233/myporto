<?php
session_start();
include 'koneksi.php';

// Ambil data tingkat dan jumlahnya
$tingkatData = [];
$query = $conn->query("SELECT tingkat, COUNT(*) as jumlah FROM prestasi GROUP BY tingkat");
while ($row = $query->fetch_assoc()) {
    $tingkatData[$row['tingkat']] = $row['jumlah'];
}

// Ambil total prestasi
$total = $conn->query("SELECT COUNT(*) as total FROM prestasi")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekap Prestasi Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5 mt-5">
    <h2 class="mb-4 text-center">Rekap Jumlah Prestasi Berdasarkan Tingkat</h2>
    
    <div class="row">
      <?php foreach ($tingkatData as $tingkat => $jumlah): ?>
        <div class="col-md-3">
          <div class="card bg-info text-white mb-3">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($tingkat); ?></h5>
              <p class="card-text fs-4"><?php echo $jumlah; ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Total Prestasi -->
    <div class="card bg-light border-dark mt-3">
      <div class="card-body text-center">
        <h5 class="card-title">Total Prestasi</h5>
        <p class="fs-4 fw-bold"><?php echo $total; ?></p>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>