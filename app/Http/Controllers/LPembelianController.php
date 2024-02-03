<?php

namespace App\Http\Controllers;
use App\Models\Thpembelian;
use App\Models\Tdpembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class LPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('lpembelian/index', compact('app'));
    }
    public function get_data(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $response['thpembelian'] = DB::table('thpembelians as a')
            ->leftJoin('suppliers as b', 'a.id_supplier', '=', 'b.id')
            ->select('b.kode as kode_supplier', 'b.nama as nama_supplier', 'a.*')
            ->where('a.is_delete', 0)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($response);
    }
}
