<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $suppliers = Supplier::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->get();
        return view('supplier/index', compact('suppliers', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('supplier.create', compact('app'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required',
            'nama'          => 'required',
            'alamat'          => 'required',
            'kota'          => 'required',
            'provinsi'          => 'required',
            'kode_pos'          => 'required|integer',
            'negara'          => 'required',
            'telephone'          => 'required',
            'fax'          => 'required',
            'bank'          => 'required',
            'no_account'          => 'required',
            'atas_nama'          => 'required',
            'kontak_person'          => 'required',
            'email'          => 'required|email'
        ]);

        //create
        Supplier::create([
            'kode'     => $request->kode,
            'nama'     => $request->nama,
            'alamat'     => $request->alamat,
            'kota'     => $request->kota,
            'provinsi'     => $request->provinsi,
            'kode_pos'     => $request->kode_pos,
            'negara'     => $request->negara,
            'telephone'     => $request->telephone,
            'fax'     => $request->fax,
            'bank'     => $request->bank,
            'no_account'     => $request->no_account,
            'atas_nama'     => $request->atas_nama,
            'kontak_person'     => $request->kontak_person,
            'email'     => $request->email,
            'id_cabang' => auth()->user()->id_cabang
        ]);

        //redirect to index
        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $supplier = Supplier::find($id);
        return view('supplier.edit', compact('supplier', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => 'required',
            'nama'          => 'required',
            'alamat'          => 'required',
            'kota'          => 'required',
            'provinsi'          => 'required',
            'kode_pos'          => 'required',
            'negara'          => 'required',
            'telephone'          => 'required',
            'fax'          => 'required',
            'bank'          => 'required',
            'no_account'          => 'required',
            'atas_nama'          => 'required',
            'kontak_person'          => 'required',
            'email'          => 'required',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $supplier = Supplier::find($id);

        if (!$supplier) {
            // Handle kasus jika supplier tidak ditemukan
            return redirect()->back()->with('error', 'Supplier tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $supplier->update([
            'kode'     => $request->kode,
            'nama'     => $request->nama,
            'alamat'     => $request->alamat,
            'kota'     => $request->kota,
            'provinsi'     => $request->provinsi,
            'kode_pos'     => $request->kode_pos,
            'negara'     => $request->negara,
            'telephone'     => $request->telephone,
            'fax'     => $request->fax,
            'bank'     => $request->bank,
            'no_account'     => $request->no_account,
            'atas_nama'     => $request->atas_nama,
            'kontak_person'     => $request->kontak_person,
            'email'     => $request->email,
        ]);

        //redirect to index
        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            // Handle kasus jika supplier tidak ditemukan
            return redirect()->back()->with('error', 'Supplier tidak ditemukan');
        }
        //delete supplier
        $supplier->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
