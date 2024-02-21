<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role != 'admin') {
                abort(403, 'Unauthorized action.');
            }
            
            return $next($request);
        });
    }

    public function index()
    {
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $users = User::leftJoin('cabangs', 'cabangs.id', '=', 'users.id_cabang')
            ->select('users.*', 'cabangs.nama as cabang')
            ->where('users.is_delete', 0)
            ->get();
        return view('user/index', compact('users', 'app'));
    }
    public function create()
    {
        // query cabang
        $cabangs = DB::table('cabangs')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        return view('user.create', compact('app', 'cabangs'));
    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required|string|min:5',
            'id_cabang'     => 'required',
            'email'   => 'required|string|email|unique:users',
            'password'     => 'required|string|min:8|confirmed'
        ]);

        //create
        User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'id_cabang' => $request->id_cabang,
            'role' => $request->role,
            'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        // query cabang
        $cabangs = DB::table('cabangs')
            ->select('*')
            ->where('is_delete', 0)
            ->get();
        $app = DB::table('cabangs')->where('id', auth()->user()->id_cabang)->latest()->first();
        $user = User::find($id);
        return view('user.edit', compact('user', 'app', 'cabangs'));
    }
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required|string|min:5',
            'email'   => 'required|string|email'
        ]);
        if($request->password != '') {
            $this->validate($request, [
                'password'     => 'required|string|min:8|confirmed'
            ]); 
        }

        // Lakukan pembaruan data berdasarkan $id
        $user = User::find($id);

        if (!$user) {
            // Handle kasus jika user tidak ditemukan
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }
    
        // Lakukan pembaruan berdasarkan data dari $request
        $user->update([
            'name'     => $request->name,
            'email'   => $request->email,
            'id_cabang' => $request->id_cabang,
            'role' => $request->role,
        ]);

        if($request->password != '') {
            $user->update([
                'password'   => Hash::make($request->password)
            ]); 
        }

        //redirect to index
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            // Handle kasus jika user tidak ditemukan
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }
        //delete user
        $user->update([
            'is_delete' => 1
        ]);

        //redirect to index
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
