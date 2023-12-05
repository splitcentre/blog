<?php

use App\Http\Controllers\GreetController;
use App\Http\Controllers\InfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/info', [InfoController::class, 'index'])->name('info');
Route::get('/greet', [GreetController::class,'greet'])->name('greet');
Route::get('/getGallery', [GreetController::class,'getGallery'])->name('Getgallery');
Route::post('/postgallery', [GreetController::class,'store'])->name('Postgallery');
