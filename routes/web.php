<?php

use App\Http\Controllers\ArduinoController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\WelcomeController;
use App\Models\Aturan;
use App\Models\Kriteria;
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

Route::get('/', function () {
    return view('welcome');
});

// route::get('/arduino', [ArduinoController::class,'index'])->name('getArduino.index');
route::resource('/arduino',ArduinoController::class);
route::get('/data-analisa', [WelcomeController::class,'getData'])->name('data.analisa');
route::get('data-tampil', [WelcomeController::class,'index'])->name('data.tampil');
route::get('get-chart',[WelcomeController::class,'getDataChart'])->name('data.chart');

// Route::get('/dashboard', function () {
//     $data = Aturan::count();
//     return view('dashboard',$data);
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',function()
    {
        $aturan = Aturan::count();
        $kriteria = Kriteria::count();
        return view('dashboard',compact('aturan','kriteria'));
    })->name('dashboard');
    // aturan fuzzy
    Route::resource('/aturan', AturanController::class);
    Route::get('/aturan-data',[AturanController::class,'getData']);
    // kriteria
    Route::resource('/kriteria', KriteriaController::class);
});

require __DIR__.'/auth.php';
