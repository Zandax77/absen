<?php
session_start();

require_once __DIR__ . '/../konek.php';

// ==========================
// AMBIL PARAMETER & VALIDASI
// ==========================
$nis   = isset($_GET['nis']) ? mysqli_real_escape_string($db, $_GET['nis']) : '';
$awal  = isset($_GET['awal']) ? $_GET['awal'] : '';
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';

// Default periode (bulan ini jika kosong)
if(empty($awal) || empty($akhir)) {
    $awal  = date('Y-m-01');
    $akhir = date('Y-m-t');
}

// Validasi tanggal
if(strtotime($awal) > strtotime($akhir)) {
    die("Tanggal awal tidak boleh lebih besar dari tanggal akhir");
}

// ==========================
// DATA SISWA
// ==========================
$siswa_query = mysqli_query($db, "SELECT * FROM siswas WHERE nis='$nis'");
$siswa = mysqli_fetch_array($siswa_query);

$nama_siswa  = $siswa['nama'] ?? '-';
$kelas_siswa = $siswa['kelas'] ?? '-';

// ==========================
// FUNGSI FORMAT TANGGAL
// ==========================
function formatDate($tgl) {
    $parts = explode('/', $tgl);
    if(count($parts) == 3) {
        $day = $parts[0];
        $month = $parts[1];
        $year = $parts[2];
        if(checkdate($month, $day, $year)) {
            return date('d M Y', mktime(0, 0, 0, $month, $day, $year));
        }
    }
    return $tgl;
}

// ==========================
// FUNGSI KETERANGAN
// ==========================
function getKetLabel($ket) {
    switch($ket) {
        case 'S': return 'Sakit';
        case 'I': return 'Izin';
        case 'A': return 'Alpha';
        default: return $ket;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Riwayat Presensi - <?= $nama_siswa ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; font-family: "Times New Roman", Times, serif; }
        .table th { background-color: #f8f9fa !important; color: black !important; }
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; }
        }
        .header-laporan { border-bottom: 3px double #000; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="text-center header-laporan">
        <h3 class="mb-0">LAPORAN RIWAYAT PRESENSI SISWA</h3>
        <h4 class="mb-0"><?= strtoupper($nama_siswa) ?></h4>
        <p class="mb-0">Kelas: <?= $kelas_siswa ?></p>
        <p class="mb-0">
            Periode: <?= date('d/m/Y', strtotime($awal)) ?> 
            s/d <?= date('d/m/Y', strtotime($akhir)) ?>
        </p>
    </div>

    <!-- TABEL -->
    <table class="table table-bordered align-middle">
        <thead class="text-center">
            <tr>
                <th style="width: 50px;">No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $totalS = 0; 
            $totalI = 0; 
            $totalA = 0;

            // ==========================
            // QUERY FILTER PERIODE
            // (format tgl: dd/mm/yyyy)
            // ==========================
            $query = "
                SELECT tgl, ket 
                FROM absens 
                WHERE nis='$nis'
                AND STR_TO_DATE(tgl, '%d/%m/%Y') 
                    BETWEEN '$awal' AND '$akhir'
                ORDER BY STR_TO_DATE(tgl, '%d/%m/%Y') ASC
            ";

            $data = mysqli_query($db, $query);

            while($row = mysqli_fetch_array($data)) {
                $tgl = $row['tgl'];
                $ket = $row['ket'];

                if($ket == 'S') $totalS++;
                if($ket == 'I') $totalI++;
                if($ket == 'A') $totalA++;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= formatDate($tgl); ?></td>
                <td class="text-center"><?= getKetLabel($ket); ?></td>
            </tr>
            <?php } ?>

            <?php if($no == 1) { ?>
            <tr>
                <td colspan="3" class="text-center text-muted">
                    Tidak ada data pada periode ini
                </td>
            </tr>
            <?php } ?>
        </tbody>

        <tfoot class="table-light">
            <tr class="fw-bold text-center">
                <td colspan="2">TOTAL</td>
                <td>
                    Sakit: <?= $totalS ?> | 
                    Izin: <?= $totalI ?> | 
                    Alpha: <?= $totalA ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- TTD -->
    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Dicetak pada: <?= date('d F Y') ?></p>
            <p style="margin-bottom: 70px;">
                Mengetahui, <br> Wali Kelas
            </p>
            <p><strong>( ____________________ )</strong></p>
        </div>
    </div>

    <!-- BUTTON -->
    <div class="text-center no-print mt-4 mb-5">
        <button onclick="window.print()" class="btn btn-primary btn-lg">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-lg ms-2">
            Tutup
        </button>
    </div>

</div>

</body>
</html>