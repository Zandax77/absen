@extends('blank')
@section('isi')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h2 class="fs-4 fw-bold mb-0">Data Wali Kelas</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Dashboard Admin
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" width="60">No</th>
                            <th>Kelas</th>
                            <th>Nama Wali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @forelse ($data as $isi)
                            <tr>
                                <td class="ps-3 text-muted">{{$no++}}</td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{$isi->kelas}}</span></td>
                                <td class="fw-semibold text-dark">{{$isi->nama}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
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

@endsection
