@extends('blank')
@section('isi')

<div class="container">
    <h2>Detail Laporan Hasil Pencatatan Presensi Siswa</h2>
    <h4>Hari ini tanggal : <?php echo date('d-m-Y');?></h4>
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
                <td>{{$isi->ket}}</td>
        		<td>{{$isi->opr}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
