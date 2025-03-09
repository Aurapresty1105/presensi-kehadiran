<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    public function index()
    {
        $daftarSiswa = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        $siswa = Siswa::paginate(10);
        return view('menu.siswa.index', compact('siswa', 'daftarSiswa', 'kelas'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kelas' => 'required|exists:kelas,id',
            'nis' => 'required|numeric|unique:siswa,nis',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Simpan data siswa
        Siswa::create([
            'id_user' => $request->id_user,
            'id_kelas' => $request->id_kelas,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);
        Alert::success('Berhasil', 'Sukses menambahkan data');
        return view('menu.siswa.index');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kelas' => 'required|exists:kelas,id',
            'nis' => 'required|numeric|unique:siswa,nis,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Temukan siswa dan update data
        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'id_user' => $request->id_user,
            'id_kelas' => $request->id_kelas,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        Alert::success('Berhasil', 'Sukses memperbarui data');
        return view('menu.siswa.index');
    }
    
    public function destroy($id){
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        Alert::success('Berhasil', 'Sukses menghapus data');
        return view('menu.siswa.index');
    }

}
