<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
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
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $cabangs = Cabang::latest()
        ->where('is_delete', 0)
        ->get();
        return view('cabang/index', compact('cabangs', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('cabang.create', compact('app'));
    }
    public function do_upload($file) {
        if ($file) { // Periksa apakah file ada
            if ($file->isValid()) {
                $file = $file;
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads'), $fileName);

                return ['status' => true, 'filename' => $fileName];
            } else {
                return ['status' => false];
            }
        } else {
            return ['status' => true, 'filename' => ''];
        }
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'nama'          => 'required|string',
            'alamat'        => '',
            'telephone'     => '',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $this->do_upload($request->file('logo'));

        //create
        Cabang::create([
            'nama'   => $request->nama,
            'alamat'   => $request->alamat ? $request->alamat : '',
            'telephone'   => $request->telephone ? $request->telephone : '',
            'logo' => ($file['status'] == true ? $file['filename'] : '')
        ]);

        //redirect to index
        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $cabang = Cabang::find($id);
        return view('cabang.edit', compact('cabang', 'app'));
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
        $file = $this->do_upload($request->file('logo'));
        // Lakukan pembaruan berdasarkan data dari $request
        $cabang->update([
            'nama'   => $request->nama,
            'alamat'   => $request->alamat ? $request->alamat : '',
            'telephone'   => $request->telephone ? $request->telephone : '',
            'logo' => ($file['status'] == true ? ($file['filename'] != '' ? $file['filename'] : $cabang->logo) : '')
        ]);

        //redirect to index
        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $cabang = Cabang::find($id);
        if (!$cabang) {
            // Handle kasus jika cabang tidak ditemukan
            return redirect()->back()->with('error', 'Cabang tidak ditemukan');
        }
        //delete cabang
        $cabang->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
