<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::latest()->paginate(10);
        return view('menu.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'angkatan' => 'required|:',
        ]);

        // Simpan data ke database
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'angkatan' => $request->angkatan,
        ]);

        // Redirect dengan SweetAlert sukses
        Alert::success('Berhasil', 'Sukses menambahkan data');
        return redirect()->route('kelas.view')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'angkatan' => 'required|integer',
        ]);

        // Temukan kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Update data kelas
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'angkatan' => $request->angkatan,
        ]);

        // Redirect kembali dengan SweetAlert sukses
        Alert::success('Berhasil', 'Sukses memperbarui data');
        return redirect()->route('kelas.view');
    }

    public function destroy($id)
    {
        // Cari kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Hapus kelas dari database
        $kelas->delete();

        // Kirim flash message ke session untuk SweetAlert
        Alert::success('Berhasil', 'Sukses menghapus data');
        return redirect()->route('kelas.view');
    }

}
