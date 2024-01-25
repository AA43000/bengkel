<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $kendaraans = Kendaraan::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->paginate(5);
        return view('kendaraan/index', compact('kendaraans', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('kendaraan.create', compact('app'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'no_polisi'          => 'required',
            'pemilik'          => 'required',
            'alamat'          => 'required',
            'merk'          => 'required',
            'tipe'          => 'required',
            'jenis'          => 'required',
            'tahun_buat'          => 'required|integer',
            'tahun_rakit'          => 'required|integer',
            'silinder'          => 'required',
            'warna'          => 'required',
            'no_rangka'          => 'required',
            'no_mesin'          => 'required'
        ]);

        //create
        Kendaraan::create([
            'no_polisi'     => $request->no_polisi,
            'pemilik'     => $request->pemilik,
            'alamat'     => $request->alamat,
            'merk'     => $request->merk,
            'tipe'     => $request->tipe,
            'jenis'     => $request->jenis,
            'tahun_buat'     => $request->tahun_buat,
            'tahun_rakit'     => $request->tahun_rakit,
            'silinder'     => $request->silinder,
            'warna'     => $request->warna,
            'no_rangka'     => $request->no_rangka,
            'no_mesin'     => $request->no_mesin,
            'id_cabang' => auth()->user()->id_cabang
        ]);

        //redirect to index
        return redirect()->route('kendaraan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $kendaraan = Kendaraan::find($id);
        return view('kendaraan.edit', compact('kendaraan', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'no_polisi'          => 'required',
            'pemilik'          => 'required',
            'alamat'          => 'required',
            'merk'          => 'required',
            'tipe'          => 'required',
            'jenis'          => 'required',
            'tahun_buat'          => 'required|integer',
            'tahun_rakit'          => 'required|integer',
            'silinder'          => 'required',
            'warna'          => 'required',
            'no_rangka'          => 'required',
            'no_mesin'          => 'required'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            // Handle kasus jika kendaraan tidak ditemukan
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $kendaraan->update([
            'no_polisi'     => $request->no_polisi,
            'pemilik'     => $request->pemilik,
            'alamat'     => $request->alamat,
            'merk'     => $request->merk,
            'tipe'     => $request->tipe,
            'jenis'     => $request->jenis,
            'tahun_buat'     => $request->tahun_buat,
            'tahun_rakit'     => $request->tahun_rakit,
            'silinder'     => $request->silinder,
            'warna'     => $request->warna,
            'no_rangka'     => $request->no_rangka,
            'no_mesin'     => $request->no_mesin
        ]);

        //redirect to index
        return redirect()->route('kendaraan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            // Handle kasus jika kendaraan tidak ditemukan
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan');
        }
        //delete kendaraan
        $kendaraan->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('kendaraan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
