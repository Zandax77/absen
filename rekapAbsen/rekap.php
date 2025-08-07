<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Catatan Presensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div class="container">
	
	<div class="card sm">
        <div class="card-body">
              <h5 class="card-title">Periode Presensi Siswa</h5>
        <form action="">
            <div class="form-group">
			Kelas : 
            <select name="kelas" id="" class="form-control">
                <option value=""></option>
                <?php include "konek.php";
                    $kelas = mysqli_query($db,"select * from siswas group by kelas order by kelas");
                    while($isi=mysqli_fetch_array($kelas)){ 
                ?>
                <option value="<?php echo $isi[1]; ?>"><?php echo $isi[1]; ?></option><?php } ?>
            </select>
            </div>
            <div class="form-group">
            	Dari tanggal : 
            	<input type="date" name="awal" class="form-control">
            </div>
            <div class="form-group">
            	Hingga tanggal : 
            	<input type="date" name="akhir" class="form-control">
            </div>
             <hr>
            <p align="right">
            <button type="submit" class="btn btn-success">TAMPILKAN</button></p>
        </form>
    	</div>
    </div>
        
<hr>
                <iframe src="https://presensisiswa.smkn6.com/public/generalAbsen" width="100%" height="800px" frameborder="0"></iframe>
                
        <?php 
                $kelas = $_REQUEST['kelas'];
                $dari = date('d/m/Y',strtotime($_REQUEST['awal']));
                $hingga = date('d/m/Y',strtotime($_REQUEST['akhir']));
                $awal = $_REQUEST['awal'];
                $akhir = $_REQUEST['akhir'];
                $no=1;
                if($kelas!=""and$awal!=""and$akhir!=""){
                    $data = mysqli_query($db,"select * from siswas where kelas='$kelas'");
        ?>
        <center>
        <h1>Rekap Peresensi Siswa<h1>
        <h2>Kelas : <?php echo $kelas; ?> </h2>
        <h5>Tanggal : <?php echo $dari; ?> - <?php echo $hingga; ?></h5></center>
        <table border="1" class="table table-bordered table-striped datatable">
            <thead>
                <tr align="center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th colspan="3">Keterangan</th>
                </tr>
                <tr align="center">
                    <th>S</th>
                    <th>I</th>
                    <th>A</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($isiKelas = mysqli_fetch_array($data)){
                ?>
                <tr>
                    <td align="center"><?php echo $no++ ; ?></td>
                    <td><a href="rincian.php?nisn=<?php echo $isiKelas[3];?>" title="Klik untuk melihat rincian" target="#rinci"><?php echo $isiKelas[2] ; ?></a></td>
                    <td align="center"><?php echo mysqli_num_rows(mysqli_query($db,"SELECT * FROM `absens` WHERE kelas='$kelas' AND nisn='$isiKelas[3]' AND ket='S' AND created_at BETWEEN '$awal' AND '$akhir'")); ?></td>
                    <td align="center"><?php echo mysqli_num_rows(mysqli_query($db,"SELECT * FROM `absens` WHERE kelas='$kelas' AND nisn='$isiKelas[3]' AND ket='I' AND created_at BETWEEN '$awal' AND '$akhir'")); ?></td>
                    <td align="center"><?php echo mysqli_num_rows(mysqli_query($db,"SELECT * FROM `absens` WHERE kelas='$kelas' AND nisn='$isiKelas[3]' AND ket='A' AND created_at BETWEEN '$awal' AND '$akhir'")); ?></td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
        <div class="modal fade" id="rinci" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>