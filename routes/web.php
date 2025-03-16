<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfilController;
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
Route::post('manaje-user/store', [UserController::class, 'store'])->name('user.store');
Route::put('manaje-user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('manaje-user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// Kelas
Route::get('manaje-kelas', [KelasController::class, 'index'])->name('kelas.view');
Route::post('manaje-kelas/store', [KelasController::class, 'store'])->name('kelas.store');
Route::put('manaje-kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::get('manaje-kelas/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

// Siswa
Route::get('manaje-siswa', [SiswaController::class, 'index'])->name('siswa.view');
Route::post('manaje-siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
Route::put('manaje-siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::get('manaje-siswa/destroy/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

// Kehadiran
Route::get('kehadiran-siswa', [PresensiController::class, 'index_kehadiran'])->name('kehadiran.view');
Route::get('kehadiran', [PresensiController::class, 'kehadiran'])->name('kehadiran2.view');
Route::get('presensi', [PresensiController::class, 'index_presensi'])->name('presensi.view');
Route::post('presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
Route::put('/presensi/update-catatan/{id}', [PresensiController::class, 'updateCatatan'])->name('presensi.updateCatatan');
Route::post('/kehadiran/update-keterangan', [PresensiController::class, 'updateKeterangan'])->name('kehadiran.update');
Route::post('kehadiran/store', [PresensiController::class, 'store_kehadiran'])->name('kehadiran.store');

// Profil
Route::get('profil', [ProfilController::class, 'index'])->name('profil.view');
