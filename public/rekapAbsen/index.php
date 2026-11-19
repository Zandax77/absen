<?php
include "konek.php";
date_default_timezone_set('Asia/Jakarta');

$tgl_sekarang = date('Y-m-d');

/* ==========================================================
   STATISTIK HARI INI
========================================================== */

$s_hari_ini = mysqli_num_rows(mysqli_query(
    $db,
    "SELECT id FROM absens
     WHERE ket='S'
     AND DATE(created_at)='$tgl_sekarang'"
));

$i_hari_ini = mysqli_num_rows(mysqli_query(
    $db,
    "SELECT id FROM absens
     WHERE ket='I'
     AND DATE(created_at)='$tgl_sekarang'"
));

$a_hari_ini = mysqli_num_rows(mysqli_query(
    $db,
    "SELECT id FROM absens
     WHERE ket='A'
     AND DATE(created_at)='$tgl_sekarang'"
));


/* ==========================================================
   FUNGSI ESCAPE
========================================================== */

function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}


/* ==========================================================
   VALIDASI TANGGAL
========================================================== */

function validTanggal($tanggal)
{
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);

    return $d && $d->format('Y-m-d') === $tanggal;
}

?>
<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard Presensi Realtime - Skanamber</title>
<base href="/rekapAbsen/">


<!-- GOOGLE FONT -->

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet">


<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet">


<!-- BOOTSTRAP ICON -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
      rel="stylesheet">


<!-- CHART JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>

:root {
    --primary-color: #4361ee;
    --secondary-color: #7209b7;
}

body {
    background-color: #f8f9fc;
    font-family: 'Inter', sans-serif;
    color: #334155;
}

.card-summary {
    border: none;
    border-radius: 16px;
    transition: transform .2s;
}

.card-summary:hover {
    transform: translateY(-5px);
}

.main-card {
    border: none;
    border-radius: 20px;
    box-shadow:
        0 .125rem .25rem rgba(0,0,0,.075);
    background: white;
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 22px;
}

.chart-container-lg {
    position: relative;
    height: 350px;
    width: 100%;
}

.dot {
    height: 10px;
    width: 10px;

    background-color: #ff4d4d;

    border-radius: 50%;

    display: inline-block;

    margin-right: 5px;

    animation: blink 1.5s infinite;
}

@keyframes blink {

    0% {
        opacity: 1;
    }

    50% {
        opacity: .3;
    }

    100% {
        opacity: 1;
    }

}

.rank-item {

    border-bottom: 1px solid #f1f5f9;

    padding: 12px 0;

    transition: background .2s;

}

.rank-item:hover {

    background: #fcfdfe;

}

.rank-number {

    width: 32px;
    height: 32px;

    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: bold;

    background: #f1f5f9;

    color: #64748b;

    margin-right: 15px;

}

.top-1 {

    background: #fee2e2;

    color: #ef4444;

    border: 1px solid #fecaca;

}

.btn-histori {

    background-color: #f1f5f9;

    color: #475569;

    border: 1px solid #e2e8f0;

}

.btn-histori:hover {

    background-color: #e2e8f0;

}

.rekap-header {

    background:
        linear-gradient(
            135deg,
            #198754,
            #20c997
        );

    color: white;

    border-radius: 20px;

}

.table-rekap th {

    white-space: nowrap;

}

.table-rekap td {

    vertical-align: middle;

}

.badge-total {

    min-width: 55px;

}

</style>

</head>


<body>


<div class="container py-5">


<!-- ======================================================
     HEADER
====================================================== -->

<div class="row align-items-center mb-5">

    <div class="col-lg-6 mb-3 mb-lg-0">

        <h2 class="fw-bold text-dark mb-1">

            Dashboard Presensi

        </h2>

        <p class="text-muted mb-0">

            <i class="bi bi-calendar3 me-2"></i>

            <strong><?= date('d F Y'); ?></strong>

            <span class="ms-3 text-danger small fw-bold">

                <span class="dot"></span>

                LIVE UPDATE

            </span>

        </p>

    </div>


    <div class="col-lg-6 text-lg-end
                d-flex flex-wrap
                justify-content-lg-end gap-2">


        <!-- HISTORI -->

        <a href="/rekapAbsen/histori"
           class="btn btn-histori px-4 fw-semibold shadow-sm">

            <i class="bi bi-clock-history me-2"></i>

            Histori Absensi

        </a>


        <!-- REKAP SEMUA KELAS -->

        <button
            class="btn btn-success px-4 fw-bold shadow-sm"
            data-bs-toggle="modal"
            data-bs-target="#rekapSemuaKelasModal">

            <i class="bi bi-people-fill me-2"></i>

            Rekap Semua Kelas

        </button>


        <!-- FILTER KELAS -->

        <button
            class="btn btn-primary px-4 fw-bold shadow-sm"
            data-bs-toggle="modal"
            data-bs-target="#filterModal">

            <i class="bi bi-funnel-fill me-2"></i>

            Filter Laporan

        </button>

    </div>

