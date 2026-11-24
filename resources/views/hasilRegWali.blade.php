@extends('blank')
@section('isi')
<div class="container py-4 min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 text-center p-4 rounded-4">
                <div class="card-body p-0">
                    <div class="mb-3">
                        <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-check-circle-fill fs-1"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-2">Pendaftaran Wali Berhasil!</h4>
                    <p class="text-muted small mb-4">
                        Akun wali kelas telah berhasil didaftarkan.<br>
                        Silakan login untuk memantau presensi kelas bimbingan Anda.
                    </p>
                    <a href="{{ url('wali') }}" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Ke Halaman Login Wali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
