<?php
include 'koneksi.php';

if (isset($_POST['query'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST['query']);

    $query = "SELECT * FROM siswa WHERE nama_siswa LIKE '%$keyword%' ORDER BY nama_siswa ASC LIMIT 10";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="list-group-item item-siswa"
                    data-nis="' . htmlspecialchars($row['nis']) . '"
                    data-nisn="' . htmlspecialchars($row['nisn']) . '"
                    data-jurusan="' . htmlspecialchars($row['jurusan']) . '">'
                    . htmlspecialchars($row['nama_siswa']) .
                 '</li>';
        }
    } else {
        echo '<li class="list-group-item text-muted">Tidak ditemukan</li>';
    }
}
?>
