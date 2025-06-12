<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'operator'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = isset($_POST['nama_siswa']) ? trim($_POST['nama_siswa']) : '';
    $nis        = $_POST['nis'];
    $nisn       = $_POST['nisn'];
    $jurusan    = $_POST['jurusan'];
    $lomba      = $_POST['nama_lomba'];
    $tingkat    = $_POST['tingkat'];
    $juara      = $_POST['juara'];
    $tahun      = $_POST['tahun'];
    $kategori   = $_POST['kategori'];

    // Cek apakah NIS ada di tabel siswa
    $query_check_nis = "SELECT nis FROM siswa WHERE nis = ?";
    $stmt_check_nis = $koneksi->prepare($query_check_nis);
    $stmt_check_nis->bind_param("s", $nis);
    $stmt_check_nis->execute();
    $result = $stmt_check_nis->get_result();

    if ($result->num_rows == 0) {
        header("Location: tambah_prestasi.php?pesan=nis_tidak_ada");
        exit();
    }

    $foto = '';
    if (!empty($_FILES['foto_bukti']['name'])) {
        $foto = uniqid() . '_' . basename($_FILES['foto_bukti']['name']);
        move_uploaded_file($_FILES['foto_bukti']['tmp_name'], 'uploads/' . $foto);
    }

    $stmt = $koneksi->prepare("INSERT INTO prestasi (nama_siswa, nis, nisn, jurusan, nama_lomba, tingkat, juara, tahun, kategori, foto_bukti) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nama_siswa, $nis, $nisn, $jurusan, $lomba, $tingkat, $juara, $tahun, $kategori, $foto);

    if ($stmt->execute()) {
        simpan_log($koneksi, $_SESSION['username'], "Menambahkan data prestasi NIS $nis");
        header("Location: tambah_prestasi.php?pesan=sukses");
        exit();
    } else {
        header("Location: tambah_prestasi.php?pesan=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Prestasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Spinner kecil di samping input */
        #loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid #ccc;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
            right: 10px;
            top: 38px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .position-relative { position: relative; }
    </style>
</head>
<body class="container py-5">
    <h2 class="mb-4">Form Tambah Prestasi Siswa</h2>
    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="row g-3">
            <div class="col-md-4 position-relative">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" required pattern="\d+" title="Masukkan hanya angka" autofocus>
                <div id="loading-spinner"></div>
            </div>
            <div class="col-md-4">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" name="nisn" id="nisn" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="jurusan" class="form-label">Komptensi Keahlian</label>
                <input type="text" name="jurusan" id="jurusan" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="nama_lomba" class="form-label">Nama Lomba</label>
                <input type="text" name="nama_lomba" id="nama_lomba" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="tingkat" class="form-label">Tingkat</label>
                <select name="tingkat" id="tingkat" class="form-control" required>
                    <option value="" disabled selected>Pilih Tingkat</option>
                    <option>Nasional</option>
                    <option>Provinsi</option>
                    <option>Keresidenan</option>
                    <option>Kabupaten</option>
                    <option>Kecamatan</option>
                    <option>Sekolah</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="juara" class="form-label">Juara</label>
                <select name="juara" id="juara" class="form-control" required>
                    <option value="" disabled selected>Pilih</option>
                    <option>Juara 1</option>
                    <option>Juara 2</option>
                    <option>Juara 3</option>
                    <option>Juara Harapan 1</option>
                    <option>Juara Harapan 2</option>
                    <option>Juara Harapan 3</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="date" name="tahun" id="tahun" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="foto_bukti" class="form-label">Upload Foto Bukti</label>
                <input type="file" name="foto_bukti" id="foto_bukti" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="semua_prestasi.php" class="btn btn-secondary mt-3">Kembali</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function () {
        function clearFields() {
            $('#nama_siswa, #nisn, #jurusan').val('');
        }

        $('#nis').on('input', function() {
            if ($(this).val().trim() === '') {
                clearFields();
            }
        });

        $('#nis').on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const nis = $(this).val().trim();

                // Validasi input hanya angka
                if (!/^\d+$/.test(nis)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Input Salah',
                        text: 'NIS harus berupa angka saja.'
                    });
                    clearFields();
                    return;
                }

                if (nis !== '') {
                    $('#loading-spinner').show();

                    $.ajax({
                        url: 'get_siswa.php',
                        method: 'GET',
                        data: { nis: nis },
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                $('#nama_siswa').val(data.nama);
                                $('#nisn').val(data.nisn);
                                $('#jurusan').val(data.jurusan);
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Tidak ditemukan',
                                    text: 'Siswa dengan NIS tersebut tidak ditemukan!'
                                });
                                clearFields();
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak bisa mengambil data siswa.'
                            });
                            clearFields();
                        },
                        complete: function () {
                            $('#loading-spinner').hide();
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
                text: 'Data prestasi berhasil ditambahkan!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'semua_prestasi.php';
            });
        <?php elseif ($_GET['pesan'] == 'nis_tidak_ada'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'NIS tidak terdaftar dalam data siswa!',
            });
        <?php elseif ($_GET['pesan'] == 'gagal'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan!',
                text: 'Terjadi kesalahan saat menyimpan data!',
            });
        <?php endif; ?>
    </script>
    <?php endif; ?>
</body>
</html>