</div>



<!-- ======================================================
     SUMMARY HARI INI
====================================================== -->

<div class="row mb-4">


    <div class="col-lg-8">

        <div class="row">


            <!-- SAKIT -->

            <div class="col-md-4 mb-3">

                <div class="card card-summary
                            shadow-sm bg-white p-3
                            border-start border-warning border-4">

                    <div class="d-flex align-items-center">

                        <div class="icon-box
                                    bg-warning-subtle
                                    text-warning me-3">

                            <i class="bi bi-thermometer-half"></i>

                        </div>

                        <div>

                            <p class="text-muted mb-0
                                      small fw-bold">

                                SAKIT

                            </p>

                            <h3 class="fw-bold mb-0"
                                id="count-sakit">

                                <?= $s_hari_ini ?>

                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            <!-- IZIN -->

            <div class="col-md-4 mb-3">

                <div class="card card-summary
                            shadow-sm bg-white p-3
                            border-start border-success border-4">

                    <div class="d-flex align-items-center">

                        <div class="icon-box
                                    bg-success-subtle
                                    text-success me-3">

                            <i class="bi bi-envelope-paper"></i>

                        </div>

                        <div>

                            <p class="text-muted mb-0
                                      small fw-bold">

                                IZIN

                            </p>

                            <h3 class="fw-bold mb-0"
                                id="count-izin">

                                <?= $i_hari_ini ?>

                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ALPHA -->

            <div class="col-md-4 mb-3">

                <div class="card card-summary
                            shadow-sm bg-white p-3
                            border-start border-danger border-4">

                    <div class="d-flex align-items-center">

                        <div class="icon-box
                                    bg-danger-subtle
                                    text-danger me-3">

                            <i class="bi bi-person-x"></i>

                        </div>

                        <div>

                            <p class="text-muted mb-0
                                      small fw-bold">

                                ALPHA

                            </p>

                            <h3 class="fw-bold mb-0"
                                id="count-alpha">

                                <?= $a_hari_ini ?>

                            </h3>

                        </div>

                    </div>

                </div>

            </div>


        </div>


        <!-- BAR CHART -->

        <div class="card main-card p-4 mt-2">

            <h6 class="fw-bold mb-3 text-muted
                       text-uppercase small">

                Statistik Ketidakhadiran
                Hari Ini

            </h6>

            <div style="height:250px">

                <canvas id="todayChart"></canvas>

            </div>

        </div>

    </div>


    <!-- PIE -->

    <div class="col-lg-4">

        <div class="card main-card p-4 h-100
                    text-center d-flex
                    flex-column justify-content-center">

            <h6 class="fw-bold mb-4 text-muted
                       text-uppercase small">

                Proporsi Ketidakhadiran

            </h6>

            <div style="height:250px">

                <canvas id="todayPieChart"></canvas>

            </div>

        </div>

    </div>

</div>



<!-- ======================================================
     TREN & RANKING
====================================================== -->

<div class="row mb-4">


    <div class="col-lg-8 mb-4">

        <div class="card main-card p-4 h-100">

            <h6 class="fw-bold text-muted
                       text-uppercase small mb-4">

                Tren Ketidakhadiran
                7 Hari Terakhir

            </h6>

            <div class="chart-container-lg">

                <canvas id="trendChart"></canvas>

            </div>

        </div>

    </div>


    <div class="col-lg-4 mb-4">

        <div class="card main-card p-4 h-100">

            <h6 class="fw-bold text-muted
                       text-uppercase small mb-4">

                Ranking Ketidakhadiran Kelas
                7 Hari

            </h6>

            <div id="ranking-list">

                <div class="text-center py-5">

                    <div class="spinner-border
                                spinner-border-sm
                                text-primary">

                    </div>

                </div>

            </div>

            <div class="mt-auto pt-3
                        border-top text-center">

                <small class="text-muted">

                    <i>
                    *Akumulasi Sakit,
                    Izin dan Alpha
                    </i>

                </small>

            </div>

        </div>

    </div>

