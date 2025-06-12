<?php
include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data_SNBP.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
  <th>NIS</th>
  <th>NISN</th>
  <th>Nama Siswa</th>
  <th>Komptensi Keahlian</th>
  <th>Universitas</th>
  <th>Program Studi</th>
  <th>Tahun</th>
</tr>";

$query = mysqli_query($koneksi, "SELECT * FROM spmb ORDER BY tahun DESC");
while ($row = mysqli_fetch_assoc($query)) {
    echo "<tr>
      <td>{$row['nis']}</td>
      <td>{$row['nisn']}</td>
      <td>{$row['nama_siswa']}</td>
      <td>{$row['jurusan']}</td>
      <td>{$row['universitas']}</td>
      <td>{$row['prodi']}</td>
      <td>{$row['tahun']}</td>
    </tr>";
}
echo "</table>";
?>