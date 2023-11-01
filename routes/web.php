<?php

use App\Http\Controllers\TryingController;
use App\Http\Controllers\UserController;
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
<<<<<<< Updated upstream
=======
Route::get('/comics/update', [ComicsController::class,'update'])->name('comics.update');

Route::get('/send-mail', [SendEmailController::class,
'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
   });

   Route::get('/users', [UserController::class,'index'])->name('users.index');
>>>>>>> Stashed changes
