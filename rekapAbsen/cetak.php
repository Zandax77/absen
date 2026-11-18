<?php include "konek.php"; 
if(!isset($_GET['kelas']) || !isset($_GET['awal']) || !isset($_GET['akhir'])){
    header("Location: index.php"); // Ganti index.php dengan nama file utama Anda
    exit;
}
$kelas = $_GET['kelas'];
$awal = $_GET['awal'];
$akhir = $_GET['akhir'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Presensi - <?= $kelas ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; font-family: "Times New Roman", Times, serif; }
        .table th { background-color: #f8f9fa !important; color: black !important; }
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; }
            .table-header { background-color: #eee !important; -webkit-print-color-adjust: exact; }
        }
        .header-laporan { border-bottom: 3px double #000; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- Header Laporan (KOP SURAT SEDERHANA) -->
    <div class="text-center header-laporan">
        <h3 class="mb-0">LAPORAN REKAPITULASI PRESENSI SISWA</h3>
        <h4 class="mb-0">KELAS <?= strtoupper($kelas) ?></h4>
        <p class="mb-0">Periode: <?= date('d/m/Y', strtotime($awal)) ?> s/d <?= date('d/m/Y', strtotime($akhir)) ?></p>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="text-center">
            <tr>
                <th rowspan="2" style="width: 50px; vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">Nama Siswa</th>
                <th colspan="3">Jumlah Keterangan</th>
            </tr>
            <tr>
                <th style="width: 80px;">Sakit (S)</th>
                <th style="width: 80px;">Izin (I)</th>
                <th style="width: 80px;">Alfa (A)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grandTotalS = 0; $grandTotalI = 0; $grandTotalA = 0;
            $data = mysqli_query($db, "SELECT * FROM siswas WHERE kelas='$kelas' ORDER BY nama ASC");
            while($isiKelas = mysqli_fetch_array($data)){ 
                $nis = $isiKelas[4];
                $s = mysqli_num_rows(mysqli_query($db,"SELECT id FROM absens WHERE nis='$nis' AND ket='S' AND date(created_at) BETWEEN '$awal' AND '$akhir'"));
                $i = mysqli_num_rows(mysqli_query($db,"SELECT id FROM absens WHERE nis='$nis' AND ket='I' AND date(created_at) BETWEEN '$awal' AND '$akhir'"));
                $a = mysqli_num_rows(mysqli_query($db,"SELECT id FROM absens WHERE nis='$nis' AND ket='A' AND date(created_at) BETWEEN '$awal' AND '$akhir'"));
                
                $grandTotalS += $s; $grandTotalI += $i; $grandTotalA += $a;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $isiKelas[2]; ?></td>
                <td class="text-center"><?= $s; ?></td>
                <td class="text-center"><?= $i; ?></td>
                <td class="text-center"><?= $a; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot class="table-light">
            <tr class="fw-bold text-center">
                <td colspan="2">TOTAL KESELURUHAN</td>
                <td><?= $grandTotalS ?></td>
                <td><?= $grandTotalI ?></td>
                <td><?= $grandTotalA ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Tanda Tangan -->
    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Dicetak pada: <?= date('d F Y') ?></p>
            <p style="margin-bottom: 70px;">Mengetahui, <br> Wali Kelas</p>
            <p><strong>( ____________________ )</strong></p>
        </div>
    </div>

    <!-- Tombol Print Otomatis -->
    <div class="text-center no-print mt-4 mb-5">
        <button onclick="window.print()" class="btn btn-primary btn-lg">Klik Untuk Cetak / Simpan PDF</button>
        <p class="text-muted mt-2">Pilih "Save as PDF" pada menu Destination/Tujuan saat jendela print muncul.</p>
    </div>
</div>

<script>
    // Jalankan print otomatis saat halaman terbuka
    window.onload = function() {
        // window.print(); // Aktifkan ini jika ingin langsung muncul dialog print
    }
</script>
</body>
</html>