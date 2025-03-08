<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::paginate(10);
        return view('menu.kelas.index', compact('kelas'));
    }
    public function add()
    {
        return view('menu.kelas.add');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'angkatan' => 'required|:',
        ]);

        // Simpan data ke database
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'angkatan' => $request->angkatan,
        ]);

        // Redirect dengan SweetAlert sukses
        return redirect()->route('kelas.view')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari data kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Tampilkan view edit dan kirimkan data kelas
        return view('menu.kelas.edit', compact('kelas'));
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
        return redirect()->route('kelas.view')->with('success', 'Data kelas berhasil diperbarui!');
    }

}
