@extends('blank')
@section('isi')
<div class="container py-4 min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5">
            @foreach ($data as $isi)
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 text-center">
                    <h5 class="fw-bold mb-1">Ubah Keterangan Absensi</h5>
                    <p class="text-muted small mb-0">Perbarui status ketidakhadiran siswa</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('updateAbsen/' . $isi->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$isi->id}}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase">Pilih Status Baru</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="ket" id="ket_a" value="A" {{ $isi->ket == 'A' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger flex-fill py-2" for="ket_a">Alpha</label>

                                <input type="radio" class="btn-check" name="ket" id="ket_i" value="I" {{ $isi->ket == 'I' ? 'checked' : '' }}>
                                <label class="btn btn-outline-info flex-fill py-2" for="ket_i">Izin</label>

                                <input type="radio" class="btn-check" name="ket" id="ket_s" value="S" {{ $isi->ket == 'S' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning flex-fill py-2" for="ket_s">Sakit</label>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('infoWali') }}" class="btn btn-light w-100 py-2 text-muted">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