</div>



<!-- ======================================================
     PERBANDINGAN KELAS HARI INI
====================================================== -->

<div class="row mb-5">

    <div class="col-12">

        <div class="card main-card p-4">

            <div class="d-flex
                        justify-content-between
                        align-items-center mb-4">

                <h6 class="fw-bold text-muted
                           text-uppercase small mb-0">

                    Perbandingan Ketidakhadiran
                    Per Kelas Hari Ini

                </h6>

                <small class="text-muted">

                    Update:
                    <span id="last-update">-</span>

                </small>

            </div>

            <div class="chart-container-lg">

                <canvas id="classComparisonChart"></canvas>

            </div>

        </div>

    </div>

</div>



<!-- ======================================================
     HASIL FILTER SATU KELAS
====================================================== -->

<?php

if (
    isset($_GET['kelas'], $_GET['awal'], $_GET['akhir'])
    &&
    $_GET['kelas'] != ''
    &&
    validTanggal($_GET['awal'])
    &&
    validTanggal($_GET['akhir'])
) {

    $kls = mysqli_real_escape_string(
        $db,
        $_GET['kelas']
    );

    $tgl_awal = mysqli_real_escape_string(
        $db,
        $_GET['awal']
    );

    $tgl_akhir = mysqli_real_escape_string(
        $db,
        $_GET['akhir']
    );


    if ($tgl_awal <= $tgl_akhir) {

        $sql_lap = "
            SELECT
                s.nama,
                s.nis,

                SUM(
                    CASE
                        WHEN a.ket='S' THEN 1
                        ELSE 0
                    END
                ) AS ts,

                SUM(
                    CASE
                        WHEN a.ket='I' THEN 1
                        ELSE 0
                    END
                ) AS ti,

                SUM(
                    CASE
                        WHEN a.ket='A' THEN 1
                        ELSE 0
                    END
                ) AS ta

            FROM siswas s

            LEFT JOIN absens a
                ON s.nis=a.nis

                AND DATE(a.created_at)
                BETWEEN '$tgl_awal'
                AND '$tgl_akhir'

            WHERE s.kelas='$kls'

            GROUP BY
                s.nis,
                s.nama

            ORDER BY s.nama ASC
        ";


        $res_lap = mysqli_query(
            $db,
            $sql_lap
        );

        $gS = 0;
        $gI = 0;
        $gA = 0;

        $no = 1;

?>

<div class="mt-5">

    <div class="alert alert-primary
                border-0 shadow-sm
                d-flex justify-content-between
                align-items-center mb-4
                p-4 rounded-4">

        <div>

            <h5 class="fw-bold mb-1">

                Hasil Rekapitulasi:
                <?= e($kls) ?>

            </h5>

            <p class="mb-0 small opacity-75">

                Periode:

                <?= date(
                    'd/m/Y',
                    strtotime($tgl_awal)
                ) ?>

                s/d

                <?= date(
                    'd/m/Y',
                    strtotime($tgl_akhir)
                ) ?>

            </p>

        </div>


        <a
            href="cetak.php?kelas=<?= urlencode($kls) ?>&awal=<?= urlencode($tgl_awal) ?>&akhir=<?= urlencode($tgl_akhir) ?>"
            target="_blank"
            class="btn btn-light fw-bold
                   px-4 rounded-pill">

            <i class="bi bi-printer-fill me-2"></i>

            Cetak PDF

        </a>

    </div>


    <div class="card main-card p-4 mb-5
                border-top border-primary border-5">

        <div class="table-responsive">

            <table class="table table-hover
                          align-middle">

                <thead class="table-light text-center">

                    <tr>

                        <th>No</th>

                        <th class="text-start">
                            Nama Siswa
                        </th>

                        <th>S</th>

                        <th>I</th>

                        <th>A</th>

                        <th>Total</th>

                    </tr>

                </thead>


                <tbody>

<?php

while ($r = mysqli_fetch_assoc($res_lap)) {

    $ts = (int)$r['ts'];
    $ti = (int)$r['ti'];
    $ta = (int)$r['ta'];

    $total =
        $ts +
        $ti +
        $ta;

    $gS += $ts;
    $gI += $ti;
    $gA += $ta;

?>

                    <tr>

                        <td class="text-center">
                            <?= $no++ ?>
                        </td>

                        <td class="fw-semibold text-dark">
                            <?= e($r['nama']) ?>
                        </td>

                        <td class="text-center
                                   text-warning fw-bold">
                            <?= $ts ?>
                        </td>

                        <td class="text-center
                                   text-success fw-bold">
                            <?= $ti ?>
                        </td>

                        <td class="text-center
                                   text-danger fw-bold">
                            <?= $ta ?>
                        </td>

                        <td class="text-center
                                   bg-light fw-bold">
                            <?= $total ?>
                        </td>

                    </tr>

<?php } ?>

                </tbody>


                <tfoot class="table-dark fw-bold text-center">

                    <tr>

                        <td colspan="2">
                            TOTAL
                        </td>

                        <td><?= $gS ?></td>

                        <td><?= $gI ?></td>

                        <td><?= $gA ?></td>

                        <td>
                            <?= $gS+$gI+$gA ?>
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

<?php

    }

}

