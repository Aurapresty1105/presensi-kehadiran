<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\User;

class SiswaController extends Controller
{
    public function index(){
        $daftarSiswa = User::where('role', 'siswa');
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        return view('menu.siswa.index', compact('siswa', 'daftarSiswa', 'kelas'));
    }

}
