<?php
    include "../inc/koneksi.php";
    //FUNGSI RUPIAH
    include "../inc/rupiah.php";

    $dt1 = $_POST["tgl_1"];
    $dt2 = $_POST["tgl_2"];
?>

<?php
  $sql = $koneksi->query("SELECT SUM(masuk) as tot_masuk  from kas_masjid where jenis='Masuk' and tgl_km BETWEEN '$dt1' AND '$dt2'");
  while ($data= $sql->fetch_assoc()) {
    $masuk=$data['tot_masuk'];
  }

  $sql = $koneksi->query("SELECT SUM(keluar) as tot_keluar  from kas_masjid where jenis='Keluar' and tgl_km BETWEEN '$dt1' AND '$dt2'");
  while ($data= $sql->fetch_assoc()) {
    $keluar=$data['tot_keluar'];
  }

  $saldo= $masuk-$keluar;
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Laporan Kas Masjid</title>
</head>
<body>
<center>
<h2>Laporan Rekapitulasi Kas</h2>
<h3>DKL Baiturrahman</h3>
<p>Periode : <?php $a=$dt1; echo date("d-M-Y", strtotime($a))?> s/d <?php $b=$dt2; echo date("d-M-Y", strtotime($b))?>
<p>________________________________________________________________________</p>

  <table border="1" cellspacing="0">
    <thead>
      <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Uraian</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
      </tr>
    </thead>
    <tbody>
        <?php

        if(isset($_POST["btnCetak"])){
           
            $sql_tampil = "select * from kas_masjid where tgl_km BETWEEN '$dt1' AND '$dt2' order by tgl_km asc";
            }
            $query_tampil = mysqli_query($koneksi, $sql_tampil);
            $no=1;
            while ($data = mysqli_fetch_array($query_tampil,MYSQLI_BOTH)) {
        ?>
         <tr>
            <td><?php echo $no; ?></td>
            <td><?php  $tgl = $data['tgl_km']; echo date("d/M/Y", strtotime($tgl))?></td> 
            <td><?php echo $data['uraian_km']; ?></td>
            <td align="right"><?php echo rupiah($data['masuk']); ?></td>  
            <td align="right"><?php echo rupiah($data['keluar']); ?></td>   
        </tr>
        <?php
            $no++;
            }
        ?>
    </tbody>
    <tr>
        <td colspan="3">Total Pemasukan</td>
        <td colspan="2"><?php echo rupiah($masuk); ?></td>
    </tr>
    <tr>
        <td colspan="4">Total Pengeluaran</td>
        <td><?php echo rupiah($keluar); ?></td>
    </tr>
    <tr>
        <td colspan="3">Saldo Kas Masjid</td>
        <td colspan="2"><?php echo rupiah($saldo); ?></td>
    </tr>
  </table>
</center>

<!-- Tanda Tangan dan Titimangsa -->
<div style="text-align: center; margin-top: 40px;">
    <p>Kawali <?php echo date('d F Y'); ?></p>
    <div style="display: flex; justify-content: space-between; width: 80%; margin: 0 auto;">
        <div style="text-align: center; width: 48%;">Ketua</div>
        <div style="text-align: center; width: 48%;">Bendahara</div>
    </div>
    <div style="display: flex; justify-content: space-between; width: 80%; margin: 20px auto;">
        <!-- Hanya satu garis tanda tangan -->
        
        <!-- Hapus hr kedua yang menyebabkan garis panjang -->
    </div>
    <div style="display: flex; justify-content: space-between; width: 80%; margin: 0 auto;">
        <div style="text-align: center; width: 48%;">__________________________</div>
        <div style="text-align: center; width: 48%;">__________________________</div>
    </div>
</div>

<script>
    window.print();
</script>
</body>
</html>