?>



<!-- ======================================================
     REKAP SEMUA KELAS
====================================================== -->

<?php

if (
    isset(
        $_GET['rekap_semua'],
        $_GET['awal_semua'],
        $_GET['akhir_semua']
    )
    &&
    $_GET['rekap_semua']=='1'
    &&
    validTanggal($_GET['awal_semua'])
    &&
    validTanggal($_GET['akhir_semua'])
) {

    $awal_semua = mysqli_real_escape_string(
        $db,
        $_GET['awal_semua']
    );

    $akhir_semua = mysqli_real_escape_string(
        $db,
        $_GET['akhir_semua']
    );


    if ($awal_semua <= $akhir_semua) {

        /*
         * REKAP SEMUA KELAS
         */

        $sql_semua = "

            SELECT

                s.kelas,

                COUNT(DISTINCT s.nis)
                AS jumlah_siswa,

                COALESCE(
                    SUM(
                        CASE
                            WHEN a.ket='S'
                            THEN 1
                            ELSE 0
                        END
                    ),0
                ) AS sakit,

                COALESCE(
                    SUM(
                        CASE
                            WHEN a.ket='I'
                            THEN 1
                            ELSE 0
                        END
                    ),0
                ) AS izin,

                COALESCE(
                    SUM(
                        CASE
                            WHEN a.ket='A'
                            THEN 1
                            ELSE 0
                        END
                    ),0
                ) AS alpha

            FROM siswas s

            LEFT JOIN absens a
                ON s.nis=a.nis

                AND DATE(a.created_at)
                BETWEEN '$awal_semua'
                AND '$akhir_semua'

            GROUP BY s.kelas

            ORDER BY s.kelas ASC

        ";


        $result_semua = mysqli_query(
            $db,
            $sql_semua
        );


        $total_siswa = 0;
        $total_sakit = 0;
        $total_izin = 0;
        $total_alpha = 0;

?>

<!-- HEADER -->

<div class="mt-5">

    <div class="rekap-header
                shadow-sm p-4 mb-4">

        <div class="row align-items-center">

            <div class="col-md-8">

                <div class="d-flex
                            align-items-center">

                    <div class="icon-box
                                bg-white
                                text-success me-3">

                        <i class="bi bi-people-fill"></i>

                    </div>

                    <div>

                        <h4 class="fw-bold mb-1">

                            Rekap Absensi
                            Semua Kelas

                        </h4>

                        <div class="small">

                            Periode:

                            <strong>

                                <?= date(
                                    'd/m/Y',
                                    strtotime($awal_semua)
                                ) ?>

                            </strong>

                            s/d

                            <strong>

                                <?= date(
                                    'd/m/Y',
                                    strtotime($akhir_semua)
                                ) ?>

                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-4 text-md-end mt-3 mt-md-0">

                <a
                    href="cetak_semua_kelas.php?awal=<?= urlencode($awal_semua) ?>&akhir=<?= urlencode($akhir_semua) ?>"
                    target="_blank"
                    class="btn btn-light fw-bold
                           rounded-pill px-4">

                    <i class="bi bi-file-earmark-pdf-fill
                              me-2"></i>

                    Cetak PDF

                </a>

                <a
                    href="export_semua_kelas.php?awal=<?= urlencode($awal_semua) ?>&akhir=<?= urlencode($akhir_semua) ?>"
                    class="btn btn-outline-light
                           fw-bold rounded-pill px-4 mt-2 mt-md-0">

                    <i class="bi bi-file-earmark-excel-fill
                              me-2"></i>

                    Excel

                </a>

            </div>

        </div>

    </div>



    <!-- SUMMARY -->

    <div class="row mb-4">


<?php

$summary = [

    [
        'judul'=>'TOTAL SISWA',
        'id'=>'rekap-total-siswa',
        'icon'=>'bi-people',
        'warna'=>'primary'
    ],

    [
        'judul'=>'SAKIT',
        'id'=>'rekap-total-sakit',
        'icon'=>'bi-thermometer-half',
        'warna'=>'warning'
    ],

    [
        'judul'=>'IZIN',
        'id'=>'rekap-total-izin',
        'icon'=>'bi-envelope-paper',
        'warna'=>'success'
    ],

    [
        'judul'=>'ALPHA',
        'id'=>'rekap-total-alpha',
        'icon'=>'bi-person-x',
        'warna'=>'danger'
    ]

];

foreach ($summary as $item) {

?>

        <div class="col-md-3 mb-3">

            <div class="card card-summary
                        shadow-sm bg-white p-3
                        border-start
                        border-<?= $item['warna'] ?>
                        border-4">

                <div class="d-flex align-items-center">

                    <div class="icon-box
                                bg-<?= $item['warna'] ?>-subtle
                                text-<?= $item['warna'] ?>
                                me-3">

                        <i class="bi <?= $item['icon'] ?>"></i>

                    </div>

                    <div>

                        <p class="text-muted mb-0
                                  small fw-bold">

                            <?= $item['judul'] ?>

                        </p>

                        <h3 class="fw-bold mb-0"
                            id="<?= $item['id'] ?>">

                            0

                        </h3>

                    </div>

                </div>

            </div>

        </div>

<?php } ?>

    </div>



    <!-- GRAFIK -->

    <div class="card main-card p-4 mb-4">

        <div class="d-flex
                    justify-content-between
                    align-items-center mb-4">

            <div>

                <h6 class="fw-bold text-muted
                           text-uppercase small mb-1">

                    Grafik Rekap Per Kelas

                </h6>

                <small class="text-muted">

                    Periode sesuai filter

                </small>

            </div>

        </div>

        <div class="chart-container-lg">

            <canvas id="rekapKelasChart"></canvas>

        </div>

    </div>



    <!-- TABEL -->

    <div class="card main-card p-4 mb-5">

        <div class="d-flex
                    justify-content-between
                    align-items-center mb-4">

            <div>

                <h6 class="fw-bold text-muted
                           text-uppercase small mb-1">

                    Rekapitulasi Semua Kelas

                </h6>

                <small class="text-muted">

                    Klik tombol PDF atau Excel
                    untuk mengunduh laporan.

                </small>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-hover
                          table-rekap align-middle">

                <thead class="table-light text-center">

                    <tr>

                        <th>No</th>

                        <th class="text-start">
                            Kelas
                        </th>

                        <th>
                            Jumlah Siswa
                        </th>

                        <th class="text-warning">
                            Sakit
                        </th>

                        <th class="text-success">
                            Izin
                        </th>

                        <th class="text-danger">
                            Alpha
                        </th>

                        <th>
                            Total Absen
                        </th>

                    </tr>

                </thead>


                <tbody>

<?php

$no = 1;

$chart_labels = [];
$chart_sakit = [];
$chart_izin = [];
$chart_alpha = [];

while ($r = mysqli_fetch_assoc($result_semua)) {

    $jml_siswa = (int)$r['jumlah_siswa'];

    $sakit = (int)$r['sakit'];

    $izin = (int)$r['izin'];

    $alpha = (int)$r['alpha'];

    $total =
        $sakit +
        $izin +
        $alpha;


    $total_siswa += $jml_siswa;

    $total_sakit += $sakit;

    $total_izin += $izin;

    $total_alpha += $alpha;


    $chart_labels[] =
        $r['kelas'];

    $chart_sakit[] =
        $sakit;

    $chart_izin[] =
        $izin;

    $chart_alpha[] =
        $alpha;

?>

                    <tr>

                        <td class="text-center">

                            <?= $no++ ?>

                        </td>

                        <td class="fw-bold">

                            <?= e($r['kelas']) ?>

                        </td>

                        <td class="text-center">

                            <?= number_format(
                                $jml_siswa
                            ) ?>

                        </td>

                        <td class="text-center
                                   text-warning fw-bold">

                            <?= $sakit ?>

                        </td>

                        <td class="text-center
                                   text-success fw-bold">

                            <?= $izin ?>

                        </td>

                        <td class="text-center
                                   text-danger fw-bold">

                            <?= $alpha ?>

                        </td>

                        <td class="text-center">

                            <span
                                class="badge bg-danger
                                       rounded-pill
                                       badge-total">

                                <?= $total ?>

                            </span>

                        </td>

                    </tr>

<?php } ?>

                </tbody>


                <tfoot class="table-dark fw-bold text-center">

                    <tr>

                        <td colspan="2">

                            TOTAL SELURUH SEKOLAH

                        </td>

                        <td>

                            <?= number_format(
                                $total_siswa
                            ) ?>

                        </td>

                        <td>

                            <?= number_format(
                                $total_sakit
                            ) ?>

                        </td>

                        <td>

                            <?= number_format(
                                $total_izin
                            ) ?>

                        </td>

                        <td>

                            <?= number_format(
                                $total_alpha
                            ) ?>

                        </td>

                        <td>

                            <?= number_format(
                                $total_sakit +
                                $total_izin +
                                $total_alpha
                            ) ?>

                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>



<script>

document.getElementById(
    'rekap-total-siswa'
).innerText =
    '<?= $total_siswa ?>';

document.getElementById(
    'rekap-total-sakit'
).innerText =
    '<?= $total_sakit ?>';

document.getElementById(
    'rekap-total-izin'
).innerText =
    '<?= $total_izin ?>';

document.getElementById(
    'rekap-total-alpha'
).innerText =
    '<?= $total_alpha ?>';


/* GRAFIK REKAP */

new Chart(
    document
        .getElementById('rekapKelasChart')
        .getContext('2d'),
    {
        type: 'bar',

        data: {

            labels:
                <?= json_encode(
                    $chart_labels,
                    JSON_UNESCAPED_UNICODE
                ) ?>,

            datasets: [

                {
                    label:'Sakit',

                    data:
                        <?= json_encode(
                            $chart_sakit
                        ) ?>,

                    backgroundColor:'#ff9f43'
                },

                {
                    label:'Izin',

                    data:
                        <?= json_encode(
                            $chart_izin
                        ) ?>,

                    backgroundColor:'#28c76f'
                },

                {
                    label:'Alpha',

                    data:
                        <?= json_encode(
                            $chart_alpha
                        ) ?>,

                    backgroundColor:'#ea5455'
                }

            ]

        },

        options: {

            responsive:true,

            maintainAspectRatio:false,

            scales: {

                y: {

                    beginAtZero:true,

                    ticks: {
                        stepSize:1
                    }

                }

            }

        }

    }
);

</script>

<?php

    }

}

