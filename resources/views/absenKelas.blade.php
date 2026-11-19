<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Kelas - {{session()->get('kelas')}}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f0f2f5; 
            font-family: 'Inter', sans-serif;
            color: #334155;
        }
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
        }
        .main-card {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-top: 16px;
        }
        .card-header-custom {
            padding: 16px 20px;
            background: white;
            border-bottom: 1px solid #f1f5f9;
        }
        .table thead {
            background-color: #f8fafc;
        }
        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            border-top: none;
        }
        .badge-pill {
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        /* Custom Badge Colors */
        .bg-alpha { background-color: #fee2e2; color: #dc2626; } /* Red */
        .bg-izin { background-color: #e0f2fe; color: #0284c7; }  /* Blue */
        .bg-sakit { background-color: #fef3c7; color: #d97706; } /* Yellow/Orange */

        .btn-add {
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #94a3b8;
        }
        .empty-state i {
            font-size: 3rem;
            display: block;
            margin-bottom: 10px;
        }

        @media (max-width: 575.98px) {
            .card-header-custom { padding: 12px 14px; }
            .card-header-custom h5 { font-size: 0.95rem; }
            .card-header-custom .text-muted.small { font-size: 0.72rem; }
            .btn-add { font-size: 0.78rem; padding: 7px 12px; }
            .table { font-size: 0.82rem; }
            .table th, .table td { padding: 0.45rem 0.4rem; }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="ms-3">
                    <div class="fw-bold leading-none" style="font-size: 0.9rem;">{{session()->get('opr')}}</div>
                    <small class="text-muted" style="font-size: 0.75rem;">Petugas Absensi</small>
                </div>
            </div>
            <a href="logout" class="btn btn-sm btn-outline-danger px-3">
                <i class="bi bi-box-arrow-right me-1"></i> Log out
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="main-card">
            <!-- Title Section -->
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-bold text-dark">Kelas: {{session()->get('kelas')}}</h5>
                    <div class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i> {{date('d F Y')}}
                    </div>
                </div>
                <button class="btn btn-primary btn-add shadow-sm" data-bs-target="#absen" data-bs-toggle="modal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                </button>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="80">No</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center" width="120">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @forelse ($absen as $hasil)
                        <tr>
                            <td class="ps-4 text-muted">{{$no++}}</td>
                            <td class="fw-medium text-dark">{{$hasil['nama']}}</td>
                            <td class="text-center">
                                @if($hasil['ket'] == 'A')
                                    <span class="badge badge-pill bg-alpha">Alpha</span>
                                @elseif($hasil['ket'] == 'I')
                                    <span class="badge badge-pill bg-izin">Izin</span>
                                @else
                                    <span class="badge badge-pill bg-sakit">Sakit</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="bi bi-clipboard-check"></i>
                                    <p class="mb-0">Semua siswa hadir (Nihil)</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah Absen -->
    <div class="modal fade" id="absen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Input Ketidakhadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="simpanAbsenKelas" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Pilih Nama Siswa</label>
                            <select name="nis" class="form-select form-select-lg border-light-subtle" required style="font-size: 1rem;">
                                <option value="" selected disabled>Cari nama siswa...</option>
                                @foreach ($data as $isi)
                                    <option value="{{$isi['nis']}}">{{$isi['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <input type="hidden" name="tgl" value="{{date('d/m/Y')}}">
                        <input type="hidden" name="kelas" value="{{session()->get('kelas')}}">
                        
                        <div class="mb-2">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Keterangan</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="ket" id="ket_a" value="A" checked>
                                <label class="btn btn-outline-danger flex-fill" for="ket_a">Alpha</label>

                                <input type="radio" class="btn-check" name="ket" id="ket_i" value="I">
                                <label class="btn btn-outline-info flex-fill" for="ket_i">Izin</label>

                                <input type="radio" class="btn-check" name="ket" id="ket_s" value="S">
                                <label class="btn btn-outline-warning flex-fill" for="ket_s">Sakit</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light text-muted w-100" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary w-100" type="submit">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>