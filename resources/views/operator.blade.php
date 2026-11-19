@extends('blank')
@section('isi')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h2 class="mb-0 fw-bold">Data Operator</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Dashboard Admin
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Operator</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                @foreach ($data as $isi)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$isi->nama}}</td>
                    <td>{{$isi->kelas}}</td>
                    <td>{{$isi->status}}</td>
                    <td>
                        <div class="d-flex flex-column flex-sm-row gap-1 justify-content-center">
                            @if($isi->status=="menunggu")
                                <a href="setujui/{{$isi->kode}}" class="btn btn-success btn-sm">Setujui</a>
                            @else
                                <a href="blokir/{{$isi->kode}}" class="btn btn-warning btn-sm">Blokir</a>
                            @endif
                            <a href="hapus/{{$isi->kode}}" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
