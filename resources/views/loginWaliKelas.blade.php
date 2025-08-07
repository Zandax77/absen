@extends('blank')
@section('isi')
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <img src="{{asset('images/logo_smk6.png')}}" width="150" height="150" alt="">
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login Wali Kelas</h5>
                    <p class="text-center small">Masukkan kode pengguna dan sandi untuk login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="prosesLoginWali" method="POST">
                    @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Kode Pengguna</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="kode" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Silahkan ketik kode pengguna di sini.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Kata Sandi</label>
                      <input type="password" name="sandi" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Silahkan masukkan kata sandi anda!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Belum mempunyai akun? <a href="regWaliKelas">Daftar akun sebagai pengguna</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Aplikasi Info Absensi Kelas
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
@endsection
