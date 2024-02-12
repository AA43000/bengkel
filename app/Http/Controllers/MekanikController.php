<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $mekaniks = Mekanik::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->get();
        return view('mekanik/index', compact('mekaniks', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('mekanik.create', compact('app'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'keahlian'        => 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'provinsi'          => 'required',
            'telephone'     => 'required',
            'note'     => 'required',
        ]);

        //create
        Mekanik::create([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'keahlian'   => $request->keahlian,
            'alamat'   => $request->alamat,
            'kota'   => $request->kota,
            'provinsi'   => $request->provinsi,
            'telephone'   => $request->telephone,
            'note'   => $request->note,
            'id_cabang' => auth()->user()->id_cabang
        ]);

        //redirect to index
        return redirect()->route('mekanik.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $mekanik = Mekanik::find($id);
        return view('mekanik.edit', compact('mekanik', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'keahlian'        => 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'provinsi'          => 'required',
            'telephone'     => 'required',
            'note'     => 'required',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $mekanik = Mekanik::find($id);

        if (!$mekanik) {
            // Handle kasus jika mekanik tidak ditemukan
            return redirect()->back()->with('error', 'Mekanik tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $mekanik->update([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'keahlian'   => $request->keahlian,
            'alamat'   => $request->alamat,
            'kota'   => $request->kota,
            'provinsi'   => $request->provinsi,
            'telephone'   => $request->telephone,
            'note'   => $request->note
        ]);

        //redirect to index
        return redirect()->route('mekanik.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $mekanik = Mekanik::find($id);
        if (!$mekanik) {
            // Handle kasus jika mekanik tidak ditemukan
            return redirect()->back()->with('error', 'Mekanik tidak ditemukan');
        }
        //delete mekanik
        $mekanik->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('mekanik.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
