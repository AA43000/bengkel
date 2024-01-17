<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $kendaraans = Kendaraan::latest()->where('is_delete', 0)->paginate(5);
        return view('kendaraan/index', compact('kendaraans'));
    }
    public function create()
    {
        return view('kendaraan.create');
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
            'no_mesin'     => $request->no_mesin
        ]);

        //redirect to index
        return redirect()->route('kendaraan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::find($id);
        return view('kendaraan.edit', compact('kendaraan'));
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
