<?php
include 'koneksi.php';

$result = $conn->query("SELECT * FROM prestasi ORDER BY tahun DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Prestasi Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Data Prestasi Siswa SMK N 1 Slawi</h2>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Nama Lomba</th>
            <th>Tingkat</th>
            <th>Juara</th>
            <th>Tahun</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = $result->fetch_assoc()):
          ?>
          <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['nis']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_lomba']); ?></td>
            <td class="text-center"><?php echo $row['tingkat']; ?></td>
            <td class="text-center"><?php echo $row['juara']; ?></td>
            <td class="text-center"><?php echo date('Y', strtotime($row['tahun'])); ?></td>
            <td><?php echo $row['kategori']; ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>