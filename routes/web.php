<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return route('home');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/user', \App\Http\Controllers\UserController::class);
Route::get('/user/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

Route::resource('/sales', \App\Http\Controllers\SalesController::class);
Route::get('/sales/{id}/edit', [\App\Http\Controllers\SalesController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{id}', [\App\Http\Controllers\SalesController::class, 'update'])->name('sales.update');
Route::get('/sales/{id}', [\App\Http\Controllers\SalesController::class, 'destroy'])->name('sales.destroy');

Route::resource('/pelanggan', \App\Http\Controllers\PelangganController::class);
Route::get('/pelanggan/{id}/edit', [\App\Http\Controllers\PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id}', [\App\Http\Controllers\PelangganController::class, 'update'])->name('pelanggan.update');
Route::get('/pelanggan/{id}', [\App\Http\Controllers\PelangganController::class, 'destroy'])->name('pelanggan.destroy');

Route::resource('/mekanik', \App\Http\Controllers\MekanikController::class);
Route::get('/mekanik/{id}/edit', [\App\Http\Controllers\MekanikController::class, 'edit'])->name('mekanik.edit');
Route::put('/mekanik/{id}', [\App\Http\Controllers\MekanikController::class, 'update'])->name('mekanik.update');
Route::get('/mekanik/{id}', [\App\Http\Controllers\MekanikController::class, 'destroy'])->name('mekanik.destroy');

Route::resource('/kendaraan', \App\Http\Controllers\KendaraanController::class);
Route::get('/kendaraan/{id}/edit', [\App\Http\Controllers\KendaraanController::class, 'edit'])->name('kendaraan.edit');
Route::put('/kendaraan/{id}', [\App\Http\Controllers\KendaraanController::class, 'update'])->name('kendaraan.update');
Route::get('/kendaraan/{id}', [\App\Http\Controllers\KendaraanController::class, 'destroy'])->name('kendaraan.destroy');

Route::resource('/supplier', \App\Http\Controllers\SupplierController::class);
Route::get('/supplier/{id}/edit', [\App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
Route::get('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::resource('/produk', \App\Http\Controllers\ProdukController::class);
Route::get('/produk/{id}/edit', [\App\Http\Controllers\ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [\App\Http\Controllers\ProdukController::class, 'update'])->name('produk.update');
Route::get('/produk/{id}', [\App\Http\Controllers\ProdukController::class, 'destroy'])->name('produk.destroy');

Route::resource('/tpembelian', \App\Http\Controllers\TpembelianController::class);
Route::get('/tpembelian/{id}/edit', [\App\Http\Controllers\TpembelianController::class, 'edit'])->name('tpembelian.edit');
Route::put('/tpembelian/{id}', [\App\Http\Controllers\TpembelianController::class, 'update'])->name('tpembelian.update');
Route::get('/tpembelian/{id}', [\App\Http\Controllers\TpembelianController::class, 'destroy'])->name('tpembelian.destroy');
Route::post('/tpembelian/post_detail', [\App\Http\Controllers\TpembelianController::class, 'post_detail'])->name('tpembelian.post_detail');
Route::get('/tpembelian/load_produk/{id_produk}', [\App\Http\Controllers\TpembelianController::class, 'load_produk'])->name('tpembelian.load_produk');
Route::get('/tpembelian/load_detail/{idthpembelian}', [\App\Http\Controllers\TpembelianController::class, 'load_detail'])->name('tpembelian.load_detail');
Route::get('/tpembelian/edit_detail/{idtdpembelian}', [\App\Http\Controllers\TpembelianController::class, 'edit_detail'])->name('tpembelian.edit_detail');
Route::get('/tpembelian/delete_detail/{idtdpembelian}', [\App\Http\Controllers\TpembelianController::class, 'delete_detail'])->name('tpembelian.delete_detail');
Route::get('/tpembelian/get_detail/{idthpembelian}', [\App\Http\Controllers\TpembelianController::class, 'get_detail'])->name('tpembelian.get_detail');

Route::resource('/tpenjualan', \App\Http\Controllers\TpenjualanController::class);
Route::get('/tpenjualan/{id}/edit', [\App\Http\Controllers\TpenjualanController::class, 'edit'])->name('tpenjualan.edit');
Route::put('/tpenjualan/{id}', [\App\Http\Controllers\TpenjualanController::class, 'update'])->name('tpenjualan.update');
Route::get('/tpenjualan/{id}', [\App\Http\Controllers\TpenjualanController::class, 'destroy'])->name('tpenjualan.destroy');
Route::post('/tpenjualan/post_detail', [\App\Http\Controllers\TpenjualanController::class, 'post_detail'])->name('tpenjualan.post_detail');
Route::get('/tpenjualan/load_produk/{id_produk}', [\App\Http\Controllers\TpenjualanController::class, 'load_produk'])->name('tpenjualan.load_produk');
Route::get('/tpenjualan/load_detail/{idthpembelian}', [\App\Http\Controllers\TpenjualanController::class, 'load_detail'])->name('tpenjualan.load_detail');
Route::get('/tpenjualan/edit_detail/{idtdpembelian}', [\App\Http\Controllers\TpenjualanController::class, 'edit_detail'])->name('tpenjualan.edit_detail');
Route::get('/tpenjualan/delete_detail/{idtdpembelian}', [\App\Http\Controllers\TpenjualanController::class, 'delete_detail'])->name('tpenjualan.delete_detail');
Route::get('/tpenjualan/get_detail/{idthpembelian}', [\App\Http\Controllers\TpenjualanController::class, 'get_detail'])->name('tpenjualan.get_detail');

Route::resource('/item_keluar', \App\Http\Controllers\ItemkeluarController::class);
Route::get('/item_keluar/{id}/edit', [\App\Http\Controllers\ItemkeluarController::class, 'edit'])->name('item_keluar.edit');
Route::put('/item_keluar/{id}', [\App\Http\Controllers\ItemkeluarController::class, 'update'])->name('item_keluar.update');
Route::get('/item_keluar/{id}', [\App\Http\Controllers\ItemkeluarController::class, 'destroy'])->name('item_keluar.destroy');
Route::post('/item_keluar/post_detail', [\App\Http\Controllers\ItemkeluarController::class, 'post_detail'])->name('item_keluar.post_detail');
Route::get('/item_keluar/load_produk/{id_produk}', [\App\Http\Controllers\ItemkeluarController::class, 'load_produk'])->name('item_keluar.load_produk');
Route::get('/item_keluar/load_detail/{idthpembelian}', [\App\Http\Controllers\ItemkeluarController::class, 'load_detail'])->name('item_keluar.load_detail');
Route::get('/item_keluar/edit_detail/{idtdpembelian}', [\App\Http\Controllers\ItemkeluarController::class, 'edit_detail'])->name('item_keluar.edit_detail');
Route::get('/item_keluar/delete_detail/{idtdpembelian}', [\App\Http\Controllers\ItemkeluarController::class, 'delete_detail'])->name('item_keluar.delete_detail');
Route::get('/item_keluar/get_detail/{idthpembelian}', [\App\Http\Controllers\ItemkeluarController::class, 'get_detail'])->name('item_keluar.get_detail');

Route::resource('/service', \App\Http\Controllers\ServiceController::class);
Route::get('/service/{id}/edit', [\App\Http\Controllers\ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{id}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('service.update');
Route::get('/service/{id}', [\App\Http\Controllers\ServiceController::class, 'destroy'])->name('service.destroy');
Route::post('/service/post_detail', [\App\Http\Controllers\ServiceController::class, 'post_detail'])->name('service.post_detail');
Route::post('/service/store', [\App\Http\Controllers\ServiceController::class, 'store'])->name('service.store');
Route::get('/service/load_produk/{id_produk}', [\App\Http\Controllers\ServiceController::class, 'load_produk'])->name('service.load_produk');
Route::get('/service/load_detail/{idthpembelian}', [\App\Http\Controllers\ServiceController::class, 'load_detail'])->name('service.load_detail');
Route::get('/service/edit_detail/{idtdpembelian}', [\App\Http\Controllers\ServiceController::class, 'edit_detail'])->name('service.edit_detail');
Route::get('/service/delete_detail/{idtdpembelian}', [\App\Http\Controllers\ServiceController::class, 'delete_detail'])->name('service.delete_detail');
Route::get('/service/get_detail/{idthpembelian}', [\App\Http\Controllers\ServiceController::class, 'get_detail'])->name('service.get_detail');

Auth::routes();
