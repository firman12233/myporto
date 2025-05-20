<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'operator'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = $_POST['nama_siswa'];
    $nis        = $_POST['nis'];
    $nisn       = $_POST['nisn'];
    $jurusan    = $_POST['jurusan'];
    $universitas = $_POST['universitas']; 
    $prodi      = $_POST['prodi'];
    $tahun      = $_POST['tahun'];

    $query_check_nis = "SELECT nis FROM siswa WHERE nis = ?";
    $stmt_check_nis = $koneksi->prepare($query_check_nis);
    $stmt_check_nis->bind_param("s", $nis);
    $stmt_check_nis->execute();
    $result = $stmt_check_nis->get_result();

    if ($result->num_rows == 0) {
        header("Location: tambah_spmb.php?pesan=nis_tidak_ada");
        exit();
    }

    $foto = '';
    if (!empty($_FILES['foto_siswa']['name'])) {
        $foto = uniqid() . '_' . basename($_FILES['foto_siswa']['name']);
        move_uploaded_file($_FILES['foto_siswa']['tmp_name'], 'uploads/' . $foto);
    }

    $stmt = $koneksi->prepare("INSERT INTO spmb (nama_siswa, nis, nisn, jurusan, universitas, prodi, tahun, foto_siswa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama_siswa, $nis, $nisn, $jurusan, $universitas, $prodi, $tahun, $foto);

    if ($stmt->execute()) {
        simpan_log($koneksi, $_SESSION['username'], "Menambahkan data SNBP $nis");
        header("Location: tambah_spmb.php?pesan=sukses");
        exit();
    } else {
        header("Location: tambah_spmb.php?pesan=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data SPMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2 class="mb-4">Form Tambah Data SPMB</h2>

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" name="nisn" id="nisn" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" name="jurusan" id="jurusan" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="universitas" class="form-label">Universitas</label>
                <input type="text" name="universitas" id="universitas" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="text" name="tahun" id="tahun" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label>Foto Siswa</label>
                <input type="file" name="foto_siswa" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="semua_spmb.php" class="btn btn-secondary mt-3">Kembali</a>
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#nis').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                let nis = $(this).val().trim();

                if (nis.length > 0) {
                    $.ajax({
                        url: 'get_siswa.php',
                        method: 'GET',
                        dataType: 'json',
                        data: { nis: nis },
                        success: function(data) {
                            if (data && data.nama && data.nisn && data.jurusan) {
                                $('#nama_siswa').val(data.nama);
                                $('#nisn').val(data.nisn);
                                $('#jurusan').val(data.jurusan);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data tidak ditemukan',
                                    text: 'NIS yang dimasukkan tidak ada di database siswa.'
                                });
                                $('#nama_siswa').val('');
                                $('#nisn').val('');
                                $('#jurusan').val('');
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengambil data siswa.'
                            });
                        }
                    });
                }
            }
        });
    });
    </script>

    <?php if (isset($_GET['pesan'])): ?>
    <script>
        <?php if ($_GET['pesan'] == 'sukses'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data SPMB berhasil disimpan!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'semua_spmb.php';
            });
        <?php elseif ($_GET['pesan'] == 'gagal'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan data!',
            });
        <?php elseif ($_GET['pesan'] == 'nis_tidak_ada'): ?>
            Swal.fire({
                icon: 'warning',
                title: 'NIS tidak ditemukan!',
                text: 'Data siswa tidak terdaftar di tabel siswa.',
            });
        <?php endif; ?>
    </script>
    <?php endif; ?>

</body>
</html>
