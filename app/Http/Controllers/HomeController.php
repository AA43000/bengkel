<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $total_pelanggan = DB::table('pelanggans')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->count();
        $total_produk = DB::table('produks')
            ->where('is_delete', 0)
            ->where('id_cabang', auth()->user()->id_cabang)
            ->count();
        $pembelian = DB::table('thpembelians')
            ->select(DB::raw('SUM(total_akhir) as total'), DB::raw('COUNT(*) as total_data'))
            ->where('is_delete', 0)
            ->where('tanggal', date("Y-m-d"))
            ->where('id_cabang', auth()->user()->id_cabang)
            ->first();
        $penjualan = DB::table('thpenjualans')
            ->select(DB::raw('SUM(total_akhir) as total'), DB::raw('COUNT(*) as total_data'))
            ->where('is_delete', 0)
            ->where('tanggal', date("Y-m-d"))
            ->where('id_cabang', auth()->user()->id_cabang)
            ->first();
        $service = DB::table('thservices')
            ->select(DB::raw('SUM(total_akhir) as total'), DB::raw('COUNT(*) as total_data'))
            ->where('is_delete', 0)
            ->where('tanggal', date("Y-m-d"))
            ->where('id_cabang', auth()->user()->id_cabang)
            ->first();
        $tukartambah = DB::table('thtukartambahs')
            ->select(DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as total_data'))
            ->where('is_delete', 0)
            ->where('tanggal', date("Y-m-d"))
            ->where('id_cabang', auth()->user()->id_cabang)
            ->first();
        
        $thpenjualans = DB::table('thpenjualans')
            ->leftJoin('pelanggans', 'pelanggans.id', '=', 'thpenjualans.id_pelanggan')
            ->select('thpenjualans.*', 'pelanggans.kode as kode_pelanggan', 'pelanggans.nama as nama_pelanggan')
            ->latest()
            ->limit(5) // Menambah filter limit ke 10
            ->where('thpenjualans.is_delete', 0)
            ->where('thpenjualans.tanggal', date('Y-m-d'))
            ->where('thpenjualans.id_cabang', auth()->user()->id_cabang)
            ->get();
        
        $total_transaksi = $pembelian->total_data + $penjualan->total_data + $service->total_data + $tukartambah->total_data;
        $total_omset = $penjualan->total + $service->total + $tukartambah->total - $pembelian->total;

        $chart = [
            'pembelian' => $pembelian->total,
            'penjualan' => $penjualan->total,
            'service' => $service->total,
            'tukartambah' => $tukartambah->total,
        ];

        return view('home', compact('app', 'total_pelanggan', 'total_produk', 'total_transaksi', 'total_omset', 'chart', 'thpenjualans'));
    }
}
