<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TryingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicsController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\GalleryController;
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


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
    Route::put('/update-profile/{id}', 'updateProfile')->name('update-profile');
    Route::get('/edit-profile/{id}', 'editProfile')->name('edit-profile');
    Route::delete('/delete-photos/{id}', 'deletePhotos')->name('delete-photos');
   });

   Route::get('/users', [UserController::class,'index'])->name('users.index');
   Route::resource('gallery', GalleryController::class);

Route::get('/create', [PostController::class,'create']);
