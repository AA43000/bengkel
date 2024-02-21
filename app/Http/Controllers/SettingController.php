<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role != 'admin') {
                abort(403, 'Unauthorized action.');
            }
            
            return $next($request);
        });
    }
    public function index()
    {
        $app = Cabang::find(auth()->user()->id_cabang);
        $cabang = Cabang::find(auth()->user()->id_cabang);
        return view('setting.edit', compact('cabang', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'nama'          => 'required|string',
            'alamat'        => '',
            'telephone'     => '',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->file('logo')) { // Periksa apakah file ada
            if ($request->file('logo')->isValid()) {
                $file = $request->file('logo');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads'), $fileName);

                $cabang->update([
                    'logo'   => $fileName,
                ]);

                return redirect()->back()->with('success', 'File berhasil diunggah.');
            } else {
                return redirect()->back()->with('error', 'File tidak valid.');
            }
        } else {
            return redirect()->back()->with('error', 'Tidak ada file yang diunggah.');
        }

        //redirect to index
        return redirect()->route('setting.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
