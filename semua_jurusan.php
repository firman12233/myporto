<?php
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar

if (isset($_POST['edit_submit'])) {
  $id = intval($_POST['id_jurusan']);
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);

  $query_update = "UPDATE jurusan SET nama_jurusan = '$nama' WHERE id_jurusan = $id";
  if (mysqli_query($koneksi, $query_update)) {
      echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: 'Jurusan berhasil diperbarui!',
                  timer: 2000,
                  showConfirmButton: false
              }).then(() => {
                  window.location.href = 'semua_jurusan.php';
              });
          });
      </script>";
  } else {
      echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Gagal memperbarui jurusan.',
              });
          });
      </script>";
  }
}

// Cek apakah parameter 'aksi' dan 'id' ada di URL
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengambil ID jurusan dan memastikan itu adalah angka
    $aksi = $_GET['aksi']; // Menyimpan aksi yang dipilih (aktifkan/nonaktifkan)

    // Menentukan status baru berdasarkan aksi
    $statusBaru = '';
    if ($aksi == 'aktifkan') {
        $statusBaru = 'Aktif'; // Status baru untuk diaktifkan
    } elseif ($aksi == 'nonaktifkan') {
        $statusBaru = 'Nonaktif'; // Status baru untuk dinonaktifkan
    }

    // Jika status baru sudah ditentukan, lakukan update ke database
    if ($statusBaru !== '') {
        // Prepared statement untuk keamanan
        $query = "UPDATE jurusan SET status = ? WHERE id_jurusan = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'si', $statusBaru, $id);
        
        // Menjalankan query dan memeriksa hasilnya
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Jurusan berhasil diperbarui'); window.location.reload(true);</script>";
        } else {
            echo "<script>alert('Gagal memperbarui status jurusan');</script>";
        }

        // Debugging: Memeriksa apakah query benar-benar berjalan
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Berhasil mengubah status
            echo "<script>console.log('Status berhasil diperbarui');</script>";
        } else {
            // Tidak ada baris yang terpengaruh
            echo "<script>console.log('Tidak ada perubahan pada status');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Jurusan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 20px;
    }
    .btn-primary, .btn-success, .btn-warning {
      border-radius: 12px;
    }
  </style>
</head>
<body>
<div class="container pt-5 mt-5">
  <div>
    <!-- Tombol Kembali -->
    <a href="index.php" class="btn btn-secondary">
      &larr; Kembali
    </a>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Dashboard Jurusan</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Jurusan</button>
  </div>
  <div class="card shadow-sm p-4">
    <div class="table-responsive">
      <table id="tabelJurusan" class="table table-hover text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Jurusan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
          if (!$query_jurusan) {
            die('Query gagal: ' . mysqli_error($koneksi));
          }
          while ($row = mysqli_fetch_assoc($query_jurusan)) :
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td class="text-start"><?= htmlspecialchars($row['nama_jurusan']) ?></td>
            <td>
              <?php if ($row['status'] == 'Aktif') : ?>
                <span class="badge bg-success">Aktif</span>
              <?php else : ?>
                <span class="badge bg-danger">Nonaktif</span>
              <?php endif; ?>
            </td>
            <td>
              <button 
                class="btn btn-info btn-sm mb-1" 
                onclick="editJurusan('<?= htmlspecialchars($row['id_jurusan']) ?>', '<?= htmlspecialchars($row['nama_jurusan']) ?>')">
                Edit
              </button>

              <?php if ($row['status'] == 'Aktif') : ?>
                <button 
                  class="btn btn-warning btn-sm" 
                  onclick="konfirmasiStatus('<?= htmlspecialchars($row['id_jurusan']) ?>', 'Nonaktif')">
                  Nonaktifkan
                </button>
              <?php else : ?>
                <button 
                  class="btn btn-success btn-sm" 
                  onclick="konfirmasiStatus('<?= htmlspecialchars($row['id_jurusan']) ?>', 'Aktif')">
                  Aktifkan
                </button>
              <?php endif; ?>
              <button 
              class="btn btn-danger btn-sm mb-1" 
              onclick="hapusJurusan(<?= $row['id_jurusan'] ?>)">
               Hapus
              </button>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="tambah_jurusan.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Jurusan</label>
          <input type="text" name="nama_jurusan" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Jurusan -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="semua_jurusan.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_jurusan" id="edit_id">
        <div class="mb-3">
          <label class="form-label">Nama Jurusan</label>
          <input type="text" name="nama_jurusan" id="edit_nama" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit_submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
<!-- Bootstrap & DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// Fungsi konfirmasiStatus
function konfirmasiStatus(id, statusBaru) {
  // Menampilkan SweetAlert konfirmasi
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Anda akan mengubah status jurusan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, ubah status!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Jika konfirmasi diterima, lakukan pengubahan status
      const url = 'ubah_status_jurusan.php?aksi=' + statusBaru.toLowerCase() + '&id=' + id;
      console.log('URL untuk update status: ' + url); // Debugging URL
      window.location.href = url;
    }
  });
}
function hapusJurusan(id) {
  Swal.fire({
    title: 'Hapus Jurusan?',
    text: "Data jurusan yang dihapus tidak bisa dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'hapus_jurusan.php?id=' + id;
    }
  });
}
// Fungsi editJurusan (sudah ada)
function editJurusan(id, nama) {
  $('#edit_id').val(id);
  $('#edit_nama').val(nama);
  var editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
  editModal.show();
}

// DataTables
$(document).ready(function() {
  $('#tabelJurusan').DataTable({
    language: {
      search: "Cari Jurusan:",
      lengthMenu: "Tampilkan MENU data",
      info: "Menampilkan START sampai END dari TOTAL data",
      paginate: {
        previous: "Sebelumnya",
        next: "Berikutnya"
      }
    }
  });
});
</script>
<script>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah_sukses'): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Jurusan berhasil ditambahkan!',
        timer: 2000,
        showConfirmButton: false
    });
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah_gagal'): ?>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menambahkan jurusan.'
    });
<?php endif; ?>
</script>
<script>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus_sukses'): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Jurusan berhasil dihapus!',
        timer: 2000,
        showConfirmButton: false
    });
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus_gagal'): ?>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menghapus jurusan.'
    });
<?php endif; ?>
</script>
</body>
</html>