?>



<!-- ======================================================
     MODAL REKAP SEMUA KELAS
====================================================== -->

<div class="modal fade"
     id="rekapSemuaKelasModal"
     tabindex="-1">

    <div class="modal-dialog
                modal-dialog-centered">

        <form
            action=""
            method="GET"
            class="modal-content
                   border-0 shadow-lg">


            <input
                type="hidden"
                name="rekap_semua"
                value="1">


            <div class="modal-header
                        bg-success text-white p-4">

                <h5 class="modal-title fw-bold">

                    <i class="bi bi-people-fill me-2"></i>

                    Rekap Semua Kelas

                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body p-4">


                <div class="alert alert-success
                            border-0 small">

                    <i class="bi bi-info-circle me-2"></i>

                    Pilih periode untuk menampilkan
                    rekap absensi seluruh kelas.

                </div>


                <div class="row">


                    <div class="col-6">

                        <label class="form-label
                                      small fw-bold text-muted">

                            DARI

                        </label>

                        <input
                            type="date"
                            name="awal_semua"
                            class="form-control border-2"
                            required>

                    </div>


                    <div class="col-6">

                        <label class="form-label
                                      small fw-bold text-muted">

                            SAMPAI

                        </label>

                        <input
                            type="date"
                            name="akhir_semua"
                            class="form-control border-2"
                            required>

                    </div>

                </div>


            </div>


            <div class="modal-footer
                        p-4 border-0">

                <button
                    type="submit"
                    class="btn btn-success
                           w-100 py-3
                           fw-bold rounded-3 shadow">

                    <i class="bi bi-search me-2"></i>

                    Tampilkan Rekap

                </button>

            </div>

        </form>

    </div>

