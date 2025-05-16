<?php
session_start();
include 'koneksi.php';
require_once 'fungsi_log.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'operator'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa     = isset($_POST['nama_siswa']) ? trim($_POST['nama_siswa']) : '';
    $nis      = $_POST['nis'];
    $nisn     = $_POST['nisn'];
    $jurusan  = $_POST['jurusan'];
    $lomba    = $_POST['nama_lomba'];
    $tingkat  = $_POST['tingkat'];
    $juara    = $_POST['juara'];
    $tahun    = $_POST['tahun'];
    $kategori = $_POST['kategori'];

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
    $stmt->bind_param("ssssssssss",$nama_siswa, $nis, $nisn, $jurusan, $lomba, $tingkat, $juara, $tahun, $kategori, $foto);

    if ($stmt->execute()) {
        simpan_log($koneksi, $_SESSION['username'], "Menambahkan data prestasi NIS $nis");
        header("Location: tambah_prestasi.php?pesan=sukses");
exit();
    } else {
        header("Location: tambah_prestasi.php?pesan=gagal");
exit();

    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Prestasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #list_nama_siswa {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: white;
            z-index: 999;
            width: 100%;
        }
        .item-siswa {
            padding: 5px 10px;
            cursor: pointer;
        }
        .item-siswa:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body class="container py-5">
    <h2 class="mb-4">Form Tambah Prestasi Siswa</h2>
    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="row g-3">
            <div class="col-md-6 position-relative">
                <label>Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" required>
                <ul id="list_nama_siswa" class="list-group mt-1"></ul>
            </div>
            <div class="col-md-6">
                <label>NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
                <label>NISN</label>
                <input type="text" name="nisn" id="nisn" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Jurusan</label>
                <select name="jurusan" id="jurusan" class="form-control" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <?php
                    $query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE status = 'Aktif' ORDER BY nama_jurusan ASC");
                    while ($row = mysqli_fetch_assoc($query_jurusan)) {
                        echo '<option value="' . htmlspecialchars($row['nama_jurusan']) . '">' . htmlspecialchars($row['nama_jurusan']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Nama Lomba</label>
                <input type="text" name="nama_lomba" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Tingkat</label>
                <select name="tingkat" class="form-control" required>
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
                <label>Juara</label>
                <select name="juara" class="form-control" required>
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
                <label>Tahun</label>
                <input type="date" name="tahun" class="form-control">
            </div>
            <div class="col-md-12">
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control">
            </div>
            <div class="col-md-12">
                <label>Upload Foto Bukti</label>
                <input type="file" name="foto_bukti" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="semua_prestasi.php" class="btn btn-secondary mt-3">Kembali</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function(){
        $('#nama_siswa').keyup(function(){
            let query = $(this).val();
            if (query !== '') {
                $.ajax({
                    url: "cari_siswa.php",
                    method: "POST",
                    data: { query: query },
                    success: function(data){
                        $('#list_nama_siswa').fadeIn().html(data);
                    }
                });
            } else {
                $('#list_nama_siswa').fadeOut();
            }
        });

        $(document).on('click', '.item-siswa', function(){
            $('#nama_siswa').val($(this).text());
            $('#nis').val($(this).data('nis'));
            $('#nisn').val($(this).data('nisn'));
            $('#jurusan').val($(this).data('jurusan'));
            $('#list_nama_siswa').fadeOut();
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
