<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = Cabang::find(auth()->user()->id_cabang);
        $cabang = Cabang::find(0);
        return view('setting.edit', compact('cabang', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'nama'          => 'required|string',
            'alamat'        => '',
            'telephone'     => '',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $cabang = Cabang::find($id);

        if (!$cabang) {
            // Handle kasus jika cabang tidak ditemukan
            return redirect()->back()->with('error', 'Cabang tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $cabang->update([
            'nama'   => $request->nama,
            'alamat'   => $request->alamat ? $request->alamat : '',
            'telephone'   => $request->telephone ? $request->telephone : '',
        ]);

        //redirect to index
        return redirect()->route('setting.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
