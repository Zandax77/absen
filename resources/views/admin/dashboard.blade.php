@extends('blank')
@section('isi')
<div class="container py-4">

  <!-- Top Header / Bar -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 mb-4 border-bottom dashboard-header">
    <div class="d-flex align-items-center gap-2 gap-sm-3">
      <img src="{{asset($school_logo ?? 'images/logo_smk6.png')}}" width="55" height="55" alt="Logo" class="rounded">
      <div>
        <h4 class="fw-bold mb-0 text-dark">{{ $school_name ?? 'SMKN 6 JEMBER' }} &bull; Dashboard Admin</h4>
        <small class="text-muted">
          Login sebagai: <span class="badge bg-primary-subtle text-primary fw-semibold"><i class="bi bi-shield-check me-1"></i>{{ session('admin_username') ?? 'Admin' }}</span>
        </small>
      </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ url('rekapAbsen') }}" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-graph-up me-1"></i> Rekap Realtime
      </a>
      <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan pada isian form:</div>
      <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Statistik Ringkasan -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3 fs-3">
            <i class="bi bi-person-badge"></i>
          </div>
          <div>
            <span class="text-muted small text-uppercase fw-semibold">Petugas Kelas</span>
            <h4 class="mb-0 fw-bold">{{ $totalPetugas }}</h4>
            <small class="text-warning fw-semibold">
              <i class="bi bi-clock-history"></i> {{ $petugasMenunggu }} menunggu persetujuan
            </small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="bg-success-subtle text-success rounded-3 p-3 me-3 fs-3">
            <i class="bi bi-person-workspace"></i>
          </div>
          <div>
            <span class="text-muted small text-uppercase fw-semibold">Wali Kelas</span>
            <h4 class="mb-0 fw-bold">{{ $totalWali }}</h4>
            <small class="text-muted">Akun guru terdaftar</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card shadow-sm border-0 h-100" style="cursor: pointer;" onclick="document.getElementById('siswa-tab').click()">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="bg-info-subtle text-info rounded-3 p-3 me-3 fs-3">
            <i class="bi bi-people"></i>
          </div>
          <div>
            <span class="text-muted small text-uppercase fw-semibold">Total Siswa</span>
            <h4 class="mb-0 fw-bold">{{ $totalSiswa }}</h4>
            <small class="text-primary fw-semibold"><i class="bi bi-arrow-right-circle me-1"></i>Kelola Siswa</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="bg-warning-subtle text-warning rounded-3 p-3 me-3 fs-3">
            <i class="bi bi-calendar-check"></i>
          </div>
          <div>
            <span class="text-muted small text-uppercase fw-semibold">Absensi Hari Ini</span>
            <h4 class="mb-0 fw-bold">{{ $totalAbsenHariIni }}</h4>
            <small class="text-muted">{{ date('d F Y') }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Nav Tabs -->
  <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; scrollbar-width:none;">
  <ul class="nav nav-tabs nav-tabs-bordered mb-4 flex-nowrap" id="adminTabs" role="tablist" style="min-width:max-content;">
    <li class="nav-item" role="presentation">
      <button class="nav-link active fw-semibold" id="petugas-tab" data-bs-toggle="tab" data-bs-target="#tab-petugas" type="button" role="tab">
        <i class="bi bi-person-check me-1"></i> Kelola Petugas Kelas
        @if($petugasMenunggu > 0)
          <span class="badge bg-danger rounded-pill ms-1">{{ $petugasMenunggu }}</span>
        @endif
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-semibold" id="wali-tab" data-bs-toggle="tab" data-bs-target="#tab-wali" type="button" role="tab">
        <i class="bi bi-person-lines-fill me-1"></i> Data Wali Kelas
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-semibold" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#tab-siswa" type="button" role="tab">
        <i class="bi bi-people-fill me-1"></i> Kelola Data Siswa
        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill ms-1">{{ $totalSiswa }}</span>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-semibold" id="import-tab" data-bs-toggle="tab" data-bs-target="#tab-import" type="button" role="tab">
        <i class="bi bi-file-earmark-excel me-1"></i> Import Excel / CSV
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-semibold" id="shortcut-tab" data-bs-toggle="tab" data-bs-target="#tab-shortcut" type="button" role="tab">
        <i class="bi bi-link-45deg me-1"></i> Akses Modul Aplikasi
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-semibold" id="settings-tab" data-bs-toggle="tab" data-bs-target="#tab-settings" type="button" role="tab">
        <i class="bi bi-gear-fill me-1"></i> Pengaturan Sekolah
      </button>
    </li>
  </ul>
  </div>

  <!-- Tab Contents -->
  <div class="tab-content" id="adminTabsContent">

    <!-- Tab 1: Petugas Kelas -->
    <div class="tab-pane fade show active" id="tab-petugas" role="tabpanel">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h5 class="fw-bold mb-0 text-dark">Daftar Akun Petugas Absensi Siswa</h5>
          <span class="text-muted small">Status pendaftaran petugas kelas</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3" width="60">No</th>
                  <th>Nama Petugas</th>
                  <th>Kelas</th>
                  <th>Kode Pengguna</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" width="220">Aksi Persetujuan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($petugas as $index => $item)
                  <tr>
                    <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                    <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $item->kelas }}</span></td>
                    <td><code>{{ $item->kode }}</code></td>
                    <td class="text-center">
                      @if($item->status == 'disetujui')
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">
                          <i class="bi bi-check-circle me-1"></i> Disetujui
                        </span>
                      @else
                        <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill">
                          <i class="bi bi-hourglass-split me-1"></i> Menunggu
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="d-flex flex-column flex-sm-row gap-1 justify-content-center btn-group btn-group-sm" role="group">
                        @if($item->status == 'menunggu')
                          <a href="{{ url('setujui/' . $item->kode) }}" class="btn btn-success" title="Setujui Akun">
                            <i class="bi bi-check-lg me-1"></i> Setujui
                          </a>
                        @else
                          <a href="{{ url('blokir/' . $item->kode) }}" class="btn btn-outline-warning" title="Tangguhkan / Blokir" onclick="return confirm('Tangguhkan akses akun ini?')">
                            <i class="bi bi-slash-circle me-1"></i> Blokir
                          </a>
                        @endif
                        <a href="{{ url('hapus/' . $item->kode) }}" class="btn btn-outline-danger" title="Hapus Akun" onclick="return confirm('Hapus permanen akun petugas ini?')">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                      Belum ada pendaftaran petugas kelas.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 2: Wali Kelas -->
    <div class="tab-pane fade" id="tab-wali" role="tabpanel">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h5 class="fw-bold mb-0 text-dark">Daftar Akun Wali Kelas</h5>
          <a href="{{ url('regWaliKelas') }}" target="_blank" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Daftarkan Wali Kelas Baru
          </a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3" width="60">No</th>
                  <th>Nama Wali Kelas</th>
                  <th>Kelas Bimbingan</th>
                  <th>Kode Pengguna</th>
                </tr>
              </thead>
              <tbody>
                @forelse($walis as $index => $w)
                  <tr>
                    <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                    <td class="fw-semibold text-dark">{{ $w->nama }}</td>
                    <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $w->kelas }}</span></td>
                    <td><code>{{ $w->kode }}</code></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                      <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                      Belum ada data wali kelas.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 3: Kelola Data Siswa (CRUD) -->
    <div class="tab-pane fade" id="tab-siswa" role="tabpanel">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
          <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-info me-2"></i>Kelola Data Master Siswa</h5>
            <small class="text-muted">Tambah siswa baru, ubah rincian siswa, hapus data, serta filter per kelas</small>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-primary btn-sm fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
              <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Baru
            </button>
            <button type="button" class="btn btn-outline-success btn-sm fw-semibold" onclick="document.getElementById('import-tab').click()">
              <i class="bi bi-file-earmark-excel me-1"></i> Import Berkas
            </button>
            @if($totalSiswa > 0)
              <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapusMassalSiswa" title="Pilihan Reset Siswa">
                <i class="bi bi-trash3 me-1"></i> Reset Data
              </button>
            @endif
          </div>
        </div>

        <!-- Filter & Bar Pencarian Siswa -->
        <div class="card-body p-3 p-sm-4 border-bottom bg-light bg-opacity-50">
          <form action="{{ url('admin') }}" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="tab" value="siswa">
            <div class="col-12 col-md-5">
              <div class="input-group">
                <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="Cari nama atau NIS siswa..." value="{{ request('q') }}">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <select name="kelas" class="form-select">
                <option value="">-- Semua Kelas ({{ $daftarKelas->count() }} kelas) --</option>
                @foreach($daftarKelas as $kls)
                  <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 d-flex gap-2">
              <button type="submit" class="btn btn-primary w-100 fw-semibold">
                <i class="bi bi-funnel me-1"></i> Filter
              </button>
              @if(request('q') || request('kelas'))
                <a href="{{ url('admin') }}?tab=siswa" class="btn btn-outline-secondary" title="Hapus Filter">
                  <i class="bi bi-x-circle"></i>
                </a>
              @endif
            </div>
          </form>
        </div>

        <!-- Tabel Siswa -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3" width="60">No</th>
                  <th width="140">NIS</th>
                  <th>Nama Lengkap Siswa</th>
                  <th width="140">Jenis Kelamin</th>
                  <th width="160">Kelas</th>
                  <th class="text-center" width="170">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswas as $index => $item)
                  <tr>
                    <td class="ps-3 text-muted">{{ $siswas->firstItem() + $index }}</td>
                    <td>
                      <span class="font-monospace fw-semibold px-2 py-1 bg-light rounded border text-secondary">{{ $item->nis }}</span>
                    </td>
                    <td>
                      <span class="fw-bold text-dark">{{ $item->nama }}</span>
                    </td>
                    <td>
                      @if(strtoupper($item->jk) == 'L')
                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 rounded-pill">
                          <i class="bi bi-gender-male me-1"></i>Laki-laki
                        </span>
                      @elseif(strtoupper($item->jk) == 'P')
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                          <i class="bi bi-gender-female me-1"></i>Perempuan
                        </span>
                      @else
                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 rounded-pill">{{ $item->jk }}</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">{{ $item->kelas }}</span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" title="Ubah Data Siswa"
                          data-id="{{ $item->id }}"
                          data-nis="{{ $item->nis }}"
                          data-nama="{{ $item->nama }}"
                          data-jk="{{ strtoupper($item->jk) }}"
                          data-kelas="{{ $item->kelas }}"
                          onclick="bukaModalEdit(this)">
                          <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        <a href="{{ route('admin.siswa.destroy', $item->id) }}" class="btn btn-outline-danger" title="Hapus Siswa" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa \'{{ addslashes($item->nama) }}\' (NIS: {{ $item->nis }})?')">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                      <div class="py-3">
                        <i class="bi bi-people fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        @if(request('q') || request('kelas'))
                          <h6 class="fw-bold text-dark">Data Siswa Tidak Ditemukan</h6>
                          <p class="small mb-3">Tidak ada data siswa yang cocok dengan kriteria filter yang Anda pilih.</p>
                          <a href="{{ url('admin') }}?tab=siswa" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Tampilkan Seluruh Siswa
                          </a>
                        @else
                          <h6 class="fw-bold text-dark">Belum Ada Data Siswa</h6>
                          <p class="small mb-3">Mulai tambahkan data siswa secara manual atau unggah berkas Excel / CSV.</p>
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                            <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Pertama
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination & Info Bawah -->
          @if($siswas->total() > 0)
            <div class="card-footer bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 border-top">
              <div class="small text-muted">
                Menampilkan <strong>{{ $siswas->firstItem() ?? 0 }}</strong> - <strong>{{ $siswas->lastItem() ?? 0 }}</strong> dari <strong>{{ $siswas->total() }}</strong> total siswa
                @if(request('kelas'))
                  (Filter Kelas: <span class="badge bg-light text-dark border">{{ request('kelas') }}</span>)
                @endif
              </div>
              <div class="pagination-wrapper">
                {{ $siswas->links() }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="tab-import" role="tabpanel">
      <div class="row g-4">
        <!-- Import Siswa -->
        <div class="col-12 col-lg-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-excel text-success me-2"></i>Data Siswa</h5>
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.template.siswa.xlsx') }}" class="btn btn-success fw-semibold" title="Format Excel">
                  <i class="bi bi-file-earmark-spreadsheet me-1"></i> Template Excel (.xlsx)
                </a>
                <a href="{{ route('admin.template.siswa') }}" class="btn btn-outline-secondary" title="Format CSV">
                  .CSV
                </a>
              </div>
            </div>
            <div class="card-body p-4">
              <p class="text-muted small">
                Unggah file Excel (<strong>.xlsx</strong>) atau CSV berisi data siswa. Header kolom: <code>nis, nama, kelas, jk</code>.
              </p>
              <form action="{{ url('admin/siswa/import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label class="form-label small fw-semibold">Pilih Berkas (Excel / CSV)</label>
                  <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
                </div>
                <div class="p-3 bg-light rounded small mb-3">
                  <span class="fw-bold d-block mb-1">Contoh data siswa:</span>
                  <code>nis,nama,kelas,jk<br>1001,Ahmad Fajar Pratama,X RPL 1,L<br>1002,Annisa Rahmawati,X RPL 1,P</code>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-semibold">
                  <i class="bi bi-cloud-arrow-up me-1"></i> Unggah & Simpan Data Siswa
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Import Wali -->
        <div class="col-12 col-lg-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-excel text-primary me-2"></i>Data Wali Kelas</h5>
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.template.wali.xlsx') }}" class="btn btn-primary fw-semibold" title="Format Excel">
                  <i class="bi bi-file-earmark-spreadsheet me-1"></i> Template Excel (.xlsx)
                </a>
                <a href="{{ route('admin.template.wali') }}" class="btn btn-outline-secondary" title="Format CSV">
                  .CSV
                </a>
              </div>
            </div>
            <div class="card-body p-4">
              <p class="text-muted small">
                Unggah file Excel (<strong>.xlsx</strong>) atau CSV berisi data wali kelas. Header kolom: <code>kode, nama, kelas, sandi</code>.
              </p>
              <form action="{{ url('admin/wali/import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label class="form-label small fw-semibold">Pilih Berkas (Excel / CSV)</label>
                  <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
                </div>
                <div class="p-3 bg-light rounded small mb-3">
                  <span class="fw-bold d-block mb-1">Contoh data wali kelas:</span>
                  <code>kode,nama,kelas,sandi<br>WALI_XRPL1,Budi Santoso S.Pd.,X RPL 1,guru123</code>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                  <i class="bi bi-cloud-arrow-up me-1"></i> Unggah & Simpan Data Wali
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 4: Modul Pintasan -->
    <div class="tab-pane fade" id="tab-shortcut" role="tabpanel">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
          <h5 class="fw-bold mb-0 text-dark">Pintasan Modul Aplikasi Presensi</h5>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-3">
              <a href="{{ url('rekapAbsen') }}" target="_blank" class="card text-decoration-none border h-100 p-3 shadow-none hover-shadow">
                <div class="fs-2 text-primary mb-2"><i class="bi bi-graph-up-arrow"></i></div>
                <h6 class="fw-bold text-dark mb-1">Rekap Absensi Realtime</h6>
                <small class="text-muted">Grafik tren, statistik ketidakhadiran, dan perbandingan kelas.</small>
              </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
              <a href="{{ url('rekapAbsen/histori') }}" target="_blank" class="card text-decoration-none border h-100 p-3 shadow-none hover-shadow">
                <div class="fs-2 text-warning mb-2"><i class="bi bi-clock-history"></i></div>
                <h6 class="fw-bold text-dark mb-1">Riwayat & Cetak Rekap</h6>
                <small class="text-muted">Cari histori absensi siswa per periode & cetak lembar rekap.</small>
              </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
              <a href="{{ url('loginKelas') }}" target="_blank" class="card text-decoration-none border h-100 p-3 shadow-none hover-shadow">
                <div class="fs-2 text-success mb-2"><i class="bi bi-clipboard2-check"></i></div>
                <h6 class="fw-bold text-dark mb-1">Portal Absensi Siswa</h6>
                <small class="text-muted">Halaman login untuk petugas pencatat absensi harian kelas.</small>
              </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
              <a href="{{ url('wali') }}" target="_blank" class="card text-decoration-none border h-100 p-3 shadow-none hover-shadow">
                <div class="fs-2 text-info mb-2"><i class="bi bi-person-workspace"></i></div>
                <h6 class="fw-bold text-dark mb-1">Portal Wali Kelas</h6>
                <small class="text-muted">Halaman pemantauan dan input absensi khusus bimbingan wali kelas.</small>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 5: Pengaturan Sekolah -->
    <div class="tab-pane fade" id="tab-settings" role="tabpanel">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
          <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-gear-fill text-primary me-2"></i>Pengaturan Nama & Logo Sekolah</h5>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
              <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-bold d-block mb-3">Logo Sekolah Saat Ini</label>
                <div class="p-3 border rounded-3 bg-light d-inline-block shadow-sm mb-3">
                  <img src="{{ asset($currentSchoolLogo ?? 'images/logo_smk6.png') }}" id="logoPreview" width="140" height="140" class="img-fluid rounded" alt="Logo Sekolah" style="object-fit: contain; max-height: 140px;">
                </div>
                <div class="text-muted small">Format: PNG, JPG, JPEG, SVG, WEBP (Maks. 2MB)</div>
              </div>

              <div class="col-12 col-md-8">
                <div class="mb-3">
                  <label for="school_name" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                  <input type="text" name="school_name" id="school_name" class="form-control form-control-lg" value="{{ $currentSchoolName ?? 'SMKN 6 JEMBER' }}" required placeholder="Contoh: SMKN 6 JEMBER">
                  <div class="form-text">Nama sekolah ini akan tampil di seluruh halaman login, registrasi, laporan, dan header dashboard.</div>
                </div>

                <div class="mb-3">
                  <label for="app_title" class="form-label fw-semibold">Judul / Tagline Aplikasi</label>
                  <input type="text" name="app_title" id="app_title" class="form-control" value="{{ $currentAppTitle ?? 'Aplikasi Pencatat Kehadiran Siswa Kelas' }}" placeholder="Contoh: Aplikasi Pencatat Kehadiran Siswa Kelas">
                  <div class="form-text">Tampil sebagai sub-judul atau nama aplikasi di area login dan footer.</div>
                </div>

                <div class="mb-4">
                  <label for="logoInput" class="form-label fw-semibold">Unggah File Logo Baru</label>
                  <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                  <div class="form-text">Biarkan kosong jika tidak ingin mengubah logo saat ini. Disarankan gambar berlatar transparan (PNG).</div>
                </div>

                <button type="submit" class="btn btn-primary fw-semibold px-4 py-2 shadow-sm">
                  <i class="bi bi-save me-1"></i> Simpan Pengaturan Sekolah
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- Modal Tambah Siswa (Create) -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow border-0">
      <form action="{{ route('admin.siswa.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold text-dark" id="modalTambahSiswaLabel">
            <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Data Siswa Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="tambah_nis" class="form-label fw-semibold small">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
            <input type="text" name="nis" id="tambah_nis" class="form-control" required placeholder="Contoh: 1001" autofocus>
            <div class="form-text">NIS harus unik dan belum digunakan siswa lain.</div>
          </div>
          <div class="mb-3">
            <label for="tambah_nama" class="form-label fw-semibold small">Nama Lengkap Siswa <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="tambah_nama" class="form-control" required placeholder="Contoh: Muhammad Rizky Pratama">
          </div>
          <div class="mb-3">
            <label for="tambah_kelas" class="form-label fw-semibold small">Kelas <span class="text-danger">*</span></label>
            <input type="text" name="kelas" id="tambah_kelas" list="listKelasDatalist" class="form-control" required placeholder="Contoh: X RPL 1" autocomplete="off">
            <div class="form-text">Pilih salah satu kelas dari daftar atau ketik nama kelas baru.</div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold small d-block">Jenis Kelamin <span class="text-danger">*</span></label>
            <div class="d-flex gap-4 pt-1">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jk" id="tambah_jk_l" value="L" required checked>
                <label class="form-check-label" for="tambah_jk_l">
                  <i class="bi bi-gender-male text-info me-1"></i> Laki-laki (L)
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jk" id="tambah_jk_p" value="P" required>
                <label class="form-check-label" for="tambah_jk_p">
                  <i class="bi bi-gender-female text-danger me-1"></i> Perempuan (P)
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm fw-semibold">
            <i class="bi bi-check-lg me-1"></i> Simpan Data Siswa
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Siswa (Update) -->
<div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-labelledby="modalEditSiswaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow border-0">
      <form id="formEditSiswa" action="" method="POST">
        @csrf
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold text-dark" id="modalEditSiswaLabel">
            <i class="bi bi-pencil-square text-primary me-2"></i>Ubah Data Siswa
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="edit_nis" class="form-label fw-semibold small">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
            <input type="text" name="nis" id="edit_nis" class="form-control" required placeholder="Contoh: 1001">
          </div>
          <div class="mb-3">
            <label for="edit_nama" class="form-label fw-semibold small">Nama Lengkap Siswa <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="edit_nama" class="form-control" required placeholder="Contoh: Muhammad Rizky Pratama">
          </div>
          <div class="mb-3">
            <label for="edit_kelas" class="form-label fw-semibold small">Kelas <span class="text-danger">*</span></label>
            <input type="text" name="kelas" id="edit_kelas" list="listKelasDatalist" class="form-control" required placeholder="Contoh: X RPL 1" autocomplete="off">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold small d-block">Jenis Kelamin <span class="text-danger">*</span></label>
            <div class="d-flex gap-4 pt-1">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jk" id="edit_jk_l" value="L" required>
                <label class="form-check-label" for="edit_jk_l">
                  <i class="bi bi-gender-male text-info me-1"></i> Laki-laki (L)
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jk" id="edit_jk_p" value="P" required>
                <label class="form-check-label" for="edit_jk_p">
                  <i class="bi bi-gender-female text-danger me-1"></i> Perempuan (P)
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm fw-semibold">
            <i class="bi bi-save me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Reset / Hapus Massal Data Siswa -->
<div class="modal fade" id="modalHapusMassalSiswa" tabindex="-1" aria-labelledby="modalHapusMassalSiswaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow border-0">
      <form action="{{ route('admin.siswa.destroyAll') }}" method="POST">
        @csrf
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title fw-bold" id="modalHapusMassalSiswaLabel">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Reset / Hapus Data Siswa
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="text-danger fw-semibold mb-2">Peringatan: Tindakan ini akan menghapus data secara permanen!</p>
          <p class="small text-muted mb-3">Pilih target penghapusan apakah menghapus seluruh siswa atau hanya siswa pada kelas tertentu:</p>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Target Siswa yang Dihapus:</label>
            <select name="kelas" class="form-select">
              <option value="">-- Kosongkan Seluruh Database Siswa (Semua Kelas) --</option>
              @foreach($daftarKelas as $kls)
                <option value="{{ $kls }}">Hanya Siswa Kelas {{ $kls }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm fw-semibold" onclick="return confirm('Apakah Anda yakin ingin melanjutkan proses penghapusan data siswa ini?')">
            <i class="bi bi-trash-fill me-1"></i> Ya, Lanjutkan Hapus
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Datalist Kelas untuk Input Cepat & Konsisten -->
<datalist id="listKelasDatalist">
  @foreach($daftarKelas as $kls)
    <option value="{{ $kls }}">
  @endforeach
</datalist>

<script>
function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('logoPreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}

function bukaModalEdit(el) {
  const id = el.getAttribute('data-id');
  const nis = el.getAttribute('data-nis');
  const nama = el.getAttribute('data-nama');
  const kelas = el.getAttribute('data-kelas');
  const jk = el.getAttribute('data-jk');

  const form = document.getElementById('formEditSiswa');
  form.action = "{{ url('admin/siswa') }}/" + id + "/update";

  document.getElementById('edit_nis').value = nis;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_kelas').value = kelas;

  if (jk === 'P') {
    document.getElementById('edit_jk_p').checked = true;
  } else {
    document.getElementById('edit_jk_l').checked = true;
  }

  const modal = new bootstrap.Modal(document.getElementById('modalEditSiswa'));
  modal.show();
}

// Aktifkan tab otomatis jika ada query param ?tab=... atau hash
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  if (tabParam) {
    const triggerEl = document.querySelector(`button[data-bs-target="#tab-${tabParam}"]`);
    if (triggerEl) {
      const tab = new bootstrap.Tab(triggerEl);
      tab.show();
    }
  }
});
</script>
@endsection
