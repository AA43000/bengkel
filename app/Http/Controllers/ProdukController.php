<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $produks = Produk::latest()->where('is_delete', 0)->paginate(5);
        return view('produk/index', compact('produks'));
    }
    public function create()
    {
        return view('produk.create');
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode_item'          => 'required|string',
            'kode_barcode'          => 'required|string',
            'nama_item'          => 'required|string',
            'jenis'          => 'required|string',
            'kategori'          => 'required|string',
            'stok'          => 'required|integer',
            'satuan'          => 'required|string',
            'rak'          => 'required|string',
            'harga_pokok'          => 'required|integer',
            'harga_jual'          => 'required|integer'
        ]);

        //create
        Produk::create([
            'kode_item'     => $request->kode_item,
            'kode_barcode'     => $request->kode_barcode,
            'nama_item'     => $request->nama_item,
            'jenis'     => $request->jenis,
            'kategori'     => $request->kategori,
            'stok'     => $request->stok,
            'satuan'     => $request->satuan,
            'rak'     => $request->rak,
            'harga_pokok'     => $request->harga_pokok,
            'harga_jual'     => $request->harga_jual
        ]);

        //redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $produk = Produk::find($id);
        return view('produk.edit', compact('produk'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode_item'          => 'required|string',
            'kode_barcode'          => 'required|string',
            'nama_item'          => 'required|string',
            'jenis'          => 'required|string',
            'kategori'          => 'required|string',
            'stok'          => 'required|integer',
            'satuan'          => 'required|string',
            'rak'          => 'required|string',
            'harga_pokok'          => 'required|integer',
            'harga_jual'          => 'required|integer'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $produk = Produk::find($id);

        if (!$produk) {
            // Handle kasus jika produk tidak ditemukan
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $produk->update([
            'kode_item'     => $request->kode_item,
            'kode_barcode'     => $request->kode_barcode,
            'nama_item'     => $request->nama_item,
            'jenis'     => $request->jenis,
            'kategori'     => $request->kategori,
            'stok'     => $request->stok,
            'satuan'     => $request->satuan,
            'rak'     => $request->rak,
            'harga_pokok'     => $request->harga_pokok,
            'harga_jual'     => $request->harga_jual
        ]);

        //redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            // Handle kasus jika produk tidak ditemukan
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        //delete produk
        $produk->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
