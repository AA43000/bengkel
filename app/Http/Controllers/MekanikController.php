<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $mekaniks = Mekanik::latest()->where('is_delete', 0)->paginate(5);
        return view('mekanik/index', compact('mekaniks'));
    }
    public function create()
    {
        return view('mekanik.create');
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
            'note'   => $request->note
        ]);

        //redirect to index
        return redirect()->route('mekanik.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $mekanik = Mekanik::find($id);
        return view('mekanik.edit', compact('mekanik'));
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
