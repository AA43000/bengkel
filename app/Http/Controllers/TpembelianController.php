<?php

namespace App\Http\Controllers;

use App\Models\Thpembelian;
use App\Models\Tdpembelian;
use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TpembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // query header pembelian
        $thpembelians = Thpembelian::leftJoin('suppliers', 'suppliers.id', '=', 'thpembelians.id_supplier')
        ->select('thpembelians.*', 'suppliers.kode as kode_supplier', 'suppliers.nama as nama_supplier')
        ->latest()->where('thpembelians.is_delete', 0)->paginate(5);
        return view('tpembelian/index', compact('thpembelians'));
    }
    public function create()
    {
        // query supplier
        $suppliers = DB::table('suppliers')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        // query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        return view('tpembelian.create', compact('suppliers', 'produks'));
    }
    function generatePurchaseCode() {
        // mengambil data kode terakhir yang ada
        $lastPurchase = DB::table('thpembelians')->latest()->first();

        if (!$lastPurchase) {
            // jika belum ada kode yang dibuat
            $code = 'INV-BL/' . now()->format('my') . '/001';
        } else {
            // jika sudah ada kode yang dibuat
            $lastCode = $lastPurchase->kode;
            $lastNumber = intval(substr($lastCode, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $code = 'INV-BL/' . now()->format('my') . '/' . $newNumber;
        }

        return $code;
    }
    public function load_detail($idthpembelian) {
        // query detail pembelian di form pembelian
        $query = DB::table('tdpembelians as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthpembelian', $idthpembelian)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function edit_detail($idtdpembelian) {
        // mengambil data detail pembelian tertentu
        $query = Tdpembelian::find($idtdpembelian);

        if ($query) {
            // jika data ditemukan
            $response["id"] = $query->id;
            $response["id_produk"] = $query->id_produk;
            $response["pesan"] = ($query->pesan != null ? $query->pesan : '');
            $response["qty"] = $query->qty;
            $response["harga"] = $query->harga;
            $response["subtotal"] = $query->subtotal;
        } else {
            // jika data tidak ditemukan
            $response["id"] = '';
            $response["id_produk"] = '';
            $response["pesan"] = '';
            $response["qty"] = '';
            $response["harga"] = '';
            $response["subtotal"] = '';
        }
        return response()->json($response);
    }

    public function get_detail($idthpembelian) {
        // fungsi get detail di popup list pembelian
        $response['thpembelian'] = Thpembelian::find($idthpembelian);

        $response['tdpembelian'] = DB::table('tdpembelians as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthpembelian', $idthpembelian)
            ->get();

        return response()->json($response);
    }
    public function delete_detail($idtdpembelian) {

        $tdpembelian = Tdpembelian::find($idtdpembelian);

        if ($tdpembelian) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdpembelian->update([
                'is_delete' => 1
            ]);
            
            // update stok produk
            if($tdpembelian->idthpembelian != 0) {
                $produk = Produk::find($tdpembelian->id_produk);
                $produk->update([
                    "stok" => $produk->stok - $tdpembelian->qty
                ]);
            }
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
        $tdpembelian = Tdpembelian::find($request->id_detail);

        if (!$tdpembelian) {
            // detail insert
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdpembelian::where('is_delete', 0)->where('idthpembelian', $request->idthpembelian)->where('id_produk', $request->id_produk)->first();
            if($cek == false) {
                // belum ditambahkan
                Tdpembelian::create([
                    'idthpembelian' => $request->idthpembelian,
                    'id_produk'     => $request->id_produk,
                    'pesan'     => $request->pesan,
                    'qty'     => $request->qty,
                    'harga'     => $request->harga,
                    'subtotal'     => $request->subtotal,
                ]);
                    
                if($request->idthpembelian != 0) {
                    // jika id header pembelian bukan 0, maka langsung update stok produk
                    $produk = Produk::find($request->id_produk);
                    $produk->update([
                        "stok" => $produk->stok + $request->qty
                    ]);
                }
                $response["status"] = 200;
            } else {
                // sudah ditambahkan
                $response["status"] = 201;
                $response["message"] = "Produk telah ditambahkan";
            }
        } else {
            // detail update
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdpembelian::where('is_delete', 0)->where('idthpembelian', $request->idthpembelian)->where('id_produk', $request->id_produk)->where('id', '!=', $request->id_detail)->first();
            if($cek == false) {
                // belum ditambahkan
                if($request->idthpembelian != 0) {
                    // jika id header pembelian bukan 0, maka langsung update stok produk
                    $produk = Produk::find($request->id_produk);
                    $produk->update([
                        "stok" => $produk->stok - $tdpembelian->qty + $request->qty
                    ]);
                }

                $tdpembelian->update([
                    'idthpembelian' => $request->idthpembelian,
                    'id_produk'     => $request->id_produk,
                    'pesan'     => $request->pesan,
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
            'id_supplier'          => 'required|not_in:0',
            'total'          => 'numeric|not_in:0',
            'potongan'          => 'numeric',
            'total_akhir'          => 'numeric'
        ]);

        //create
        $thpembelian = Thpembelian::create([
            'kode'     => $this->generatePurchaseCode(),
            'id_supplier'     => $request->id_supplier,
            'total'     => $request->total,
            'potongan'     => $request->potongan,
            'total_akhir'     => $request->total_akhir,
            'tanggal'     => $request->tanggal
        ]);

        // update id header di detail pembelian
        Tdpembelian::where('idthpembelian', 0)
            ->where('is_delete', 0)
            ->update(['idthpembelian' => $thpembelian->id]);

        // mengarah ke fungsi update stok produk
        $this->update_stok($thpembelian->id);
        //redirect to index
        return redirect()->route('tpembelian.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update_stok($idthpembelian) {
        // update stok produk yang ditambahkan ke pembelian
        $query = DB::table('tdpembelians')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthpembelian', $idthpembelian)
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
        // query supplier
        $suppliers = DB::table('suppliers')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        // query header pembelian
        $thpembelian = Thpembelian::find($id);
        return view('tpembelian.edit', compact('thpembelian', 'suppliers', 'produks'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'id_supplier'          => 'required|not_in:0',
            'total'          => 'numeric|not_in:0',
            'potongan'          => 'numeric',
            'total_akhir'          => 'numeric'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $thpembelian = Thpembelian::find($id);

        if (!$thpembelian) {
            // Handle kasus jika thpembelian tidak ditemukan
            return redirect()->back()->with('error', 'pembelian tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $thpembelian->update([
            'kode'     => $request->kode,
            'id_supplier'     => $request->id_supplier,
            'total'     => $request->total,
            'potongan'     => $request->potongan,
            'total_akhir'     => $request->total_akhir,
            'tanggal'     => $request->tanggal
        ]);

        //redirect to index
        return redirect()->route('tpembelian.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $thpembelian = Thpembelian::find($id);
        if (!$thpembelian) {
            // Handle kasus jika pembelian tidak ditemukan
            return redirect()->back()->with('error', 'pembelian tidak ditemukan');
        }
        //delete header pembelian
        $thpembelian->update([
            'is_delete' => 1
        ]);

        $query = DB::table('tdpembelians')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthpembelian', $id)
            ->get();

        foreach($query as $row) {
            // update stok produk dari detail pembelian
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok - $row->qty
            ]);
        }

        // delete detail pembelian
        Tdpembelian::where('idthpembelian', $id)
            ->update(['is_delete' => 1]);

        //redirect to index
        return redirect()->route('tpembelian.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
