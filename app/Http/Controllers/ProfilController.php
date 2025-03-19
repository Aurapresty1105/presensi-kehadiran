<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\WhatsappNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();
        $wa = WhatsappNumber::where('id_user', $user->id)->first();
        return view('profil', compact('user', 'siswa', 'wa'));
    }


    public function saveOrUpdateWhatsappNumber(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_wa' => 'required|string|max:15', // Sesuaikan validasi sesuai kebutuhan
        ]);

        // Ambil ID user dari auth (pengguna yang sedang login)
        $userId = auth()->id();
        
        // Cari atau buat data berdasarkan id_user
        $whatsappNumber = WhatsappNumber::updateOrCreate(
            ['id_user' => $userId], // Kondisi pencarian
            ['no_wa' => $request->no_wa] // Data yang akan diupdate atau dibuat
        );

        // Tampilkan pesan sukses
        if ($whatsappNumber->wasRecentlyCreated) {
            Alert::success('Berhasil', 'Nomor WhatsApp berhasil disimpan.');
            return back();
        } else {
            Alert::success('Berhasil', 'Nomor WhatsApp berhasil diperbarui.');
            return back();
        }
    }
    
}
