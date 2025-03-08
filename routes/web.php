<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
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
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['logincheck:admin']], function () {
        return view('home');

    });
    Route::group(['middleware' => ['logincheck:guru']], function () {
        return view('home');
    });
    Route::group(['middleware' => ['logincheck:siswa']], function () {
        return view('home');
    });
});
// User
Route::get('manaje-user', [UserController::class, 'index'])->name('user.view');
Route::get('manaje-user/add', [UserController::class, 'add'])->name('user.add');
Route::post('manaje-user/store', [UserController::class, 'store'])->name('user.store');
Route::get('manaje-user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('manaje-user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('manaje-user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// Kelas
Route::get('manaje-kelas', [KelasController::class, 'index'])->name('kelas.view');
Route::get('manaje-kelas/add', [KelasController::class, 'add'])->name('kelas.add');
Route::post('manaje-kelas/store', [KelasController::class, 'store'])->name('kelas.store');
Route::get('manaje-kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('manaje-kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::get('manaje-kelas/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

// Siswa
Route::get('manaje-siswa', [SiswaController::class, 'index'])->name('siswa.view');
