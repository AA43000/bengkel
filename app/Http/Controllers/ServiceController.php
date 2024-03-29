<?php

namespace App\Http\Controllers;

use App\Models\Thservice;
use App\Models\Tdservice;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        
        return view('service/index', compact('app'));
    }
    public function get_data(Request $request) {
        $filter = $request->query('filter');

        $response['thservices'] = Thservice::leftJoin('mekaniks', 'mekaniks.id', '=', 'thservices.id_mekanik')
            ->selectRaw('MAX(thservices.id) as id, MIN(thservices.no_plat) as no_plat, MIN(thservices.status) as status, MIN(mekaniks.nama) as nama_mekanik')
            ->orderBy('thservices.status')
            ->groupBy('thservices.no_plat')
            ->where('thservices.is_delete', 0)
            ->where(function ($query) use ($filter) {
                $query->where('thservices.no_plat', 'like', '%' . $filter . '%')
                    ->orWhere('mekaniks.nama', 'like', '%' . $filter . '%');
            })
            ->where('thservices.id_cabang', auth()->user()->id_cabang)
            ->get();

        return response()->json($response);
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
        return view('service.create', compact('pelanggans', 'produks', 'app'));
    }
    function generatePurchaseCode() {
        // mengambil data kode terakhir yang ada
        $lastPurchase = DB::table('thservices')->where('id_cabang', auth()->user()->id_cabang)->latest()->first();

        if (!$lastPurchase) {
            // jika belum ada kode yang dibuat
            $code = 'INV-SV/' . now()->format('my') . '/001';
        } else {
            // jika sudah ada kode yang dibuat
            $lastCode = $lastPurchase->kode;
            $lastNumber = intval(substr($lastCode, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $code = 'INV-SV/' . now()->format('my') . '/' . $newNumber;
        }

        return $code;
    }
    public function load_detail($idthservice) {
        // query detail service di form service
        $query = DB::table('tdservices as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.potongan', 'a.grand_total', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $idthservice)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function load_detail_kerusakan($idthservice) {
        // query detail service di form service
        $query = DB::table('tdservicekerusakans as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $idthservice)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function load_detail_perbaikan($idthservice) {
        // query detail service di form service
        $query = DB::table('tdserviceperbaikans as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $idthservice)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }
    public function edit_detail($idtdservice) {
        // mengambil data detail service tertentu
        $query = Tdservice::find($idtdservice);

        if ($query) {
            // jika data ditemukan
            $response["id"] = $query->id;
            $response["id_produk"] = $query->id_produk;
            $response["pesan"] = ($query->pesan != null ? $query->pesan : '');
            $response["qty"] = $query->qty;
            $response["harga"] = $query->harga;
            $response["subtotal"] = $query->subtotal;
            $response["potongan"] = $query->potongan;
            $response["grand_total"] = $query->grand_total;
        } else {
            // jika data tidak ditemukan
            $response["id"] = '';
            $response["id_produk"] = '';
            $response["pesan"] = '';
            $response["qty"] = '';
            $response["harga"] = '';
            $response["subtotal"] = '';
            $response["potongan"] = '';
            $response["grand_total"] = '';
        }
        return response()->json($response);
    }

    public function get_detail($idthservice) {
        // fungsi get detail di popup list service
        $response['thservice'] = Thservice::find($idthservice);

        $response['tdservice'] = DB::table('tdservices as a')
            ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
            ->select('b.nama_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal'. 'a.potongan', 'a.grand_total', 'a.id')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $idthservice)
            ->get();

        return response()->json($response);
    }
    public function get_riwayat($idthservice) {
        // fungsi get detail di popup list service
        $response['thservice'] = Thservice::find($idthservice);

        $response['thservices'] = DB::table('thservices as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.no_plat', $response['thservice']->no_plat)
            ->get();

        return response()->json($response);
    }
    public function delete_detail($idtdservice) {

        $tdservice = Tdservice::find($idtdservice);

        if ($tdservice) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdservice->update([
                'is_delete' => 1
            ]);
            
            // update stok produk
            if($tdservice->idthservice != 0) {
                $produk = Produk::find($tdservice->id_produk);
                $produk->update([
                    "stok" => $produk->stok + $tdservice->qty
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
        $tdservice = Tdservice::find($request->id_detail);

        if (!$tdservice) {
            // detail insert
            
            // cek produk sudah ditambahkan atau belum
            $cek = Tdservice::where('is_delete', 0)->where('idthservice', $request->idthservice)->where('id_produk', $request->id_produk)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if($produk->stok >= $request->qty) {
                    // stok tersedia
                    Tdservice::create([
                        'idthservice' => $request->idthservice,
                        'id_produk'     => $request->id_produk,
                        'pesan'     => $request->pesan,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                        'potongan'     => ($request->potongan ? $request->potongan : 0),
                        'grand_total'     => $request->grand_total,
                        'id_cabang' => auth()->user()->id_cabang
                    ]);
                    
                    if($request->idthservice != 0) {
                        // jika id header service bukan 0, maka langsung update stok produk
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
            $cek = Tdservice::where('is_delete', 0)->where('idthservice', $request->idthservice)->where('id_produk', $request->id_produk)->where('id', '!=', $request->id_detail)->first();
            if($cek == false) {
                // belum ditambahkan

                // cek stok produk
                $produk = Produk::find($request->id_produk);
                if(($produk->stok + $tdservice->qty) >= $request->qty) {
                    // stok tersedia


                    if($request->idthservice != 0) {
                        // jika id header service bukan 0, maka langsung update stok produk
                        $produk = Produk::find($request->id_produk);
                        $produk->update([
                            "stok" => $produk->stok + $tdservice->qty - $request->qty
                        ]);
                    }

                    $tdservice->update([
                        'idthservice' => $request->idthservice,
                        'id_produk'     => $request->id_produk,
                        'pesan'     => $request->pesan,
                        'qty'     => $request->qty,
                        'harga'     => $request->harga,
                        'subtotal'     => $request->subtotal,
                        'potongan'     => ($request->potongan ? $request->potongan : 0),
                        'grand_total'     => $request->grand_total,
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
            'no_plat'          => 'string'
        ]);

        // cek no plat
        $cek = Thservice::where('is_delete', 0)->where('no_plat', $request->no_plat)->where('id_mekanik', 0)->first();
        if($cek == false) {
            // no plat belum ada di service

            //create
            $thservice = Thservice::create([
                'kode'     => $this->generatePurchaseCode(),
                'no_plat'     => $request->no_plat,
                'id_mekanik'     => 0,
                'total_bayar'     => 0,
                'kembalian'     => 0,
                'pembayaran'     => '',
                'total_akhir'     => 0,
                'tanggal'     => date('Y-m-d'),
                'id_cabang' => auth()->user()->id_cabang,
                'id_user' => auth()->user()->id,
            ]);
            
            $response["status"] = 200;
        } else {
            // no plat sudah ditambahkan
            $response["status"] = 201;
            $response["message"] = "No plat telah ditambahkan";
        }
        return response()->json($response);
    }

    public function update_stok($idthservice) {
        // update stok produk yang ditambahkan ke service
        $query = DB::table('tdservices')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthservice', $idthservice)
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
        
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        // query header service
        $thservice = Thservice::find($id);

        // query mekanik
        $mekaniks = DB::table('mekaniks')
            ->select('*')
            ->where('id', $thservice->id_mekanik)
            ->first();
        return view('service.edit', compact('thservice', 'mekaniks', 'produks', 'app'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'kode'          => '',
            'tanggal'          => 'required',
            'total_akhir'          => 'numeric'
        ]);

        // Lakukan pembaruan data berdasarkan $id
        $thservice = Thservice::find($id);

        if (!$thservice) {
            // Handle kasus jika thservice tidak ditemukan
            return redirect()->back()->with('error', 'service tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $thservice->update([
            'kode'     => $request->kode,
            'no_plat'     => $request->no_plat,
            // 'id_mekanik'     => $request->id_mekanik,
            'total_bayar'     => $request->total_bayar,
            'kembalian'     => $request->kembalian,
            'total_akhir'     => $request->total_akhir,
            'pembayaran'     => $request->pembayaran,
            'tanggal'     => $request->tanggal,
            'tanggal_berikutnya'     => $request->tanggal_berikutnya,
            'km_berikutnya'     => $request->km_berikutnya,
            'status' => 3
        ]);

        //redirect to index
        return redirect()->route('service.index')->with(['success' => 'Data Berhasil Diubah!', 'idthservice' => $id]);
    }
    public function destroy($id)
    {
        $thservice = Thservice::find($id);
        if (!$thservice) {
            // Handle kasus jika service tidak ditemukan
            return redirect()->back()->with('error', 'service tidak ditemukan');
        }
        //delete header service
        $thservice->update([
            'is_delete' => 1
        ]);

        $query = DB::table('tdservices')
            ->select('qty', 'id_produk')
            ->where('is_delete', 0)
            ->where('idthservice', $id)
            ->get();

        foreach($query as $row) {
            // update stok produk dari detail service
            $produk = Produk::find($row->id_produk);
            $produk->update([
                "stok" => $produk->stok + $row->qty
            ]);
        }

        // delete detail service
        Tdservice::where('idthservice', $id)
            ->update(['is_delete' => 1]);

        //redirect to index
        return redirect()->route('service.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
    public function print($idthservice) {
        $data['thservice'] = DB::table('thservices as a')
        ->select('a.*')
        ->where('a.id', $idthservice)
        ->first();
        $data['app'] = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $data['tdservice'] = DB::table('tdservices as a')
        ->leftJoin('produks as b', 'a.id_produk', '=', 'b.id')
        ->select('b.nama_item', 'b.kode_item', 'a.pesan', 'a.qty', 'a.harga', 'a.subtotal', 'a.potongan', 'a.grand_total', 'a.id')
        ->where('a.is_delete', 0)
        ->where('a.idthservice', $idthservice)
        ->get();

        return view('service.print', $data);
    }
}
