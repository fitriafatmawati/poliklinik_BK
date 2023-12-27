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
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
            nama = '" . $_POST['nama'] . "',
            alamat = '" . $_POST['alamat'] . "',
            no_hp = '" . $_POST['no_hp'] . "',
            id_poli = '" . $_POST['id_poli'] . "'
            WHERE
            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp, id_poli) 
            VALUES (
                '" . $_POST['nama'] . "',
                '" . $_POST['alamat'] . "',
                '" . $_POST['no_hp'] . "',
                '" . $_POST['id_poli'] . "'
            )");
    }
    echo "<script> 
            document.location='index.php?page=dokter';
        </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php?page=dokter';
        </script>";
}
?>
<h2>Dokter</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
        $id_poli = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
                $id_poli = $row['id_poli'];
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
            <label for="inputNohp" class="form-label fw-bold">
                No Hp
            </label>
            <div>
                <input type="text" class="form-control" name="no_hp" id="inputNohp" placeholder="No Hp" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="id_poli" class="form-label fw-bold">
                Poli Dokter
            </label>
            <div>
                <select class="form-select" aria-label="id_poli" name="id_poli" >
                    <option selected>Pilih Poli...</option>
                    <?php 
                        $result = mysqli_query($mysqli, "SELECT * FROM poli");

                        while ($data = mysqli_fetch_assoc($result)) {
                            $selected = ($data['id'] == $id_poli) ? 'selected' : '';
                            echo "<option $selected value='" . $data['id'] . "'>". $data['nama_poli'] . "</option>";
                        }
                    ?>
                </select>
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
                <th scope="col">No Hp</th>
                <th scope="col">Id Poli</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['id_poli'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>