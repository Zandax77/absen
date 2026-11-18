<?php
session_start();
// Koneksi database - Pastikan kredensial benar
$db = mysqli_connect('localhost','u317499974_admin_absen','w=tp~tNu6I@g','u317499974_absensiswa');

// Get filter parameters
$awal = isset($_GET['awal']) ? $_GET['awal'] : '';
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Helper Functions
function formatDate($tgl) {
    $parts = explode('/', $tgl);
    if(count($parts) == 3) {
        $day = $parts[0]; $month = $parts[1]; $year = $parts[2];
        if(checkdate($month, $day, $year)) {
            return date('d M y', mktime(0, 0, 0, $month, $day, $year));
        }
    }
    return $tgl;
}

function getKetBadge($ket) {
    switch($ket) {
        case 'S': return '<span class="badge bg-warning text-dark" style="width:25px">S</span>';
        case 'I': return '<span class="badge bg-success" style="width:25px">I</span>';
        case 'A': return '<span class="badge bg-danger" style="width:25px">A</span>';
        default: return '<span class="badge bg-secondary" style="width:25px">'.$ket.'</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Ketidakhadiran Siswa</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f0f2f5; 
            font-family: 'Inter', sans-serif; 
            color: #333;
        }
        .card { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        }
        .header-section {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .student-card { 
            border-left: 5px solid #4e73df; 
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        .student-card:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .date-item {
            background: #fff;
            border: 1px solid #e3e6f0;
            padding: 5px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .filter-card {
            margin-top: -50px;
        }
        @media (max-width: 576px) {
            .header-section { padding: 1.5rem 1rem; text-align: center; }
            .date-item { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="container py-4">
        <!-- Header -->
        <div class="header-section text-center text-md-start">
            <h2 class="fw-bold mb-0"><i class="bi bi-person-x-fill me-2"></i> Riwayat Absensi</h2>
            <p class="opacity-75 mb-0">Monitoring ketidakhadiran siswa secara real-time</p>
        </div>

        <!-- Filter Form -->
        <div class="card filter-card mb-4">
            <div class="card-body p-4">
                <form method="GET" action="" class="row g-3">
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold small text-uppercase">Pilih Kelas</label>
                        <select name="kelas" class="form-select border-0 bg-light" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            <?php
                            $kelas_query = mysqli_query($db,"SELECT kelas FROM siswas GROUP BY kelas ORDER BY kelas");
                            while($row = mysqli_fetch_array($kelas_query)){
                                $selected = ($kelas == $row[0]) ? 'selected' : '';
                                echo "<option value='$row[0]' $selected>$row[0]</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold small text-uppercase">Dari Tanggal</label>
                        <input type="date" name="awal" class="form-control border-0 bg-light" value="<?php echo $awal; ?>">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-semibold small text-uppercase">Sampai Tanggal</label>
                        <input type="date" name="akhir" class="form-control border-0 bg-light" value="<?php echo $akhir; ?>">
                    </div>
                    <div class="col-12 col-md-3 d-grid">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary fw-bold py-2">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php if($awal && $akhir): ?>
        <div class="alert alert-white border-0 shadow-sm mb-4 d-flex align-items-center">
            <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
            <div>
                Menampilkan data <strong><?php echo $kelas ? "Kelas $kelas" : "Semua Kelas"; ?></strong><br>
                <small class="text-muted">Periode: <?php echo date('d M Y', strtotime($awal)); ?> — <?php echo date('d M Y', strtotime($akhir)); ?></small>
            </div>
        </div>
        <?php endif; ?>

        <?php
        // Logic Query Siswa
        $where_siswa = $kelas ? "WHERE kelas='$kelas'" : "";
        $siswa_query = mysqli_query($db, "SELECT * FROM siswas $where_siswa ORDER BY kelas ASC, nama ASC");

        $total_siswa_tidak_hadir = 0;

        while($siswa = mysqli_fetch_array($siswa_query)){
            $nis = $siswa['nis'];
            $nama = $siswa['nama'];
            $kelas_siswa = $siswa['kelas'];

            // Query Absen
            if($awal && $akhir) {
                $absen_query = mysqli_query($db, "SELECT tgl, ket FROM absens WHERE nis='$nis' AND DATE(created_at) BETWEEN '$awal' AND '$akhir' ORDER BY created_at DESC");
            } else {
                $absen_query = mysqli_query($db, "SELECT tgl, ket FROM absens WHERE nis='$nis' ORDER BY created_at DESC LIMIT 20");
            }

            $jml_absen = mysqli_num_rows($absen_query);

            if($jml_absen > 0):
                $total_siswa_tidak_hadir++;
        ?>

        <!-- Student Card -->
        <div class="card student-card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark"><?php echo $nama; ?></h5>
                        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                            <i class="bi bi-door-open me-1"></i> Kelas <?php echo $kelas_siswa; ?>
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
                        <a href="cetakSiswa.php?nis=<?php echo urlencode($nis); ?>&awal=<?php echo urlencode($awal); ?>&akhir=<?php echo urlencode($akhir); ?>" 
                           target="_blank" 
                           class="btn btn-outline-secondary btn-sm px-3 shadow-sm bg-white" 
                           title="Cetak Riwayat">
                            <i class="bi bi-printer"></i>
                        </a>
                        <div class="flex-grow-1 text-end">
                            <span class="badge bg-danger-subtle text-danger px-3 py-2 fs-6 w-100">
                                <?php echo $jml_absen; ?>x Absen
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <?php
                    $tanggal_list = array();
                    while($absen = mysqli_fetch_array($absen_query)){
                        $tanggal_list[$absen['tgl']] = $absen['ket'];
                    }
                    krsort($tanggal_list);

                    foreach($tanggal_list as $tgl => $ket):
                    ?>
                    <div class="date-item">
                        <?php echo getKetBadge($ket); ?>
                        <span class="ms-2 text-secondary fw-medium"><?php echo formatDate($tgl); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php
            endif;
        }
        ?>

        <!-- Empty State & Footer Info -->
        <?php if($total_siswa_tidak_hadir == 0): ?>
        <div class="card border-0 shadow-sm mt-5">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-emoji-smile text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold">Luar Biasa!</h4>
                <p class="text-muted">Tidak ditemukan data ketidakhadiran untuk kriteria ini.</p>
                <a href="?" class="btn btn-primary px-4">Refresh Data</a>
            </div>
        </div>
        <?php else: ?>
        <div class="card bg-success text-white mt-4 border-0 shadow">
            <div class="card-body py-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-people-fill me-2 fs-4"></i>
                <span>Total <strong><?php echo $total_siswa_tidak_hadir; ?></strong> siswa memiliki catatan ketidakhadiran.</span>
            </div>
        </div>
        <?php endif; ?>

        <footer class="text-center mt-5 mb-4 text-muted small">
            &copy; <?php echo date('Y'); ?> Sistem Absensi Siswa | Responsive Dashboard
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>