</div>



<!-- ======================================================
     MODAL FILTER SATU KELAS
====================================================== -->

<div class="modal fade"
     id="filterModal"
     tabindex="-1">

    <div class="modal-dialog
                modal-dialog-centered">

        <form
            action=""
            method="GET"
            class="modal-content
                   border-0 shadow-lg">


            <div class="modal-header
                        bg-primary text-white p-4">

                <h5 class="modal-title fw-bold">

                    <i class="bi bi-funnel me-2"></i>

                    Filter Laporan Absensi

                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body p-4">


                <div class="mb-3">

                    <label class="form-label
                                  small fw-bold text-muted">

                        KELAS

                    </label>


                    <select
                        name="kelas"
                        class="form-select border-2"
                        required>

                        <option value="">
                            -- Pilih Kelas --
                        </option>


<?php

$q_kls = mysqli_query(
    $db,
    "SELECT kelas
     FROM siswas
     GROUP BY kelas
     ORDER BY kelas"
);

while ($rk = mysqli_fetch_assoc($q_kls)) {

?>

                        <option
                            value="<?= e($rk['kelas']) ?>">

                            <?= e($rk['kelas']) ?>

                        </option>

<?php } ?>

                    </select>

                </div>


                <div class="row">


                    <div class="col-6">

                        <label
                            class="form-label
                                   small fw-bold text-muted">

                            DARI

                        </label>

                        <input
                            type="date"
                            name="awal"
                            class="form-control border-2"
                            required>

                    </div>


                    <div class="col-6">

                        <label
                            class="form-label
                                   small fw-bold text-muted">

                            SAMPAI

                        </label>

                        <input
                            type="date"
                            name="akhir"
                            class="form-control border-2"
                            required>

                    </div>

                </div>

            </div>


            <div class="modal-footer
                        p-4 border-0">

                <button
                    type="submit"
                    class="btn btn-primary
                           w-100 py-3
                           fw-bold rounded-3 shadow">

                    <i class="bi bi-search me-2"></i>

                    Tampilkan Data

                </button>

            </div>

        </form>

    </div>

