@extends('blank')
@section('isi')

<style>
    /* Custom Styling untuk mempercantik */
    .breadcrumb-section {
        background: #ffffff;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        border-bottom: 2px solid #dee2e6;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
    }
    .iframe-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        background: white;
        margin-top: 30px;
    }
    .iframe-header {
        background: #4e73df;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
    }
</style>

<div class="container py-4">
    <!-- Header / Info Profil -->
    <div class="breadcrumb-section d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="mb-0 text-primary fw-bold">
                <i class="bi bi-person-workspace"></i> Wali Kelas: {{session()->get('kelas')}}
            </h5>
            <small class="text-muted">Nama: <b>{{session()->get('opr')}}</b></small>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="logoutWali" class="btn btn-outline-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin log out?')">
                <i class="bi bi-box-arrow-right"></i> Log out
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-3 pt-sm-4 px-3 px-sm-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-0 fs-5 fs-sm-4">Daftar Siswa Tidak Hadir</h4>
                <p class="text-muted small mb-0"><i class="bi bi-calendar-event"></i> Tanggal: {{date('d/m/Y')}}</p>
            </div>
            <button class="btn btn-warning fw-bold px-3 px-sm-4 shadow-sm btn-sm btn-sm-md" data-bs-target="#absen" data-bs-toggle="modal">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </button>
        </div>
        
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @forelse ($absen as $hasil)
                        <tr>
                            <td>{{$no++}}</td>
                            <td class="fw-bold">{{$hasil['nama']}}</td>
                            <td class="text-center">
                                @if($hasil['ket'] == 'A')
                                    <span class="badge bg-danger badge-status">Alpha</span>
                                @elseif($hasil['ket'] == 'I')
                                    <span class="badge bg-info badge-status text-dark">Izin</span>
                                @else
                                    <span class="badge bg-warning badge-status text-dark">Sakit</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="hapusAbsen/{{$hasil['id']}}" 
                                   class="btn btn-light btn-sm text-danger border" 
                                   onclick="return confirm('Batalkan ketidakhadiran siswa ini?')"
                                   title="Hapus Data">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle display-4 d-block mb-2"></i>
                                Belum ada data absensi hari ini (Nihil)
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section Iframe Rekap -->
    <div class="iframe-container mt-3">
        <div class="iframe-header">
            <i class="bi bi-graph-up"></i> Rekapitulasi Absensi Keseluruhan
        </div>
        <iframe src="{{ url('rekapAbsen') }}" frameborder="0" width="100%" style="height: clamp(300px, 50vw, 600px); min-height: 300px;"></iframe>
    </div>
</div>

<!-- Modal Tambah Absen -->
<div class="modal fade" id="absen" tabindex="-1" aria-labelledby="absenLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold" id="absenLabel">Tambah Siswa Tidak Hadir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="simpanAbsenKelasWali" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Nama Siswa</label>
                        <select name="nis" class="form-select form-select-lg" required>
                            <option value="" selected disabled>-- Pilih Siswa --</option>
                            @foreach ($data as $isi)
                                <option value="{{$isi['nis']}}">{{$isi['nama']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="tgl" value="{{date('d/m/Y')}}">
                    <input type="hidden" name="kelas" value="{{session()->get('kelas')}}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
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
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary px-4" type="submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection