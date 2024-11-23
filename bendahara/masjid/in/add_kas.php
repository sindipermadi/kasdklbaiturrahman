<?php
// Memanggil koneksi ke database
include $_SERVER['DOCUMENT_ROOT'] . '/kas_masjid/inc/koneksi.php'; // Memastikan path file koneksi lebih aman

if (isset($_POST['Simpan'])) {
    // Tangkap data dari form
    $tgl_km = $_POST['tgl_km'];
    $uraian_km = $_POST['uraian_km'];
    $masuk = $_POST['masuk'];

    // Validasi input
    if (empty($tgl_km) || empty($uraian_km) || empty($masuk)) {
        echo "<script>
            Swal.fire({
                title: 'Gagal',
                text: 'Semua kolom wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        </script>";
        exit; // Menghentikan proses jika validasi gagal
    }

    // Menghapus karakter non-angka dari input "masuk" (Rp dan titik)
    $masuk_hasil = preg_replace("/[^0-9]/", "", $masuk);

    // Proses simpan data ke database
    $sql_simpan = "INSERT INTO kas_masjid (tgl_km, uraian_km, masuk, keluar, jenis) VALUES (?, ?, ?, 0, 'Masuk')";
    $stmt = $koneksi->prepare($sql_simpan);

    if ($stmt) {
        $stmt->bind_param("ssi", $tgl_km, $uraian_km, $masuk_hasil);
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Tambah Data Berhasil',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'index.php?page=i_data_km';
                    }
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Tambah Data Gagal',
                    text: 'Error: " . $stmt->error . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            Swal.fire({
                title: 'Tambah Data Gagal',
                text: 'Error: Tidak dapat mempersiapkan query',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
    $koneksi->close();
}
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Tambah Pemasukan
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Uraian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="uraian_km" name="uraian_km" placeholder="Uraian Pemasukan" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pemasukan</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="masuk" name="masuk" placeholder="Jumlah Pemasukan" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="tgl_km" name="tgl_km" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
            <a href="?page=i_data_km" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script type="text/javascript">
    var masuk = document.getElementById('masuk');
    masuk.addEventListener('keyup', function(e) {
        // Format angka dengan Rp saat mengetik
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

        masuk = split[1] != undefined ? masuk + ',' + split[1] : masuk;
        return prefix == undefined ? masuk : (masuk ? 'Rp ' + masuk : '');
    }
</script>