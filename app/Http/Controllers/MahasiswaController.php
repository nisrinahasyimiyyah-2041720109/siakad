<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate  = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
        
        /*
        $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $posts])
            ->with('i', (request()->input('page', 1) - 1) * 5);
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', compact('kelas'));
        
        //return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        //melakukan validasi data
        $request->validate([
            'Nim'=>'required',
            'Nama'=>'required',           
            'Jurusan'=>'required',
            'Email'=>'required',
            'Alamat'=>'required',
            'tanggal_lahir'=>'required',
            'kelas_id'=>'required',
            'foto'=>'required',
        ]);

        if ($request->file('foto')) {
            $nama_foto = $request->file('foto')->store('foto', 'public');
        }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
        $mahasiswa->kelas_id = $request->get('kelas_id');
        $mahasiswa->foto = $nama_foto;

        Mahasiswa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        // code sebelum dibuat relasi --> $Mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        //$Mahasiswa = DB::table('mahasiswa')->where('nim',$Nim)->first();;
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit',compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim'=>'required',
            'Nama'=>'required',           
            'Jurusan'=>'required',
            'Email'=>'required',
            'Alamat'=>'required',
            'tanggal_lahir'=>'required',
            'kelas_id'=>'required',
            'foto'=>'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
        $mahasiswa->kelas_id = $request->get('kelas_id');

        if ($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))) {
            \Storage::delete('public/' . $mahasiswa->foto);
        }

        $nama_foto = $request->file('foto')->store('foto', 'public');
        $mahasiswa->foto = $nama_foto;

        $mahasiswa->save();
        
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    //fungsi untuk melakukan pencarian data mahasiswa berdasarkan nama
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswa = Mahasiswa::where('nama', 'like', "%" . $keyword . "%")->paginate(3);
        return view('mahasiswa.index', [
            'paginate' => $mahasiswa
        ]);
    }
    
    public function nilai($Id)
    {
        $matkulmhs = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $Id)->get();
        $matkulmhs->mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $Id)->first();
        return view('mahasiswa.khs', compact('matkulmhs'));  
    }

    public function cetak_pdf($Id) 
    {
        $matkulmhs = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $Id)->get();
        $matkulmhs->mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $Id)->first();
        $pdf = PDF::loadview('mahasiswa.khs_pdf', compact('matkulmhs'));
        return $pdf->stream();
    }
}
