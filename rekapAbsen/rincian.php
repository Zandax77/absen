<?php
session_start();
$_SESSION['nisn'] = $_REQUEST['nisn'];
$nisn = $_SESSION['nisn'];
//echo $nisn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Rincian catatan presensi</title>
</head>
<body>
    <div class="container">
        <a href="rekap.php">Halaman rekap</a>
        <?php
			include "konek.php";
            //$nisn = $_REQUEST['nisn'];
			//echo $nisn;
			$dataSiswa = mysqli_query($db,"select * from siswas where nisn='$nisn'");
			$siswa = mysqli_fetch_array($dataSiswa);
		?>
		<h3>Rincian catatan ketidak hadiran <?php echo $siswa['nama'] ?></h3>
        <table class="table table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                
                <th>Keterangan</th>
                <th>Petugas Pencatat</th>
            </tr>
            <?php 
            $no = 1;
			//$nisn = $_REQUEST['nisn'];
            $data = mysqli_query($db,"select absens.tgl, siswas.nama, absens.ket, absens.opr from absens inner join siswas on siswas.nisn = absens.nisn where absens.nisn='$nisn'");
            //$data = mysqli_query($db,"select * from absens where nisn='$nisn'");
            while($isi=mysqli_fetch_array($data)){
            ?>
            <tr>
                <td align="center"><?php echo $no++ ?></td>
                <td align="center"><?php echo $isi[0]; ?></td>
                
                <td align="center"><?php echo $isi[2]; ?></td>
                <td><?php echo $isi[3]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>