<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absen Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <p align="right"> <b> Petugas </b> : <i>{{session()->get('opr')}}</i> | <b> <a href="logout" class="btn btn-danger">Log out</a> </b></p>
        <h2><button class="btn btn-warning" data-bs-target="#absen" data-bs-toggle="modal">Tambah</button> Data Siswa tidak hadir Kelas : <b>{{session()->get('kelas')}}</b></h2>
        <h4>Tanggal : {{date('d/m/Y')}}</h4>
        <table class="table table-striped">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Ket</th>
            </tr>
            <?php $no=1; ?>
            @foreach ($absen as $hasil)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$hasil['nama']}}</td>
                <td>{{$hasil['ket']}}</td>
            </tr>
            @endforeach



        </table>
        <div class="modal fade" role="dialog" id="absen">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Tambah data siswa absen</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="simpanAbsenKelas" method="POST">
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
