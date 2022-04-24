<!DOCTYPE html> 
<html> 
    <head> 
        <title>Kartu Hasil Studi (KHS) - {{$matkulmhs->mahasiswa->nama}}</title> 
    </head> 
    <body> 
        <style type="text/css"> 
            table tr td, 
            table tr th{ 
            font-size: 9pt; 
            } 
            .teks {
                font-size: 14px;
            }
        </style> 

        <center>
            <h5>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h5>

            <h4 class="text-center">KARTU HASIL STUDI (KHS)</h4>
        </center><br><br>

        <ul class="teks" style="list-style-type: none;">
            <li><b>Nama: </b>{{$matkulmhs->mahasiswa->nama}}</li>
            <li><b>Nim: </b>{{$matkulmhs->mahasiswa->nim}}</li>             
            <li><b>Kelas: </b>{{$matkulmhs->mahasiswa->kelas->nama_kelas}}</li>
        </ul>

        <table class='table table-bordered' style="width:90%;margin: 0 auto;"> 
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
    </body> 
</html> 