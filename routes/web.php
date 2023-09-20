<?php

use App\Http\Controllers\TryingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/boom',[TryingController::class,'boomlan']);
// Route::get('/g2',[TryingController::class,'g2esport']);
// Route::get('liquid',[TryingController::class,'teamliquid']);
// Route::get('/bds',[TryingController::class,'bdsesport']);
// Route::get('/heroic',[TryingController::class,'heroicesport']);
// Route::get('/',[TryingController::class,'beranda']);

Route::get('/comics',[ComicsController::class,'index']);
Route::get('/comics/create', [ComicsController::class,'create'])->name('comics.create');
Route::post('/comics',[ComicsController::class,'store'])->name('comics.store');
Route::post('/comics/delete/{id_comics}',[ComicsController::class,'destroy'])->name('comics.destroy');
