<?php

namespace App\Http\Controllers;

use App\Models\Thpenjualan;
use App\Models\Tdpenjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TpenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // query header penjualan
        $thpenjualans = Thpenjualan::leftJoin('pelanggans', 'pelanggans.id', '=', 'thpenjualans.id_pelanggan')
        ->select('thpenjualans.*', 'pelanggans.kode as kode_pelanggan', 'pelanggans.nama as nama_pelanggan')
        ->latest()->where('thpenjualans.is_delete', 0)->paginate(5);
        return view('tpenjualan/index', compact('thpenjualans'));
    }
    public function create()
    {
        // query pelanggan
        $pelanggans = DB::table('pelanggans')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        // query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        return view('tpenjualan.create', compact('pelanggans', 'produks'));
    }
    function generatePurchaseCode() {
        // mengambil data kode terakhir yang ada
        $lastPurchase = DB::table('thpenjualans')->latest()->first();

        if (!$lastPurchase) {
            // jika belum ada kode yang dibuat
            $code = 'INV-JL/' . now()->format('my') . '/001';
        } else {
            // jika sudah ada kode yang dibuat
            $lastCode = $lastPurchase->kode;
            $lastNumber = intval(substr($lastCode, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $code = 'INV-JL/' . now()->format('my') . '/' . $newNumber;
        }

        return $code;
    }
    public function load_detail($idthpenjualan) {
        // query detail penjualan di form penjualan
        $query = DB::table('tdpenjualans as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthpenjualan', $idthpenjualan)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function edit_detail($idtdpenjualan) {
        // mengambil data detail penjualan tertentu
        $query = Tdpenjualan::find($idtdpenjualan);

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

    public function get_detail($idthpenjualan) {
        // fungsi get detail di popup list penjualan
        $response['thpenjualan'] = Thpenjualan::find($idthpenjualan);

        $response['tdpenjualan'] = DB::table('tdpenjualans as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthpenjualan', $idthpenjualan)
            ->get();

        return response()->json($response);
    }
    public function delete_detail($idtdpenjualan) {

        $tdpenjualan = Tdpenjualan::find($idtdpenjualan);

        if ($tdpenjualan) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdpenjualan->update([
                'is_delete' => 1
            ]);
            
            // update stok produk
            if($tdpenjualan->idthpenjualan != 0) {
                $produk = Produk::find($tdpenjualan->id_produk);
                $produk->update([
                    "stok" => $produk->stok + $tdpenjualan->qty
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
        $tdpenjualan = Tdpenjualan::find($request->id_detail);

        if (!$tdpenjualan) {
            // detail insert
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdpenjualan::where('is_delete', 0)->where('idthpenjualan', $request->idthpenjualan)->where('id_produk', $request->id_produk)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if($produk->stok >= $request->qty) {
                    // stok tersedia
                    Tdpenjualan::create([
                        'idthpenjualan' => $request->idthpenjualan,
                        'id_produk'     => $request->id_produk,
                        'pesan'     => $request->pesan,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                    ]);
                    
                    if($request->idthpenjualan != 0) {
                        // jika id header penjualan bukan 0, maka langsung update stok produk
                        $produk = Produk::find($request->id_produk);
                        $produk->update([
                            "stok" => $produk->stok - $request->qty
                        ]);
                    }
                    $response["status"] = 200;
                } else {
                    // stok tidak tersedia
                    $response["status"] = 201;
                    $response["message"] = "Stok tersedia: ".$produk->stok;
                }
            } else {
                // sudah ditambahkan
                $response["status"] = 201;
                $response["message"] = "Produk telah ditambahkan";
            }
        } else {
            // detail update
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdpenjualan::where('is_delete', 0)->where('idthpenjualan', $request->idthpenjualan)->where('id_produk', $request->id_produk)->where('id', '!=', $request->id_detail)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if(($produk->stok + $tdpenjualan->qty) >= $request->qty) {
                    // stok tersedia


                    if($request->idthpenjualan != 0) {
                        // jika id header penjualan bukan 0, maka langsung update stok produk
                        $produk = Produk::find($request->id_produk);
                        $produk->update([
                            "stok" => $produk->stok + $tdpenjualan->qty - $request->qty
                        ]);
                    }

                    $tdpenjualan->update([
                        'idthpenjualan' => $request->idthpenjualan,
                        'id_produk'     => $request->id_produk,
                        'pesan'     => $request->pesan,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                    ]);
                    $response["status"] = 200;
                } else {
                    // stok tidak tersedia
                    $response["status"] = 201;
                    $response["message"] = "Stok tersedia: ".$produk->stok;
                }
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
            'id_pelanggan'          => 'required|not_in:0',
            'total'          => 'numeric|not_in:0',
            'potongan'          => 'numeric',
            'total_akhir'          => 'numeric'
        ]);

        //create
        $thpenjualan = Thpenjualan::create([
            'kode'     => $this->generatePurchaseCode(),
            'id_pelanggan'     => $request->id_pelanggan,
            'total'     => $request->total,
            'potongan'     => $request->potongan,
            'total_akhir'     => $request->total_akhir,
            'tanggal'     => $request->tanggal
        ]);

        // update id header di detail penjualan
        Tdpenjualan::where('idthpenjualan', 0)
            ->where('is_delete', 0)
            ->update(['idthpenjualan' => $thpenjualan->id]);

        // mengarah ke fungsi update stok produk
        $this->update_stok($thpenjualan->id);
        //redirect to index
        return redirect()->route('tpenjualan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update_stok($idthpenjualan) {
        // update stok produk yang ditambahkan ke penjualan
        $query = DB::table('tdpenjualans')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthpenjualan', $idthpenjualan)
            ->get();

        foreach($query as $row) {
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok - $row->qty
            ]);
        }
    }

    public function edit($id)
    {
        // query pelanggan
        $pelanggans = DB::table('pelanggans')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        // query header penjualan
        $thpenjualan = Thpenjualan::find($id);
        return view('tpenjualan.edit', compact('thpenjualan', 'pelanggans', 'produks'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'id_pelanggan'          => 'required|not_in:0',
            'total'          => 'numeric|not_in:0',
            'potongan'          => 'numeric',
            'total_akhir'          => 'numeric'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $thpenjualan = Thpenjualan::find($id);

        if (!$thpenjualan) {
            // Handle kasus jika thpenjualan tidak ditemukan
            return redirect()->back()->with('error', 'penjualan tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $thpenjualan->update([
            'kode'     => $request->kode,
            'id_pelanggan'     => $request->id_pelanggan,
            'total'     => $request->total,
            'potongan'     => $request->potongan,
            'total_akhir'     => $request->total_akhir,
            'tanggal'     => $request->tanggal
        ]);

        //redirect to index
        return redirect()->route('tpenjualan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $thpenjualan = Thpenjualan::find($id);
        if (!$thpenjualan) {
            // Handle kasus jika penjualan tidak ditemukan
            return redirect()->back()->with('error', 'penjualan tidak ditemukan');
        }
        //delete header penjualan
        $thpenjualan->update([
            'is_delete' => 1
        ]);

        $query = DB::table('tdpenjualans')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthpenjualan', $id)
            ->get();

        foreach($query as $row) {
            // update stok produk dari detail penjualan
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok + $row->qty
            ]);
        }

        // delete detail penjualan
        Tdpenjualan::where('idthpenjualan', $id)
            ->update(['is_delete' => 1]);

        //redirect to index
        return redirect()->route('tpenjualan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
