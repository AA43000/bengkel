<?php

namespace App\Http\Controllers;

use App\Models\Thitemkeluar;
use App\Models\Tditemkeluar;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemkeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Mendapatkan ID pengguna dari Auth::id()
        $this->userId = Auth::id();
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query header itemkeluar
        $thitemkeluars = Thitemkeluar::latest()
        ->where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->paginate(5);
        return view('item_keluar/index', compact('thitemkeluars', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        return view('item_keluar.create', compact('produks', 'app'));
    }
    function generatePurchaseCode() {
        // mengambil data kode terakhir yang ada
        $lastPurchase = DB::table('thitemkeluars')->where('id_cabang', auth()->user()->id_cabang)->latest()->first();

        if (!$lastPurchase) {
            // jika belum ada kode yang dibuat
            $code = 'IK/' . now()->format('my') . '/001';
        } else {
            // jika sudah ada kode yang dibuat
            $lastCode = $lastPurchase->kode;
            $lastNumber = intval(substr($lastCode, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $code = 'IK/' . now()->format('my') . '/' . $newNumber;
        }

        return $code;
    }
    public function load_detail($idthitemkeluar) {
        // query detail itemkeluar di form itemkeluar
        $query = DB::table('tditemkeluars as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->where('a.idthitemkeluar', $idthitemkeluar)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function edit_detail($idtditemkeluar) {
        // mengambil data detail itemkeluar tertentu
        $query = Tditemkeluar::find($idtditemkeluar);

        if ($query) {
            // jika data ditemukan
            $response["id"] = $query->id;
            $response["id_produk"] = $query->id_produk;
            $response["qty"] = $query->qty;
            $response["harga"] = $query->harga;
            $response["subtotal"] = $query->subtotal;
        } else {
            // jika data tidak ditemukan
            $response["id"] = '';
            $response["id_produk"] = '';
            $response["qty"] = '';
            $response["harga"] = '';
            $response["subtotal"] = '';
        }
        return response()->json($response);
    }

    public function get_detail($idthitemkeluar) {
        // fungsi get detail di popup list itemkeluar
        $response['thitemkeluar'] = Thitemkeluar::find($idthitemkeluar);

        $response['tditemkeluar'] = DB::table('tditemkeluars as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthitemkeluar', $idthitemkeluar)
            ->get();

        return response()->json($response);
    }
    public function delete_detail($idtditemkeluar) {

        $tditemkeluar = Tditemkeluar::find($idtditemkeluar);

        if ($tditemkeluar) {
            // jika detail ditemukan
            // update field untuk delete data
            $tditemkeluar->update([
                'is_delete' => 1
            ]);
            
            // update stok produk
            // if($tditemkeluar->idthitemkeluar != 0) {
            //     $produk = Produk::find($tditemkeluar->id_produk);
            //     $produk->update([
            //         "stok" => $produk->stok + $tditemkeluar->qty
            //     ]);
            // }
        }
        return response()->json(["status" => 200]);
    }
    public function load_produk($id_produk) {
        // query produk
        $produk = Produk::find($id_produk);

        if ($produk) {
            // produk ditemukan
            $response["harga"] = $produk->harga_jual;
        } else {
            // Produk tidak ditemukan
            $response["harga"] = 0;
        }
        return response()->json($response);
    }
    public function post_detail(Request $request)
    {
        // cek detail untuk menentukan update atau insert
        $tditemkeluar = Tditemkeluar::find($request->id_detail);

        if (!$tditemkeluar) {
            // detail insert
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tditemkeluar::where('is_delete', 0)->where('idthitemkeluar', $request->idthitemkeluar)->where('id_produk', $request->id_produk)->first();
            if($cek == false) {
                // belum ditambahkan
                Tditemkeluar::create([
                    'idthitemkeluar' => $request->idthitemkeluar,
                    'id_produk'     => $request->id_produk,
                    'qty'     => $request->qty,
                    'harga'     => $request->harga,
                    'subtotal'     => $request->subtotal,
                    'id_cabang' => auth()->user()->id_cabang
                ]);
                    
                // if($request->idthitemkeluar != 0) {
                //     // jika id header itemkeluar bukan 0, maka langsung update stok produk
                //     $produk = Produk::find($request->id_produk);
                //     $produk->update([
                //         "stok" => $produk->stok + $request->qty
                //     ]);
                // }
                $response["status"] = 200;
            } else {
                // sudah ditambahkan
                $response["status"] = 201;
                $response["message"] = "Produk telah ditambahkan";
            }
        } else {
            // detail update
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tditemkeluar::where('is_delete', 0)->where('idthitemkeluar', $request->idthitemkeluar)->where('id_produk', $request->id_produk)->where('id', '!=', $request->id_detail)->first();
            if($cek == false) {
                // belum ditambahkan
                // if($request->idthitemkeluar != 0) {
                //     // jika id header itemkeluar bukan 0, maka langsung update stok produk
                //     $produk = Produk::find($request->id_produk);
                //     $produk->update([
                //         "stok" => $produk->stok - $tditemkeluar->qty + $request->qty
                //     ]);
                // }

                $tditemkeluar->update([
                    'idthitemkeluar' => $request->idthitemkeluar,
                    'id_produk'     => $request->id_produk,
                    'qty'     => $request->qty,
                    'harga'     => $request->harga,
                    'subtotal'     => $request->subtotal,
                ]);
                $response["status"] = 200;
            } else {
                // produk sudah ditambahkan
                $response["status"] = 201;
                $response["message"] = "Produk telah ditambahkan";
            }
        }

        return response()->json($response);
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'total'          => 'numeric|not_in:0',
            'keterangan'          => 'string',
            'tanggal'          => 'date'
        ]);

        //create
        $thitemkeluar = Thitemkeluar::create([
            'kode'     => $this->generatePurchaseCode(),
            'keterangan'     => $request->keterangan,
            'total'     => $request->total,
            'tanggal'     => $request->tanggal,
            'id_cabang' => auth()->user()->id_cabang,
            'created_by'     => $this->userId
        ]);

        // update id header di detail itemkeluar
        Tditemkeluar::where('idthitemkeluar', 0)
            ->where('is_delete', 0)
            ->update(['idthitemkeluar' => $thitemkeluar->id]);

        // mengarah ke fungsi update stok produk
        // $this->update_stok($thitemkeluar->id);
        //redirect to index
        return redirect()->route('item_keluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update_stok($idthitemkeluar) {
        // update stok produk yang ditambahkan ke itemkeluar
        $query = DB::table('tditemkeluars')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthitemkeluar', $idthitemkeluar)
            ->get();

        foreach($query as $row) {
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok + $row->qty
            ]);
        }
    }

    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        // query header itemkeluar
        $thitemkeluar = Thitemkeluar::find($id);
        return view('item_keluar.edit', compact('thitemkeluar', 'produks', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'total'          => 'numeric|not_in:0',
            'keterangan'          => 'string',
            'tanggal'          => 'date'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $thitemkeluar = Thitemkeluar::find($id);

        if (!$thitemkeluar) {
            // Handle kasus jika thitemkeluar tidak ditemukan
            return redirect()->back()->with('error', 'itemkeluar tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $thitemkeluar->update([
            'kode'     => $request->kode,
            'keterangan'     => $request->keterangan,
            'total'     => $request->total,
            'tanggal'     => $request->tanggal
        ]);

        //redirect to index
        return redirect()->route('item_keluar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $thitemkeluar = Thitemkeluar::find($id);
        if (!$thitemkeluar) {
            // Handle kasus jika itemkeluar tidak ditemukan
            return redirect()->back()->with('error', 'itemkeluar tidak ditemukan');
        }
        //delete header itemkeluar
        $thitemkeluar->update([
            'is_delete' => 1
        ]);

        // $query = DB::table('tditemkeluars')
        //     ->select('qty', 'id_produk')
        //     ->where('is_delete', 0)
        //     ->where('idthitemkeluar', $id)
        //     ->get();

        // foreach($query as $row) {
        //     // update stok produk dari detail itemkeluar
        //     $produk = Produk::find($row->id_produk);
        //     $produk->update([
        //         "stok" => $produk->stok - $row->qty
        //     ]);
        // }

        // delete detail itemkeluar
        Tditemkeluar::where('idthitemkeluar', $id)
            ->update(['is_delete' => 1]);

        //redirect to index
        return redirect()->route('item_keluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
