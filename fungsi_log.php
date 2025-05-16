<?php

function simpan_log($koneksi, $user, $aktivitas) {
    $aktivitas = mysqli_real_escape_string($koneksi, $aktivitas);
    mysqli_query($koneksi, "INSERT INTO log_aktivitas (user, aktivitas) VALUES ('$user', '$aktivitas')");
}
?>