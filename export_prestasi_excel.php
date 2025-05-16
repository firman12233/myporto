<?php
include 'koneksi.php';

// Bersihkan output
ob_clean();
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data_Prestasi_Siswa.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Mulai buat tabel
echo "<table border='1'>";
echo "<tr>
<th>NIS</th>
<th>NISN</th>
<th>Nama Siswa</th>
<th>Jurusan</th>
<th>Prestasi</th>
<th>Juara</th>
<th>Tingkat</th>
<th>Tahun</th>
<th>Kategori</th>
</tr>";

$query = "SELECT * FROM prestasi ORDER BY tahun DESC";
$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['nis'] . "</td>";
    echo "<td>" . $row['nisn'] . "</td>";
    echo "<td>" . $row['nama_siswa'] . "</td>";
    echo "<td>" . $row['jurusan'] . "</td>";
    echo "<td>" . $row['nama_lomba'] . "</td>";
    echo "<td>" . $row['juara'] . "</td>";
    echo "<td>" . $row['tingkat'] . "</td>";
    echo "<td>" . date('Y', strtotime($row['tahun'])) . "</td>";
    echo "<td>" . $row['kategori'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>