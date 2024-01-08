<?php
if (!isset($_SESSION)) {
    session_start();
}

    include_once("koneksi.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik PANASEA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-expand-lg navbar-dark bg-dark pt-2 ps-4 pe-3 shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">klinik PANASEA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-white" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php?page=daftarPasien">Daftar Pasien</a>
                    </li>
                    <?php
                        if (isset($_SESSION['username'])){
                            //menu master jika user sudah login 
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=obat">Obat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=dokter">Dokter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=poli">Poli</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=pasien">Pasien</a>
                        </li>
                    <?php 
                        } 
                    ?>
                </ul>
                <?php
                    if (isset($_SESSION['username'])) {
                        // Jika pengguna sudah login, tampilkan tombol "Logout"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="logoutUser.php">Logout (<?php echo $_SESSION['username'] ?>)</a>
                            </li>
                        </ul>
                    <?php
                    } else {
                        // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="index.php?page=registerUser">Register</a>
                            </li> -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="index.php?page=loginUser">Admin</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="index.php?page=loginDokter">Dokter</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    }
                ?>
            </div>
        </div>
    </nav>

    <main role="main" class="container">
        <?php
            if (isset($_GET['page'])) {
                include($_GET['page'] . ".php");
            } else {
                echo "<h3>Selamat Datang di Sistem Informasi Poliklinik";

                if (isset($_SESSION['username'])) {
                    //jika sudah login tampilkan username
                    echo ", " . $_SESSION['username'] . "</h3> <hr>";
                } else {
                    echo '
                    <section class="about_section pt-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 ">
                                    <div class="img-box">
                                        <img src="img/poli.jpg" alt="">
                                        <img src="img/dokter.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-box">
                                        <div class="heading_container">
                                            <h3>
                                                Selamat datang di Poliklinik PANASEA! <span></span>
                                            </h3>
                                        </div>
                                        <p class="aboutpoli">
                                        Klinik Kami menyediakan pelayanan kesehatan untuk pasien.
                                        Terdapat beberapa pilihan poli untuk keluhan yang berbeda, pasien dapat memilih poli sesuai keluhan yang dirasakan.
                                        Klinik PANASEA untuk kita semua.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    ';
                }
            }
        ?>
    </main>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>