<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['logincheck:admin']], function(){
        Route::resource('admin', AdminController::class);
        
    });
    Route::group(['middleware' => ['logincheck:guru']], function(){
        Route::resource('guru', GuruController::class);
    });
    Route::group(['middleware' => ['logincheck:siswa']], function(){
        Route::resource('siswa', SiswaController::class);
    });
});
// User
Route::get('manaje-user', [UserController::class, 'index'])->name('user.view');
Route::get('manaje-user/add', [UserController::class, 'add'])->name('user.add');
Route::post('manaje-user/store', [UserController::class, 'store'])->name('user.store');
Route::delete('manaje-user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
