<?php
if (isset($_GET['kode'])) {
    // Ambil data dari database berdasarkan kode
    $sql_cek = "SELECT * FROM kas_masjid WHERE id_km='" . $_GET['kode'] . "'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Ubah Pemasukan
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <input type='hidden' class="form-control" name="id_km" value="<?php echo $data_cek['id_km']; ?>" readonly/>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Uraian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="uraian_km" name="uraian_km" 
                        value="<?php echo $data_cek['uraian_km']; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pemasukan</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="masuk" name="masuk" 
                        value="<?php echo number_format($data_cek['masuk'], 0, '', '.'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="tgl_km" name="tgl_km" 
                        value="<?php echo $data_cek['tgl_km']; ?>" />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="Ubah" value="Simpan" class="btn btn-success">
            <a href="?page=i_data_km" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['Ubah'])) {
    // Menangkap data dari form dan menghindari karakter berbahaya
    $id_km = mysqli_real_escape_string($koneksi, $_POST['id_km']);
    $uraian_km = mysqli_real_escape_string($koneksi, $_POST['uraian_km']);
    $masuk = mysqli_real_escape_string($koneksi, $_POST['masuk']);
    $tgl_km = mysqli_real_escape_string($koneksi, $_POST['tgl_km']);

    // Membersihkan data pemasukan untuk memastikan hanya angka yang ada
    $masuk_hasil = preg_replace("/[^0-9]/", "", $masuk);

    // Query update dengan data yang sudah dibersihkan
    $sql_ubah = "UPDATE kas_masjid SET
                    uraian_km='$uraian_km', 
                    masuk='$masuk_hasil', 
                    tgl_km='$tgl_km' 
                 WHERE id_km='$id_km'";

    // Debugging: Menampilkan query SQL untuk memeriksa sintaks
    echo $sql_ubah; // Hapus setelah memverifikasi query

    // Jalankan query
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    // Menutup koneksi
    mysqli_close($koneksi);

    // Notifikasi hasil update
    if ($query_ubah) {
        echo "<script>
            Swal.fire({
                title: 'Ubah Data Berhasil',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=i_data_km';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Ubah Data Gagal',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=i_data_km';
                }
            });
        </script>";
    }
}
?>
<script type="text/javascript">
    var masuk = document.getElementById('masuk');
    masuk.addEventListener('keyup', function (e) {
        masuk.value = formatmasuk(this.value, 'Rp ');
    });

    function formatmasuk(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            masuk = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            masuk += separator + ribuan.join('.');
        }

        masuk = split[1] !== undefined ? masuk + ',' + split[1] : masuk;
        return prefix === undefined ? masuk : (masuk ? 'Rp ' + masuk : '');
    }
</script>
