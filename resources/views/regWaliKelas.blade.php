@extends('blank')
@section('isi')
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-3 py-sm-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-3 py-sm-4">
                  <img src="{{ $school_logo ? asset($school_logo) : asset('images/logo_smk6.png') }}" class="logo-img-auth" alt="{{ $school_name ?? 'Logo Sekolah' }}">
              </div><!-- End Logo -->

              <div class="card mb-3 shadow-sm border-0 w-100">

                <div class="card-body p-3 p-sm-4">

                  <div class="pt-2 pb-2 text-center">
                    <h5 class="card-title text-center pb-0 fs-5 fw-bold">Buat Akun Wali Kelas</h5>
                    <p class="text-center small text-muted">Daftarkan akun untuk memantau presensi kelas bimbingan</p>
                  </div>

                  <form class="row g-3 needs-validation" action="simpanWali" method="POST">
                    @csrf
                    <div class="col-12">
                      <label for="yourName" class="form-label fw-semibold small">Nama Lengkap & Gelar</label>
                      <input type="text" name="nama" class="form-control" id="yourName" placeholder="Contoh: Budi Santoso, S.Pd." required>
                      <div class="invalid-feedback">Silahkan masukkan nama!</div>
                    </div>

                    <div class="col-12">
                      <label for="kelas" class="form-label fw-semibold small">Kelas Bimbingan</label>
                      <select name="kelas" id="kelas" required class="form-select">
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        @foreach ($kelas as $isi)
                            <option value="{{$isi['kelas']}}">{{$isi['kelas']}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label fw-semibold small">Kode Pengguna</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text bg-light" id="inputGroupPrepend">@</span>
                        <input type="text" name="kode" class="form-control" id="yourUsername" placeholder="kode_wali" required>
                        <div class="invalid-feedback">Silahkan masukkan kode wali kelas</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label fw-semibold small">Kata Sandi</label>
                      <input type="password" name="sandi" class="form-control" id="yourPassword" placeholder="••••••••" required>
                      <div class="invalid-feedback">Silahkan masukkan kata sandi</div>
                    </div>

                    <div class="col-12 pt-1">
                      <button class="btn btn-primary w-100 py-2 fw-semibold shadow-sm" type="submit">Buat Akun Wali</button>
                    </div>
                    <div class="col-12 text-center">
                      <p class="small mb-0">Sudah mempunyai akun? <a href="wali" class="fw-semibold">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits text-center text-muted small">
                {{ $school_name ?? 'SMKN 6 JEMBER' }} &bull; Portal Wali Kelas
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
@endsection
