<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=profilDokter");
    exit;
}
?>
<h2>Profil Dokter</h2>
<br>

<div class="container"></div>