</div>



</div>



<!-- ======================================================
     JAVASCRIPT REALTIME
====================================================== -->

<script>

let todayChart;
let todayPieChart;
let classComparisonChart;
let trendChart;


/* ==========================================================
   INIT CHART
========================================================== */

function initCharts()
{

    const ctxToday =
        document
        .getElementById('todayChart')
        .getContext('2d');


    const ctxPie =
        document
        .getElementById('todayPieChart')
        .getContext('2d');


    const ctxClass =
        document
        .getElementById('classComparisonChart')
        .getContext('2d');


    const ctxTrend =
        document
        .getElementById('trendChart')
        .getContext('2d');


    /* BAR HARI INI */

    todayChart = new Chart(
        ctxToday,
        {

            type:'bar',

            data: {

                labels:[
                    'Sakit',
                    'Izin',
                    'Alpha'
                ],

                datasets:[

                    {
                        data:[0,0,0],

                        backgroundColor:[
                            '#ff9f43',
                            '#28c76f',
                            '#ea5455'
                        ],

                        borderRadius:10

                    }

                ]

            },

            options: {

                responsive:true,

                maintainAspectRatio:false,

                plugins: {
                    legend:{
                        display:false
                    }
                }

            }

        }
    );


    /* PIE */

    todayPieChart = new Chart(
        ctxPie,
        {

            type:'doughnut',

            data: {

                labels:[
                    'Sakit',
                    'Izin',
                    'Alpha'
                ],

                datasets:[

                    {

                        data:[0,0,0],

                        backgroundColor:[
                            '#ff9f43',
                            '#28c76f',
                            '#ea5455'
                        ],

                        borderWidth:0,

                        hoverOffset:10

                    }

                ]

            },

            options: {

                responsive:true,

                maintainAspectRatio:false,

                cutout:'70%'

            }

        }
    );


    /* PERBANDINGAN KELAS */

    classComparisonChart =
        new Chart(
            ctxClass,
            {

                type:'bar',

                data: {

                    labels:[],

                    datasets:[

                        {
                            label:'Sakit',
                            data:[],
                            backgroundColor:'#ff9f43'
                        },

                        {
                            label:'Izin',
                            data:[],
                            backgroundColor:'#28c76f'
                        },

                        {
                            label:'Alpha',
                            data:[],
                            backgroundColor:'#ea5455'
                        }

                    ]

                },

                options: {

                    responsive:true,

                    maintainAspectRatio:false,

                    scales: {

                        y: {

                            beginAtZero:true,

                            ticks:{
                                stepSize:1
                            }

                        }

                    }

                }

            }
        );


    /* TREND */

    trendChart =
        new Chart(
            ctxTrend,
            {

                type:'line',

                data: {

                    labels:[],

                    datasets:[

                        {
                            label:'Sakit',
                            data:[],
                            borderColor:'#ff9f43',
                            backgroundColor:
                                'rgba(255,159,67,.1)',
                            tension:.4,
                            fill:true
                        },

                        {
                            label:'Izin',
                            data:[],
                            borderColor:'#28c76f',
                            backgroundColor:
                                'rgba(40,199,111,.1)',
                            tension:.4,
                            fill:true
                        },

                        {
                            label:'Alpha',
                            data:[],
                            borderColor:'#ea5455',
                            backgroundColor:
                                'rgba(234,84,85,.1)',
                            tension:.4,
                            fill:true
                        }

                    ]

                },

                options: {

                    responsive:true,

                    maintainAspectRatio:false,

                    plugins: {

                        legend:{
                            position:'bottom'
                        }

                    }

                }

            }
        );

}


/* ==========================================================
   REALTIME
========================================================== */

function fetchRealtimeData()
{

    fetch('/rekapAbsen/api_realtime.php')

    .then(
        response => response.json()
    )

    .then(
        data => {

            if (!data.summary)
                return;


            document
            .getElementById('count-sakit')
            .innerText =
                data.summary.sakit;


            document
            .getElementById('count-izin')
            .innerText =
                data.summary.izin;


            document
            .getElementById('count-alpha')
            .innerText =
                data.summary.alpha;


            document
            .getElementById('last-update')
            .innerText =
                data.summary.last_update;


            /* TODAY BAR */

            todayChart
                .data
                .datasets[0]
                .data = [

                    data.summary.sakit,

                    data.summary.izin,

                    data.summary.alpha

                ];

            todayChart.update();


            /* PIE */

            todayPieChart
                .data
                .datasets[0]
                .data = [

                    data.summary.sakit,

                    data.summary.izin,

                    data.summary.alpha

                ];

            todayPieChart.update();


            /* KELAS */

            if (data.grafik_kelas) {

                classComparisonChart
                    .data
                    .labels =
                    data.grafik_kelas.labels;


                classComparisonChart
                    .data
                    .datasets[0]
                    .data =
                    data.grafik_kelas.sakit;


                classComparisonChart
                    .data
                    .datasets[1]
                    .data =
                    data.grafik_kelas.izin;


                classComparisonChart
                    .data
                    .datasets[2]
                    .data =
                    data.grafik_kelas.alpha;


                classComparisonChart.update();

            }


            /* TREND */

            if (data.tren_7_hari) {

                trendChart
                    .data
                    .labels =
                    data.tren_7_hari.labels;


                trendChart
                    .data
                    .datasets[0]
                    .data =
                    data.tren_7_hari.sakit;


                trendChart
                    .data
                    .datasets[1]
                    .data =
                    data.tren_7_hari.izin;


                trendChart
                    .data
                    .datasets[2]
                    .data =
                    data.tren_7_hari.alpha;


                trendChart.update();

            }


            /* RANKING */

            let rHtml = '';

            if (data.ranking_7_hari) {

                data.ranking_7_hari
                .forEach(
                    (item,i) => {

                        rHtml += `

                        <div
                            class="rank-item
                                   d-flex
                                   align-items-center">

                            <div
                                class="rank-number
                                       ${i===0?'top-1':''}">

                                ${i+1}

                            </div>


                            <div
                                class="flex-grow-1">

                                <div
                                    class="fw-bold text-dark">

                                    ${item.kelas}

                                </div>

                                <small
                                    class="text-muted">

                                    S:${item.s}
                                    |
                                    I:${item.i}
                                    |
                                    A:${item.a}

                                </small>

                            </div>


                            <div
                                class="badge
                                       bg-danger
                                       rounded-pill
                                       px-3">

                                ${item.total}
                                Absen

                            </div>

                        </div>

                        `;

                    }
                );

            }


            document
            .getElementById('ranking-list')
            .innerHTML =
                rHtml ||
                '<p class="text-center text-muted">Belum ada data.</p>';

        }
    )

    .catch(
        error => {

            console.error(
                'Realtime error:',
                error
            );

        }
    );

}


/* ==========================================================
   START
========================================================== */

window.onload = function()
{

    initCharts();

    fetchRealtimeData();

    setInterval(
        fetchRealtimeData,
        10000
    );

};

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>
