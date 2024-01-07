<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=profilDokter");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_daftar_poli = $_GET['id'];
    $id_obat = $_POST['id_obat'];
    $biaya_dokter = 150000;
    $tgl_periksa = date('Y-m-d H:i:s');
    $catatan = $_POST['catatan'];

    $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$id_obat'");
    $row = mysqli_fetch_assoc($result);
    $harga = $row['harga'];

    $total = $biaya_dokter + $harga;
    $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) 
        VALUES (
            '$id_daftar_poli',
            '$tgl_periksa',
            '$catatan',
            '$total'
        )");
    $id_periksa = mysqli_insert_id($mysqli);
    $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
    $tambahdetail = mysqli_query($mysqli, $sql);

    if (!$tambah) {
        echo "Error: " . mysqli_error($mysqli);
    }
    
    echo $tambah;
    echo 
    "<script> 
            alert('.$tambah.');
            document.location='berandaDokter.php?page=periksa';
    </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='berandaDokter.php?page=periksa';
        </script>";
}

?>
<h2>Periksa Pasien</h2>
<br>

<div class="container">
    <form method="POST" action="">
        <?php 
            $id_pasien = '';
            $id_dokter = $_SESSION['id'];
            $nama_dokter = $_SESSION['nama'];
            $tgl_periksa = '';
            $nama_pasien = '';
            $no_antrian = '';
            $keluhan = '';

            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama
                FROM daftar_poli
                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                WHERE daftar_poli.id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $id_pasien = $row['id_pasien'];
                    $nama_pasien = $row['nama'];
                    $no_antrian = $row['no_antrian'];
                    $keluhan = $row['keluhan'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
                <input type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">
            <?php
            }
            
        ?>  

        <div class="form-group mb-3">
            <label for="id_pasien">Nama Pasien</label> 
            <input value="<?php echo $nama_pasien ?>" type="text" name="id_pasien" class="form-control form-control-lg  fs-6" placeholder="Masukkan nama pasien" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="id_dokter">Nama Dokter</label> 
            <input value="<?php echo $nama_dokter ?>" type="text" name="id_dokter" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nama dokter" required>
        </div>

        <div class="row mt-1 mb-3">
            <label for="catatan" class="form-label fw-bold">
                Catatan
            </label>
            <textarea placeholder="Catatan..." class="form-control" name="catatan" id="catatan" aria-label="With textarea"></textarea>
        </div>

        <div class="row mt-1 mb-3">
            <label for="id_obat" class="form-label fw-bold">
                Obat
            </label>
            <div>
                <select class="form-select" aria-label="id_obat" name="id_obat" >
                    <option selected>Pilih Obat...</option>
                    <?php 
                        $result = mysqli_query($mysqli, "SELECT * FROM obat");

                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $data['id'] . "'>". $data['nama_obat'] . "</option>";
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
                <th scope="col">Nama Pasien</th>
                <th scope="col">Nomor Antrian</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $id_dokter = $_SESSION['id'];
            $result = mysqli_query($mysqli, "
                SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                FROM daftar_poli
                JOIN (
                    SELECT id_pasien, MAX(tanggal) as max_tanggal
                    FROM daftar_poli
                    GROUP BY id_pasien
                ) as latest_poli ON daftar_poli.id_pasien = latest_poli.id_pasien AND daftar_poli.tanggal = latest_poli.max_tanggal
                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NULL
            ");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['no_antrian'] ?></td>
                    <td><?php echo $data['keluhan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="berandaDokter.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="berandaDokter.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
