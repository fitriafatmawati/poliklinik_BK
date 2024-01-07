<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=jadwalDokter");
    exit;
}
?>
<h2>Jadwal Dokter</h2>
<br>

<div class="container"></div>
