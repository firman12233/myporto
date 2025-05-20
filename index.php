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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<body>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="assets/logo-smkn1slawi.png" alt="Logo SMK N 1 Slawi" class="img-fluid me-2" style="max-height: 50px;">
      <span class="fw-bold">SMK Negeri 1 Slawi</span>
    </a>
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
            <li><a class="dropdown-item" href="gallery.php">Gallery</a></li>
            <li><a class="dropdown-item" href="sosmed.php">Sosmed</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a class="dropdown-item" href="log_aktivitas.php">Log Aktivitas</a></li>
              <li><a class="dropdown-item" href="tambah_siswa.php">Tambah Siswa</a></li>
              <li><a class="dropdown-item" href="semua_jurusan.php">Tambah Jurusan</a></li>
              <li><a class="dropdown-item" href="tambah_admin.php">Tambah Admin</a></li>
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
<!-- Bagian GABUNGAN: Rekap Prestasi & Total Siswa Lolos SNBP -->
<div class="container py-5 mt-5">
  <style>
    .rekap-card {
      transition: all 0.3s ease-in-out;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .rekap-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .rekap-icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .rekap-title {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .rekap-number {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .rekap-progress {
      height: 6px;
      border-radius: 3px;
      overflow: hidden;
    }

    .section-divider {
      width: 60px;
      height: 4px;
      background-color: #0d6efd;
      border-radius: 2px;
      margin: 0.5rem auto 1rem;
    }

    .card-lolos {
      transition: all 0.3s ease-in-out;
      border-radius: 1rem;
    }

    .card-lolos:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
  </style>

  <!-- Bagian 1: Rekap Jumlah Prestasi -->
  <h2 class="text-center fw-bold">Rekap Jumlah Prestasi</h2>
  <div class="section-divider"></div>

  <div class="row justify-content-center g-4">
    <?php
    $cards = [
      ['label' => 'Nasional', 'icon' => 'bi-flag', 'color' => 'info'],
      ['label' => 'Provinsi', 'icon' => 'bi-globe-asia-australia', 'color' => 'warning'],
      ['label' => 'Keresidenan', 'icon' => 'bi-house-door', 'color' => 'danger'],
      ['label' => 'Kabupaten', 'icon' => 'bi-building', 'color' => 'primary'],
      ['label' => 'Kecamatan', 'icon' => 'bi-geo', 'color' => 'success'],
      ['label' => 'Sekolah', 'icon' => 'bi-mortarboard', 'color' => 'secondary'],
      ['label' => 'Total', 'icon' => 'bi-award', 'color' => 'dark', 'total' => true],
    ];

    foreach ($cards as $card) {
      $jumlah = $card['total'] ?? false ? $total : ($tingkatData[$card['label']] ?? 0);
      $persen = $card['total'] ?? false ? 100 : persen($jumlah, $totalSemua);
    ?>
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card text-white bg-<?= $card['color'] ?> text-center rekap-card h-100">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
            <i class="bi <?= $card['icon'] ?> rekap-icon"></i>
            <div class="rekap-title"><?= $card['label'] ?></div>
            <div class="rekap-number"><?= $jumlah ?></div>
            <div class="rekap-progress w-100 bg-white bg-opacity-25">
              <div class="progress-bar bg-light" style="width: <?= $persen ?>%; transition: width 0.6s;"></div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Bagian 2: Total Siswa Lolos SNBP -->
  <div class="mt-5">
    <h2 class="text-center fw-bold">Total Siswa Lolos SNBP</h2>
    <div class="section-divider" style="background-color: #198754;"></div>

    <div class="d-flex justify-content-center">
      <div class="card shadow-lg border-0 bg-success text-white card-lolos" style="max-width: 400px; width: 100%;">
        <div class="card-body text-center py-4">
          <h1 id="animatedNumber" class="display-4 fw-bold">0</h1>
          <p class="fs-5 mb-0">Siswa diterima di perguruan tinggi</p>
        </div>
      </div>
    </div>
  </div>


  <!-- Script animasi angka -->
  <script>
    const target = <?= $totalLolos ?>; // Ganti dengan nilai PHP sesuai jumlah siswa SNBP
    const element = document.getElementById("animatedNumber");
    let current = 0;
    const duration = 1000;
    const steps = 30;
    const increment = target / steps;
    const interval = duration / steps;

    const counter = setInterval(() => {
      current += increment;
      if (current >= target) {
        current = target;
        clearInterval(counter);
      }
      element.textContent = Math.floor(current);
    }, interval);
  </script>
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