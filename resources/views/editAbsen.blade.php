@extends('blank')
@section('isi')
<div class="container">
    @foreach ($data as $isi)
    <form action="updateAbsen/{{$isi->id}}" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Ubah Absensi Siswa</h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$isi->id}}">
                        Keterangan :
                        <input type="text" name="ket" value="{{$isi->ket}}" class="form-control">
                    </div>
                </div>
                @endforeach
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
