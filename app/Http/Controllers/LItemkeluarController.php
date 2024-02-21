<?php

namespace App\Http\Controllers;
use App\Models\Thitemkeluar;
use App\Models\Tditemkeluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LItemkeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('litemkeluar/index', compact('app'));
    }
    public function get_data(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $response['thitemkeluar'] = DB::table('thitemkeluars as a')
            ->select('a.*')
            ->where('a.is_delete', 0)
            ->where('a.id_cabang', auth()->user()->id_cabang)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($response);
    }
}
