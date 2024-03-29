<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $sales = Sales::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->get();
        return view('sales/index', compact('sales', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('sales.create', compact('app'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'komisi'        => 'required',
            'komisi_nominal'=> 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'telephone'     => 'required',
        ]);

        //create
        Sales::create([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'komisi'   => $request->komisi,
            'komisi_nominal'   => $request->komisi_nominal,
            'alamat'   => $request->alamat,
            'kota'   => $request->kota,
            'telephone'   => $request->telephone,
            'id_cabang' => auth()->user()->id_cabang
        ]);

        //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $sales = Sales::find($id);
        return view('sales.edit', compact('sales', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required|string',
            'nama'          => 'required|string',
            'komisi'        => 'required',
            'komisi_nominal'=> 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'telephone'     => 'required',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $sales = Sales::find($id);

        if (!$sales) {
            // Handle kasus jika sales tidak ditemukan
            return redirect()->back()->with('error', 'Sales tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $sales->update([
            'kode'     => $request->kode,
            'nama'   => $request->nama,
            'komisi'   => $request->komisi,
            'komisi_nominal'   => $request->komisi_nominal,
            'alamat'   => $request->alamat,
            'kota'   => $request->kota,
            'telephone'   => $request->telephone,
        ]);

        //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $sales = Sales::find($id);
        if (!$sales) {
            // Handle kasus jika sales tidak ditemukan
            return redirect()->back()->with('error', 'Sales tidak ditemukan');
        }
        //delete sales
        $sales->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
