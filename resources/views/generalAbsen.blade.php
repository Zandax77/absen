@extends('blank')
@section('isi')

<div class="container py-4">
    <h2 class="fs-4 fw-bold mb-1">Detail Laporan Hasil Pencatatan Presensi Siswa</h2>
    <h4 class="fs-6 text-muted mb-3">Hari ini tanggal : {{ date('d-m-Y') }}</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Keterangan</th>
    				<th>Pencatat</th>
                </tr>
            </thead>
            <tbody><?php $no=1; ?>
                @foreach ($data as $isi)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$isi->nama}}</td>
                    <td>{{$isi->kelas}}</td>
                    <td class="text-center">{{$isi->ket}}</td>
        			<td>{{$isi->opr}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection