<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['username'])) {
        // Jika pengguna sudah login, tampilkan tombol "Logout"
        header("Location: index.php?page=loginUser");
        exit;
    }
    
    if (isset($_POST['simpan'])) {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                nama = '" . $_POST['nama'] . "',
                alamat = '" . $_POST['alamat'] . "',
                no_ktp = '" . $_POST['no_ktp'] . "',
                no_hp = '" . $_POST['no_hp'] . "'
                WHERE
                id = '" . $_POST['id'] . "'");
        } else {
            $result = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM pasien");
            $row = mysqli_fetch_assoc($result);
            $totalPasien = $row['total'];
            
            $no_rm = date('Y') . date('m') . '-' . ($totalPasien + 1);
            $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                VALUES (
                    '" . $_POST['nama'] . "',
                    '" . $_POST['alamat'] . "',
                    '" . $_POST['no_ktp'] . "',
                    '" . $_POST['no_hp'] . "',
                    ' $no_rm '
                )");
        }
        echo "<script> 
            document.location='index.php?page=pasien';
            </script>";
    }
    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
        }
    
        echo "<script> 
                document.location='index.php?page=pasien';
            </script>";
    }
?>

<h2>Pasien</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" style="width: 30rem;" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_ktp = '';
        $no_hp = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM pasien 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_ktp = $row['no_ktp'];
                $no_hp = $row['no_hp'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNoKTP" class="form-label fw-bold">
                Nomor KTP
            </label>
            <div>
                <input type="number" class="form-control" name="no_ktp" id="inputNoKTP" placeholder="No KTP" value="<?php echo $no_ktp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNoHP" class="form-label fw-bold">
                Nomor HP
            </label>
            <div>
                <input type="number" class="form-control" name="no_hp" id="inputNoHP" placeholder="No HP" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
            <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor KTP</th>
                <th scope="col">Nomor HP</th>
                <th scope="col">Nomor RM</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM pasien");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_ktp'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=pasien&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>