@extends('blank')
@section('isi')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0 fw-bold">Data Operator</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Dashboard Admin
        </a>
    </div>
    <table class="table table-hovered datatable">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Operator</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $isi)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$isi->nama}}</td>
            <td>{{$isi->kelas}}</td>
            <td>{{$isi->status}}</td>
            <td>

                @if($isi->status=="menunggu")
                    <a href="setujui/{{$isi->kode}}" class="btn btn-success">Setujui</a>
                @else
                    <a href="blokir/{{$isi->kode}}" class="btn btn-warning">Blokir</a>
                @endif

                <a href="hapus/{{$isi->kode}}" class="btn btn-danger">Hapus</a>

            </td>
        </tr>
        @endforeach
    </table>
</div>
