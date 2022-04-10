@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-center mt-1">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="d-flex justify-content-center my-5">
            <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
        </div>
        <div class="row mb-2">
            <ul class="" style="list-style-type: none;">
                <li><b>Nama: </b>{{$matkulmhs->mahasiswa->nama}}</li>
                <li><b>Nim: </b>{{$matkulmhs->mahasiswa->nim}}</li>             
                <li><b>Kelas: </b>{{$matkulmhs->mahasiswa->kelas->nama_kelas}}</li>
            </ul>
        </div>
    </div>
    
    <table class="table table-bordered">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @foreach ($matkulmhs as $khs)
        <tr>
            <td>{{ $khs->matakuliah->nama_matkul }}</td>
            <td>{{ $khs->matakuliah->sks }}</td> 
            <td>{{ $khs->matakuliah->semester }}</td>
            <td>{{ $khs->nilai }}</td>   
        </tr>
        @endforeach
    </table>
@endsection