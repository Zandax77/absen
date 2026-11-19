```php
<?php

include "konek.php";

date_default_timezone_set('Asia/Jakarta');


/* ==========================================================
   VALIDASI
========================================================== */

function validTanggal($tanggal)
{
    $d = DateTime::createFromFormat(
        'Y-m-d',
        $tanggal
    );

    return $d &&
           $d->format('Y-m-d') === $tanggal;
}


if (
    !isset($_GET['awal']) ||
    !isset($_GET['akhir'])
) {

    die('Periode tidak ditemukan.');

}


$awal = $_GET['awal'];
$akhir = $_GET['akhir'];


if (
    !validTanggal($awal) ||
    !validTanggal($akhir)
) {

    die('Format tanggal tidak valid.');

}


if ($awal > $akhir) {

    die('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');

}


$awal_db = mysqli_real_escape_string(
    $db,
    $awal
);

$akhir_db = mysqli_real_escape_string(
    $db,
    $akhir
);


/* ==========================================================
   QUERY
========================================================== */

$sql = "

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
    BETWEEN '$awal_db'
    AND '$akhir_db'

GROUP BY s.kelas

ORDER BY s.kelas ASC

";


$result = mysqli_query(
    $db,
    $sql
);


if (!$result) {

    die(
        'Query gagal: ' .
        mysqli_error($db)
    );

}


$total_siswa = 0;
$total_sakit = 0;
$total_izin = 0;
$total_alpha = 0;

?>


<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>
Rekap Absensi Semua Kelas
</title>


<style>

@page {

    size: A4 landscape;

    margin: 12mm;

}


body {

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    font-size: 11px;

    color: #222;

}


.header {

    text-align: center;

    margin-bottom: 20px;

}


.header h2 {

    margin: 0;

    font-size: 20px;

}


.header h3 {

    margin: 5px 0;

    font-size: 15px;

}


.header p {

    margin: 4px 0;

}


table {

    width: 100%;

    border-collapse: collapse;

}


th,
td {

    border: 1px solid #333;

    padding: 7px;

}


th {

    background: #e9ecef;

    text-align: center;

}


.center {

    text-align: center;

}


.right {

    text-align: right;

}


.total {

    background: #343a40;

    color: white;

    font-weight: bold;

}


.footer {

    margin-top: 30px;

    display: flex;

    justify-content: space-between;

}


@media print {

    .no-print {

        display: none;

    }

}

</style>

</head>


<body>


<div class="header">

    <h2>
        SMK NEGERI 6 JEMBER
    </h2>

    <h3>
        REKAPITULASI ABSENSI SISWA
    </h3>

    <p>
        Periode:
        <strong>
            <?= date(
                'd/m/Y',
                strtotime($awal)
            ) ?>
        </strong>

        s/d

        <strong>
            <?= date(
                'd/m/Y',
                strtotime($akhir)
            ) ?>
        </strong>
    </p>

</div>



<table>

<thead>

<tr>

    <th width="5%">
        No
    </th>

    <th>
        Kelas
    </th>

    <th>
        Jumlah Siswa
    </th>

    <th>
        Sakit
    </th>

    <th>
        Izin
    </th>

    <th>
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

while (
    $row = mysqli_fetch_assoc($result)
) {

    $siswa =
        (int)$row['jumlah_siswa'];

    $sakit =
        (int)$row['sakit'];

    $izin =
        (int)$row['izin'];

    $alpha =
        (int)$row['alpha'];

    $total =
        $sakit +
        $izin +
        $alpha;


    $total_siswa += $siswa;

    $total_sakit += $sakit;

    $total_izin += $izin;

    $total_alpha += $alpha;

?>

<tr>

    <td class="center">
        <?= $no++ ?>
    </td>

    <td>
        <?= htmlspecialchars(
            $row['kelas'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </td>

    <td class="center">
        <?= number_format($siswa) ?>
    </td>

    <td class="center">
        <?= number_format($sakit) ?>
    </td>

    <td class="center">
        <?= number_format($izin) ?>
    </td>

    <td class="center">
        <?= number_format($alpha) ?>
    </td>

    <td class="center">
        <?= number_format($total) ?>
    </td>

</tr>

<?php } ?>


<tr class="total">

    <td colspan="2"
        class="center">

        TOTAL SELURUH SEKOLAH

    </td>

    <td class="center">

        <?= number_format(
            $total_siswa
        ) ?>

    </td>

    <td class="center">

        <?= number_format(
            $total_sakit
        ) ?>

    </td>

    <td class="center">

        <?= number_format(
            $total_izin
        ) ?>

    </td>

    <td class="center">

        <?= number_format(
            $total_alpha
        ) ?>

    </td>

    <td class="center">

        <?= number_format(
            $total_sakit +
            $total_izin +
            $total_alpha
        ) ?>

    </td>

</tr>

</tbody>

</table>



<div class="footer">

    <div>

        Dicetak:
        <?= date('d/m/Y H:i') ?>
        WIB

    </div>

    <div>

        Rekapitulasi Absensi

    </div>

</div>



<script>

window.onload = function()
{

    window.print();

};

</script>


</body>

</html>
```
