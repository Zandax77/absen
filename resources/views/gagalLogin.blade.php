@extends('blank')
@section('isi')
<div class="container py-4 min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 text-center p-4 rounded-4">
                <div class="card-body p-0">
                    <div class="mb-3">
                        <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-x-circle-fill fs-1"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-2 text-danger">Login Gagal!</h4>
                    <p class="text-muted small mb-4">
                        Kode pengguna atau kata sandi tidak cocok, atau akun Anda masih menunggu persetujuan administrator.
                    </p>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ url('loginKelas') }}" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-arrow-repeat me-1"></i> Coba Login Lagi
                        </a>
                        <a href="{{ url('regPetugasKelas') }}" class="btn btn-outline-secondary w-100 py-2 small">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
