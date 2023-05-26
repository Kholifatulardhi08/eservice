<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kategori\KategoriController;
use App\Http\Controllers\Kategori\SubkategoriController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\Slider\TestimoniController;
use App\Http\Controllers\Jasa\JasaController;
use App\Http\Controllers\Pengguna\PenyediaController;
use App\Http\Controllers\Pengguna\PenyewaController;
use App\Http\Controllers\Pesanan\PesananController;
use App\Http\Controllers\Pesanan\PesananDetailController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function()
{
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::group(['middleware' => ['jwt.verify']], function()
    {
        // route untuk logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // route untuk Resources Api
        Route::resources([
            'kategori' => KategoriController::class,
            'subkategori' => SubkategoriController::class,
            'slider' => SliderController::class,
            'jasa' => JasaController::class,
            'penyedia' => PenyediaController::class,
            'penyewa' => PenyewaController::class,
            'testimoni' => TestimoniController::class,
            'pesanan' => PesananController::class,
            'pesanan_detail' => PesananDetailController::class,
        ]);
    });
});
