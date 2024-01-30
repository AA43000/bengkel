<?php

namespace App\Http\Controllers;

use App\Models\Thtukartambah;
use App\Models\Tdtukartambah;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TukartambahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query header tukar tambah
        $thtukartambahs = Thtukartambah::leftJoin('pelanggans', 'pelanggans.id', '=', 'thtukartambahs.id_pelanggan')
        ->select('thtukartambahs.*', 'pelanggans.kode as kode_pelanggan', 'pelanggans.nama as nama_pelanggan')
        ->latest()
        ->where('thtukartambahs.is_delete', 0)
        ->where('thtukartambahs.id_cabang', auth()->user()->id_cabang)
        ->paginate(5);
        return view('tukartambah/index', compact('thtukartambahs', 'app'));
    }
    public function create()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query pelanggan
        $pelanggans = DB::table('pelanggans')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        // query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        return view('tukartambah.create', compact('pelanggans', 'produks', 'app'));
    }
    function generatePurchaseCode() {
        // mengambil data kode terakhir yang ada
        $lastPurchase = DB::table('thtukartambahs')->where('id_cabang', auth()->user()->id_cabang)->latest()->first();

        if (!$lastPurchase) {
            // jika belum ada kode yang dibuat
            $code = 'INV-TT/' . now()->format('my') . '/001';
        } else {
            // jika sudah ada kode yang dibuat
            $lastCode = $lastPurchase->kode;
            $lastNumber = intval(substr($lastCode, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $code = 'INV-TT/' . now()->format('my') . '/' . $newNumber;
        }

        return $code;
    }
    public function load_detail($idthtukartambah) {
        // query detail tukartambah di form tukartambah
        $query = DB::table('tdtukartambahs as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.potongan', 'a.total', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.id_cabang', auth()->user()->id_cabang)
            ->where('a.idthtukartambah', $idthtukartambah)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function edit_detail($idtdtukartambah) {
        // mengambil data detail tukartambah tertentu
        $query = Tdtukartambah::find($idtdtukartambah);

        if ($query) {
            // jika data ditemukan
            $response["id"] = $query->id;
            $response["id_produk"] = $query->id_produk;
            $response["qty"] = $query->qty;
            $response["harga"] = $query->harga;
            $response["subtotal"] = $query->subtotal;
            $response["potongan"] = $query->potongan;
            $response["total"] = $query->total;
        } else {
            // jika data tidak ditemukan
            $response["id"] = '';
            $response["id_produk"] = '';
            $response["qty"] = '';
            $response["harga"] = '';
            $response["subtotal"] = '';
            $response["potongan"] = '';
            $response["total"] = '';
        }
        return response()->json($response);
    }

    public function get_detail($idthtukartambah) {
        // fungsi get detail di popup list tukartambah
        $response['thtukartambah'] = Thtukartambah::find($idthtukartambah);

        $response['tdtukartambah'] = DB::table('tdtukartambahs as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.potongan', 'a.total', 'a.qty', 'a.harga', 'a.subtotal', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthtukartambah', $idthtukartambah)
            ->get();

        return response()->json($response);
    }
    public function delete_detail($idtdtukartambah) {

        $tdtukartambah = Tdtukartambah::find($idtdtukartambah);

        if ($tdtukartambah) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdtukartambah->update([
                'is_delete' => 1
            ]);
            
            // update stok produk
            if($tdtukartambah->idthtukartambah != 0) {
                $produk = Produk::find($tdtukartambah->id_produk);
                $produk->update([
                    "stok" => $produk->stok + $tdtukartambah->qty
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
        $tdtukartambah = Tdtukartambah::find($request->id_detail);

        if (!$tdtukartambah) {
            // detail insert
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdtukartambah::where('is_delete', 0)->where('idthtukartambah', $request->idthtukartambah)->where('id_produk', $request->id_produk)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if($produk->stok >= $request->qty) {
                    // stok tersedia
                    Tdtukartambah::create([
                        'idthtukartambah' => $request->idthtukartambah,
                        'id_produk'     => $request->id_produk,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                        'potongan'     => $request->potongan,
                        'total'     => $request->total,
                        'id_cabang' => auth()->user()->id_cabang
                    ]);
                    
                    if($request->idthtukartambah != 0) {
                        // jika id header tukartambah bukan 0, maka langsung update stok produk
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
            $cek = Tdtukartambah::where('is_delete', 0)->where('idthtukartambah', $request->idthtukartambah)->where('id_produk', $request->id_produk)->where('id', '!=', $request->id_detail)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if(($produk->stok + $tdtukartambah->qty) >= $request->qty) {
                    // stok tersedia


                    if($request->idthtukartambah != 0) {
                        // jika id header tukartambah bukan 0, maka langsung update stok produk
                        $produk = Produk::find($request->id_produk);
                        $produk->update([
                            "stok" => $produk->stok + $tdtukartambah->qty - $request->qty
                        ]);
                    }

                    $tdtukartambah->update([
                        'idthtukartambah' => $request->idthtukartambah,
                        'id_produk'     => $request->id_produk,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                        'potongan'     => $request->potongan,
                        'total'     => $request->total,
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
            'tanggal'          => 'date',
        ]);

        //create
        $thtukartambah = Thtukartambah::create([
            'kode'     => $this->generatePurchaseCode(),
            'id_pelanggan'     => $request->id_pelanggan,
            'total'     => $request->total,
            'tanggal'     => $request->tanggal,
            'id_cabang' => auth()->user()->id_cabang
        ]);

        // update id header di detail tukartambah
        Tdtukartambah::where('idthtukartambah', 0)
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->update(['idthtukartambah' => $thtukartambah->id]);

        // mengarah ke fungsi update stok produk
        $this->update_stok($thtukartambah->id);
        //redirect to index
        return redirect()->route('tukartambah.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update_stok($idthtukartambah) {
        // update stok produk yang ditambahkan ke tukartambah
        $query = DB::table('tdtukartambahs')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthtukartambah', $idthtukartambah)
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
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query pelanggan
        $pelanggans = DB::table('pelanggans')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        // query header tukartambah
        $thtukartambah = Thtukartambah::find($id);
        return view('tukartambah.edit', compact('thtukartambah', 'pelanggans', 'produks', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'id_pelanggan'          => 'required|not_in:0',
            'total'          => 'numeric|not_in:0',
            'tanggal'          => 'date',
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $thtukartambah = Thtukartambah::find($id);

        if (!$thtukartambah) {
            // Handle kasus jika thtukartambah tidak ditemukan
            return redirect()->back()->with('error', 'tukartambah tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $thtukartambah->update([
            'kode'     => $request->kode,
            'id_pelanggan'     => $request->id_pelanggan,
            'total'     => $request->total,
            'tanggal'     => $request->tanggal
        ]);

        //redirect to index
        return redirect()->route('tukartambah.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $thtukartambah = Thtukartambah::find($id);
        if (!$thtukartambah) {
            // Handle kasus jika tukartambah tidak ditemukan
            return redirect()->back()->with('error', 'tukartambah tidak ditemukan');
        }
        //delete header tukartambah
        $thtukartambah->update([
            'is_delete' => 1
        ]);

        $query = DB::table('tdtukartambahs')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthtukartambah', $id)
            ->get();

        foreach($query as $row) {
            // update stok produk dari detail tukartambah
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok + $row->qty
            ]);
        }

        // delete detail tukartambah
        Tdtukartambah::where('idthtukartambah', $id)
            ->update(['is_delete' => 1]);

        //redirect to index
        return redirect()->route('tukartambah.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
