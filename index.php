<?php
session_start();
include_once 'koneksi.php';
$role = $_SESSION['role'] ?? null;
$username = $_SESSION['username'] ?? null;

// Ambil jumlah prestasi berdasarkan tingkat
$tingkatData = [];
$query = $koneksi->query("SELECT tingkat, COUNT(*) as jumlah FROM prestasi GROUP BY tingkat");
while ($row = $query->fetch_assoc()) {
    $tingkatData[$row['tingkat']] = $row['jumlah'];
}
// Ambil data rekap SPMB
$spmbData = [];
$qspmb = $koneksi->query("SELECT universitas, COUNT(*) as jumlah FROM spmb GROUP BY universitas");
while ($row = $qspmb->fetch_assoc()) {
    $spmbData[$row['universitas']] = $row['jumlah'];
}

$total_spmb = $koneksi->query("SELECT COUNT(*) as total FROM spmb")->fetch_assoc()['total'];

// Total prestasi
$total = $koneksi->query("SELECT COUNT(*) as total FROM prestasi")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Smeansawi Berprestasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Smeansawi Berprestasi</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="semua_prestasi.php">Prestasi</a></li>
          <li class="nav-item"><a class="nav-link" href="semua_spmb.php">SNBP</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">Others</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="galeri.php">Gallery</a></li>
              <li><a class="dropdown-item" href="sosmed.php">Sosmed</a></li>
              <li><hr class="dropdown-divider"></li>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link text-dark " href="log_aktivitas.php">Log Aktivitas</a>
                <li class="nav-item"><a class="nav-link text-dark " href="tambah_siswa.php">Tambah Siswa</a>
                <li class="nav-item"><a class="nav-link text-dark " href="semua_jurusan.php">Tambah Jurusan</a>
                <li class="nav-item"><a class="nav-link text-dark " href="tambah_admin.php">Tambah Admin</a>
</li>
<?php endif; ?>
            </ul>
          </li>
        </ul>
        <?php if ($role === 'admin' || $role === 'operator'): ?>
  <div class="text-white me-3">Halo, <?= htmlspecialchars($username) ?></div>
  <a href="#" class="nav-link text-white btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
<?php else: ?>
  <form class="d-flex">
    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
  </form>
<?php endif; ?>
        </form>
        <?php if ($role === 'public'): ?>
<!-- Modal Login -->
<div class="modal fade" id="exampleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="login.php" method="post">
        ...
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
      </div>
    </div>
  </nav>

  <?php
$totalSemua = array_sum($tingkatData);
function persen($jumlah, $total) {
  return $total > 0 ? round(($jumlah / $total) * 100) : 0;
}
?>
<!-- Rekap Prestasi dengan Ikon dan Progress -->
<div class="container py-5 mt-5">
  <h2 class="mb-4 text-center">Rekap Jumlah Prestasi</h2>
  <div class="row justify-content-center g-4">

    <!-- Nasional -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-info text-center">
        <div class="card-body">
          <i class="bi bi-flag fs-1 mb-2"></i>
          <h6 class="card-title">Nasional</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Nasional'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Nasional'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Provinsi -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-warning text-center">
        <div class="card-body">
          <i class="bi bi-globe-asia-australia fs-1 mb-2"></i>
          <h6 class="card-title">Provinsi</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Provinsi'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Provinsi'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Keresidenan -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-danger text-center">
        <div class="card-body">
          <i class="bi bi-house-door fs-1 mb-2"></i>
          <h6 class="card-title">Keresidenan</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Keresidenan'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Keresidenan'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kabupaten -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-primary text-center">
        <div class="card-body">
          <i class="bi bi-building fs-1 mb-2"></i>
          <h6 class="card-title">Kabupaten</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Kabupaten'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Kabupaten'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kecamatan -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-success text-center">
        <div class="card-body">
          <i class="bi bi-geo fs-1 mb-2"></i>
          <h6 class="card-title">Kecamatan</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Kecamatan'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Kecamatan'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

       <!-- Sekolah -->
       <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-secondary text-center">
        <div class="card-body">
          <i class="bi bi-mortarboard fs-1 mb-2"></i>
          <h6 class="card-title">Sekolah</h6>
          <p class="fs-4 mb-2"><?php echo $tingkatData['Sekolah'] ?? 0; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: <?= persen($tingkatData['Sekolah'] ?? 0, $totalSemua) ?>%"></div>
          </div>
        </div>
      </div>
    </div>

      <!-- Total Prestasi -->
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="card text-white bg-dark text-center">
        <div class="card-body">
          <i class="bi bi-award fs-1 mb-2"></i>
          <h6 class="card-title">Total</h6>
          <p class="fs-4 mb-2"><?php echo $total; ?></p>
          <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-light" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


<h2 class="mb-4 text-center">Total Siswa Lolos SNBP</h2>

<div class="d-flex justify-content-center">
  <div class="card shadow-lg border-0 bg-success text-white" style="max-width: 400px; width: 100%;">
    <div class="card-body text-center py-4">
      <h1 id="animatedNumber" class="display-4 fw-bold">0</h1>
      <p class="fs-5 mb-0">Siswa diterima di perguruan tinggi</p>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    anime({
      targets: '#animatedNumber',
      innerHTML: [0, <?= $total_spmb; ?>],
      easing: 'easeInOutQuad',
      round: 1,
      duration: 3000
    });
  });
</script>
  <!-- Modal Login -->
  <div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="login.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-2">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required />
            </div>
            <div class="form-group mb-2">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Yakin ingin keluar dari sistem?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Ya, Keluar</a>
      </div>
    </div>
  </div>
</div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <script>
function confirmLogout() {
    return confirm("Yakin ingin keluar?");
}
</script>
</body>
</html>