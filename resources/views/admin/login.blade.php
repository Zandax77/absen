@extends('blank')
@section('isi')
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-3 py-sm-4">
                <img src="{{asset($school_logo ?? 'images/logo_smk6.png')}}" class="logo-img-auth" alt="{{ $school_name ?? 'Logo' }}">
              </div><!-- End Logo -->

              <div class="card mb-3 shadow-sm border-0 w-100">

                <div class="card-body p-4">

                  <div class="pt-2 pb-3 text-center">
                    <span class="badge bg-danger-subtle text-danger mb-2 px-3 py-1 rounded-pill fw-semibold">
                      <i class="bi bi-shield-lock-fill me-1"></i> Area Administrator
                    </span>
                    <h5 class="card-title text-center pb-0 fs-4 fw-bold">Login Admin</h5>
                    <p class="text-center small text-muted">Masukkan username dan kata sandi untuk mengelola sistem</p>
                  </div>

                  @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                      <i class="bi bi-exclamation-octagon-fill me-1"></i> {{ session('error') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                  @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                      <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                  <form class="row g-3 needs-validation" action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf
                    <div class="col-12">
                      <label for="adminUsername" class="form-label fw-semibold small">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" id="adminUsername" value="{{ old('username') }}" placeholder="admin" required autofocus>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="adminPassword" class="form-label fw-semibold small">Kata Sandi</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" class="form-control" id="adminPassword" placeholder="••••••••" required>
                      </div>
                    </div>

                    <div class="col-12 pt-2">
                      <button class="btn btn-primary w-100 fw-semibold py-2 shadow-sm" type="submit">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Dashboard
                      </button>
                    </div>

                    <div class="col-12 text-center pt-2">
                      <a href="{{ url('loginKelas') }}" class="small text-muted text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login Petugas
                      </a>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits text-center text-muted small">
                Sistem Absensi Terpadu &bull; {{ $school_name ?? 'SMKN 6 Jember' }}
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
@endsection
