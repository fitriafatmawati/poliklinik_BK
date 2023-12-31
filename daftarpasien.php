<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $no_rm = $_POST['no_rm'];

        $query = "SELECT * FROM pasien WHERE no_rm = '$no_rm'";
        $result = $mysqli->query($query);

        if (!$result) {
            die("Query error: " . $mysqli->error);
        }

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['nama'] = $nama;
            $_SESSION['id_pasien'] = $row['id'];
            header("Location: index.php?page=daftarpoli&no_rm=$no_rm");
        } else {
            $error = "No. Rekam Medis tidak ditemukan";
        }
    }
?>

<div class="container d-flex justify-content-center align-items-center" style="margin-top: 5rem;">
    <div class="row align-items-center">
        <div class="header-text mb-4">
            <h2 class="text-center">Cek Nomor RM</h2>
        </div>
        <form method="POST" action="index.php?page=daftarPasien">
            <?php
                if (isset($error)) {
                    echo '<div class="alert alert-danger">' . $error . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            ?>
            <div class="form-group mb-3">
                <label for="no_rm">Nomor RM</label> 
                <input type="text" name="no_rm" class="form-control form-control-lg bg-light fs-6" placeholder="Enter your nomorrm" required>
            </div>
            
            <div class="form-group mb-3">
                <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Cari</button>
            </div>
            <div class="text-center">
                <p class="mt-3"><a href="index.php?page=daftarpasienbaru">Daftar pasien baru</a></p>
            </div>
        </form>
    </div>
</div>