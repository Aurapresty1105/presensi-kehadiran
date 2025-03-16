<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index(){
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();
        return view('profil', compact('user', 'siswa'));
    }
}
