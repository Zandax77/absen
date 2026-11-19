<?php
include "konek.php";
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

// --- 1. DATA SUMMARY HARI INI ---
$s_hari_ini = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='S' AND DATE(created_at) = '$today'"));
$i_hari_ini = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='I' AND DATE(created_at) = '$today'"));
$a_hari_ini = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='A' AND DATE(created_at) = '$today'"));

// --- 2. DATA PER KELAS HARI INI (Untuk Chart Bar) ---
$labels_kelas = []; $s_kelas = []; $i_kelas = []; $a_kelas = [];
$q_kelas = mysqli_query($db, "SELECT kelas FROM siswas GROUP BY kelas ORDER BY kelas ASC");
while($rk = mysqli_fetch_array($q_kelas)){
    $kls = $rk['kelas'];
    $labels_kelas[] = $kls;
    $s_kelas[] = mysqli_num_rows(mysqli_query($db, "SELECT a.id FROM absens a JOIN siswas s ON a.nis=s.nis WHERE s.kelas='$kls' AND a.ket='S' AND DATE(a.created_at)='$today'"));
    $i_kelas[] = mysqli_num_rows(mysqli_query($db, "SELECT a.id FROM absens a JOIN siswas s ON a.nis=s.nis WHERE s.kelas='$kls' AND a.ket='I' AND DATE(a.created_at)='$today'"));
    $a_kelas[] = mysqli_num_rows(mysqli_query($db, "SELECT a.id FROM absens a JOIN siswas s ON a.nis=s.nis WHERE s.kelas='$kls' AND a.ket='A' AND DATE(a.created_at)='$today'"));
}

// --- 3. DATA TREN 7 HARI TERAKHIR (Untuk Line Chart) ---
$tren_labels = []; $tren_sakit = []; $tren_izin = []; $tren_alpha = [];
for ($x = 6; $x >= 0; $x--) {
    $tgl = date('Y-m-d', strtotime("-$x days"));
    $tren_labels[] = date('d M', strtotime($tgl));
    $tren_sakit[] = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='S' AND DATE(created_at) = '$tgl'"));
    $tren_izin[] = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='I' AND DATE(created_at) = '$tgl'"));
    $tren_alpha[] = mysqli_num_rows(mysqli_query($db, "SELECT id FROM absens WHERE ket='A' AND DATE(created_at) = '$tgl'"));
}

// --- 4. RANKING KELAS (7 HARI TERAKHIR) ---
$ranking_kelas = [];
$q_rank = mysqli_query($db, "
    SELECT s.kelas, 
           SUM(CASE WHEN a.ket = 'S' THEN 1 ELSE 0 END) as s,
           SUM(CASE WHEN a.ket = 'I' THEN 1 ELSE 0 END) as i,
           SUM(CASE WHEN a.ket = 'A' THEN 1 ELSE 0 END) as a,
           COUNT(a.id) as total
    FROM absens a
    JOIN siswas s ON a.nis = s.nis
    WHERE DATE(a.created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY s.kelas
    ORDER BY total DESC
    LIMIT 5
");
while($row = mysqli_fetch_assoc($q_rank)) {
    $ranking_kelas[] = $row;
}

$response = [
    "summary" => [
        "sakit" => $s_hari_ini,
        "izin" => $i_hari_ini,
        "alpha" => $a_hari_ini,
        "last_update" => date('H:i:s')
    ],
    "grafik_kelas" => [
        "labels" => $labels_kelas,
        "sakit" => $s_kelas,
        "izin" => $i_kelas,
        "alpha" => $a_kelas
    ],
    "tren_7_hari" => [
        "labels" => $tren_labels,
        "sakit" => $tren_sakit,
        "izin" => $tren_izin,
        "alpha" => $tren_alpha
    ],
    "ranking_7_hari" => $ranking_kelas
];

echo json_encode($response);