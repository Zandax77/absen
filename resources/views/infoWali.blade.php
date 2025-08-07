@extends('blank')
@section('isi')

<div class="container">
    <p align="right"> <b> Wali kelas {{session()->get('kelas')}} </b> : <i>{{session()->get('opr')}}</i> | <b> <a href="logoutWali" class="btn btn-danger">Log out</a> </b></p>
    <h2><button class="btn btn-warning" data-bs-target="#absen" data-bs-toggle="modal">Tambah</button> Data Siswa tidak hadir Kelas : <b>{{session()->get('kelas')}}</b></h2>
    <h4>Tanggal : {{date('d/m/Y')}}</h4>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Ket</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($absen as $hasil)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$hasil['nama']}}</td>
            <td>{{$hasil['ket']}}</td>
            <td>
                <a href="hapusAbsen/{{$hasil['id']}}" class="btn btn-danger" title="gunakan tombol ini untuk membatalkan data">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<div class="modal fade" id="absen" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambahkan catatan Siswa tidak hadir</h3>
            </div>
            <form action="simpanAbsenKelasWali" method="POST">
                @csrf
                    <div class="modal-body">
                         <div class="form-group">
                                Nama :
                                <select name="nis" id="" class="form-control">
                                        <option value=""></option>
                                    @foreach ($data as $isi)
                                        <option value="{{$isi['nisn']}}">{{$isi['nama']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="tgl" value="{{date('d/m/Y')}}">
                            <input type="hidden" name="kelas" value="{{session()->get('kelas')}}">
                            <div class="form-group">
                                Keterangan :
                                <select name="ket" id="" class="form-control">
                                    <option value="A">Alpha</option>
                                    <option value="I">Izin</option>
                                    <option value="S">Sakit</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info" type="submit">Tambahkan</button>
                        </div>
                    </form>
            </form>
        </div>
    </div>
</div>

@endsection
