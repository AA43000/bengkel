<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $pelanggans = Pelanggan::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->get();
        return view('pelanggan/index', compact('pelanggans', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('pelanggan.create', compact('app'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'alamat'        => '',
            'kota'          => '',
            'provinsi'          => '',
            'kode_pos'          => '',
            'negara'          => '',
            'telephone'     => '',
            'fax'     => '',
            'kontak_person'     => '',
            'note'     => '',
        ]);

        //create
        Pelanggan::create([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'alamat'   => ($request->alamat ? $request->alamat : ''),
            'kota'   => ($request->kota ? $request->kota : ''),
            'provinsi'   => ($request->provinsi ? $request->provinsi : ''),
            'kode_pos'   => ($request->kode_pos ? $request->kode_pos : ''),
            'negara'   => ($request->negara ? $request->negara : ''),
            'telephone'   => ($request->telephone ? $request->telephone : ''),
            'fax'   => ($request->fax ? $request->fax : ''),
            'kontak_person'   => ($request->kontak_person ? $request->kontak_person : ''),
            'note'   => ($request->note ? $request->note : ''),
            'id_cabang' => auth()->user()->id_cabang
        ]);

        //redirect to index
        return redirect()->route('pelanggan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $pelanggan = Pelanggan::find($id);
        return view('pelanggan.edit', compact('pelanggan', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'alamat'        => 'required',
            'kota'          => 'required',
            'provinsi'          => 'required',
            'kode_pos'          => 'required|integer',
            'negara'          => 'required',
            'telephone'     => 'required',
            'fax'     => 'required',
            'kontak_person'     => 'required',
            'note'     => 'required',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            // Handle kasus jika pelanggan tidak ditemukan
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $pelanggan->update([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'alamat'   => $request->alamat,
            'kota'   => $request->kota,
            'provinsi'   => $request->provinsi,
            'kode_pos'   => $request->kode_pos,
            'negara'   => $request->negara,
            'telephone'   => $request->telephone,
            'fax'   => $request->fax,
            'kontak_person'   => $request->kontak_person,
            'note'   => $request->note
        ]);

        //redirect to index
        return redirect()->route('pelanggan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            // Handle kasus jika pelanggan tidak ditemukan
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
        }
        //delete pelanggan
        $pelanggan->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('pelanggan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
