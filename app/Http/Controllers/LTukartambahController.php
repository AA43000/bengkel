<?php

namespace App\Http\Controllers;
use App\Models\Thtukartambah;
use App\Models\Tdtukartambah;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LTukartambahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('ltukartambah/index', compact('app'));
    }
    public function get_data(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $response['thtukartambah'] = DB::table('thtukartambahs as a')
            ->leftJoin('pelanggans as b', 'a.id_pelanggan', '=', 'b.id')
            ->select('b.kode as kode_pelanggan', 'b.nama as nama_pelanggan', 'a.*')
            ->where('a.is_delete', 0)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($response);
    }
}
