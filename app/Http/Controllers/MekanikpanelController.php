<?php

namespace App\Http\Controllers;

use App\Models\Thservice;
use App\Models\Tdservice;
use App\Models\Tdservicekerusakan;
use App\Models\Tdserviceperbaikan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MekanikpanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query header service
        $thservices = Thservice::leftJoin('mekaniks', 'mekaniks.id', '=', 'thservices.id_mekanik')
        ->select('thservices.*', 'mekaniks.nama as nama_mekanik')
        ->orderByRaw('mekaniks.id = 0 ASC')
        ->where('thservices.status', '<', 3)
        ->where('thservices.is_delete', 0)
        ->where('thservices.id_cabang', auth()->user()->id_cabang)
        ->get();

        // Query untuk menghitung total data service di hari ini
        $total_service = Thservice::where('is_delete', 0)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->count();
        $total_selesai = Thservice::where('is_delete', 0)
        ->where('status', '>', 1)
        ->where('id_cabang', auth()->user()->id_cabang)
        ->count();
        return view('mekanik_panel/index', compact('thservices', 'app', 'total_service', 'total_selesai'));
    }
    public function edit($id)
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        // query mekanik
        $mekanik = DB::table('mekaniks')
            ->select('*')
            ->where('id_user', auth()->user()->id)
            ->first();
        
        //query produk
        $produks = DB::table('produks')
            ->select('*')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->get();
        
        // query header service
        $thservice = Thservice::find($id);
        if($thservice->id_mekanik == 0) {
            $thservice->update(['id_mekanik' => $mekanik->id, 'status' => 1]);
        }
        return view('mekanik_panel.edit', compact('thservice', 'mekanik', 'produks', 'app'));
    }
    public function simpan_data($id) {
        $thservice = Thservice::find($id);

        $thservice->update([
            'status' => 2
        ]);

        return response()->json(['status' => 200]);
    }
    public function get_kerusakan($id) {
        $query = DB::table('tdservicekerusakans as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $id)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }

    public function action_kerusakan(Request $request)
    {
        // cek detail untuk menentukan update atau insert
        $tdservice = Tdservicekerusakan::find($request->id);

        if (!$tdservice) {
            // detail insert
            Tdservicekerusakan::create([
                'idthservice' => $request->idthservice,
                'bagian'     => $request->bagian,
                'kerusakan'     => ($request->kerusakan != '' ? $request->kerusakan : '')
            ]);
            $response["status"] = 200;
        } else {
            // detail update
            $tdservice->update([
                'idthservice' => $request->idthservice,
                'bagian'     => $request->bagian,
                'kerusakan'     => ($request->kerusakan != '' ? $request->kerusakan : '')
            ]);
            $response["status"] = 200;
        }

        return response()->json($response);
    }
    public function edit_kerusakan($id) {
        $query = Tdservicekerusakan::find($id);
        if($query) {
            $response = $query;
        } else {
            $response = '';
        }
        return response()->json($response);
    }

    public function delete_kerusakan($id) {

        $tdservice = Tdservicekerusakan::find($id);

        if ($tdservice) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdservice->update([
                'is_delete' => 1
            ]);
        }
        return response()->json(["status" => 200]);
    }

    public function get_perbaikan($id) {
        $query = DB::table('tdserviceperbaikans as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $id)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }

    public function action_perbaikan(Request $request)
    {
        // cek detail untuk menentukan update atau insert
        $tdservice = Tdserviceperbaikan::find($request->id);

        if (!$tdservice) {
            // detail insert
            Tdserviceperbaikan::create([
                'idthservice' => $request->idthservice,
                'bagian'     => $request->bagian,
                'keterangan'     => ($request->keterangan != '' ? $request->keterangan : '')
            ]);
            $response["status"] = 200;
        } else {
            // detail update
            $tdservice->update([
                'idthservice' => $request->idthservice,
                'bagian'     => $request->bagian,
                'keterangan'     => ($request->keterangan != '' ? $request->keterangan : '')
            ]);
            $response["status"] = 200;
        }

        return response()->json($response);
    }
    public function edit_perbaikan($id) {
        $query = Tdserviceperbaikan::find($id);
        if($query) {
            $response = $query;
        } else {
            $response = '';
        }
        return response()->json($response);
    }

    public function delete_perbaikan($id) {

        $tdservice = Tdserviceperbaikan::find($id);

        if ($tdservice) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdservice->update([
                'is_delete' => 1
            ]);
        }
        return response()->json(["status" => 200]);
    }

    public function get_pergantian($id) {
        $query = DB::table('tdservices as a')
            ->leftJoin('produks as b', 'b.id', '=', 'a.id_produk')
            ->select('a.*', 'b.nama_item')
            ->where('a.is_delete', 0)
            ->where('a.idthservice', $id)
            ->get();

        if ($query) {
            $response["data"] = $query;
        } else {
            $response["data"] = [];
        }
        return response()->json($response);
    }

    public function action_pergantian(Request $request)
    {
        // cek detail untuk menentukan update atau insert
        $tdservice = Tdservice::find($request->id);
        $produk = Produk::find($request->id_produk);

        if (!$tdservice) {
            // detail insert
            Tdservice::create([
                'idthservice' => $request->idthservice,
                'id_produk'     => $request->id_produk,
                'pesan'     => '',
                'qty'     => $request->qty,
                'harga'     => $produk->harga_jual,
                'subtotal'     => $request->qty*$produk->harga_jual,
                'potongan'     => 0,
                'grand_total'     => $request->qty*$produk->harga_jual,
            ]);
            $response["status"] = 200;
        } else {
            // detail update
            $tdservice->update([
                'idthservice' => $request->idthservice,
                'id_produk'     => $request->id_produk,
                'pesan'     => '',
                'qty'     => $request->qty,
                'harga'     => $produk->harga_jual,
                'subtotal'     => $request->qty*$produk->harga_jual,
                'potongan'     => 0,
                'grand_total'     => $request->qty*$produk->harga_jual,
            ]);
            $response["status"] = 200;
        }

        return response()->json($response);
    }
    public function edit_pergantian($id) {
        $query = Tdservice::find($id);
        if($query) {
            $response = $query;
        } else {
            $response = '';
        }
        return response()->json($response);
    }

    public function delete_pergantian($id) {

        $tdservice = Tdservice::find($id);

        if ($tdservice) {
            // jika detail ditemukan
            // update field untuk delete data
            $tdservice->update([
                'is_delete' => 1
            ]);
        }
        return response()->json(["status" => 200]);
    }
}
