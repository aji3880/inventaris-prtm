<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
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

Route::get('/', function () {
    return view('main');
});
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/dashboard', function(){
    return view('dashboard.index');
})->middleware('auth');

/*/Route::prefix('barang')->group(function(){
    Route::get('/', [BarangController::class, 'index'])->middleware('auth');
    Route::get('/create', [BarangController::class, 'create'])->middleware('auth');
    Route::post('/create', [BarangController::class, 'store'])->middleware('auth');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->middleware('auth');
    Route::post('/{id}/edit', [BarangController::class, 'update'])->middleware('auth');
    Route::get('/{id}/delete', [BarangController::class, 'delete'])->middleware('auth');
});*/

Route::resource('/barang', BarangController::class)->middleware('auth');
Route::get('/create', [BarangController::class, 'create'])->middleware('auth');
Route::get('/{id}', [BarangController::class, 'edit'])->middleware('auth');
Route::post('/barang', [BarangController::class, 'store'])->middleware('auth');
Route::put('/{id}', [BarangController::class, 'update'])->middleware('auth');
//Route::post('/barang', [BarangController::class, 'update'])->middleware('auth');
//Route::get('/edit', [BarangController::class, 'edit'])->middleware('auth');
//Route::post('/edit', [BarangController::class, 'update'])->middleware('auth');
Route::resource('masuk', BarangMasukController::class)->middleware('auth');
Route::resource('keluar', BarangKeluarController::class)->middleware('auth');

