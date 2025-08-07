@extends('blank');
@section('isi')

<div class="container">
    <h2>Data Wali Kelas</h2>
    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Wali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $isi)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$isi->kelas}}</td>
                <td>{{$isi->nama}}</td>
                <td></td>
                <td>

                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection
