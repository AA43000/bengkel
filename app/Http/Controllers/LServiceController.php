<?php

namespace App\Http\Controllers;
use App\Models\Thservice;
use App\Models\Tdservice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('lservice/index', compact('app'));
    }
    public function get_data(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $response['thservice'] = DB::table('thservices as a')
            ->leftJoin('mekaniks as b', 'a.id_mekanik', '=', 'b.id')
            ->select('b.kode as kode_mekanik', 'b.nama as nama_mekanik', 'a.*')
            ->where('a.is_delete', 0)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($response);
    }
}
