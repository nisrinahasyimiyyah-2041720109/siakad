@extends('mahasiswa.layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="card" style="width: 24rem;">
                <div class="card-header">
                    Tambah Mahasiswa
                </div>
                <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="post" action="{{ route('mahasiswa.store') }}" enctype="multipart/form-data" id="myForm">
                        @csrf
                            <div class="form-group">
                                <label for="Nim">Nim</label>
                                <input type="text" name="Nim" class="form-control" id="Nim" aria-describedby="Nim">
                            </div>
                            <div class="form-group">
                                <label for="Nama">Nama</label>
                                <input type="Nama" name="Nama" class="form-control" id="Nama" aria-describedby="Nama">
                            </div>
                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>
                                <select class="form-control" name="kelas_id" id="kelas_id" aria-describedby="kelas_id">
                                @foreach($kelas as $kls)
                                    <option value="{{$kls->id}}">{{$kls->nama_kelas}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Jurusan">Jurusan</label>
                                <input type="Jurusan" name="Jurusan" class="form-control" id="Jurusan" aria-describedby="Jurusan">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="Email" name="Email" class="form-control" id="Email" aria-describedby="Email">
                            </div>
                            <div class="form-group">
                                <label for="Alamat">Alamat</label>
                                <input type="Alamat" name="Alamat" class="form-control" id="Alamat" aria-describedby="Alamat">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" aria-describedby="tanggal_lahir">
                            </div>
                            <div class="form_group">
                                <label for="foto">Foto</label> 
                                <input type="file" class="form-control" name="foto" id="foto"></br>
                            </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection