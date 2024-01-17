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

Auth::routes();
