<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index_kehadiran()
    {
        $presensi = Presensi::all();
        return view('menu.kehadiran.index', compact('presensi'));
    }
    public function index_presensi()
    {
        $userId = auth()->user()->id; // Sesuaikan dengan sumber ID siswa
        $siswa = Siswa::where('id_user', $userId)->first();
        $siswaId = $siswa->id;
        $presensi = Presensi::where('id_siswa', $siswaId)->get();
        return view('menu.presensi.index', compact('presensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waktu' => 'required|in:waktu_datang,waktu_pulang',
        ]);

        $userId = auth()->user()->id; // Sesuaikan dengan sumber ID siswa
        $siswa = Siswa::where('id_user', $userId)->first();
        $siswaId = $siswa->id;
        $tanggalHariIni = Carbon::today()->toDateString();

        if ($request->waktu == 'waktu_datang') {
            // Cek apakah siswa sudah presensi datang hari ini
            $cekPresensi = Presensi::where('id_siswa', $siswaId)
                ->where('tanggal', $tanggalHariIni)
                ->first();

            if ($cekPresensi) {
                return back()->with('error', 'Anda sudah melakukan presensi datang hari ini.');
            }

            // Buat presensi baru
            Presensi::create([
                'id_siswa' => $siswaId,
                'tanggal' => $tanggalHariIni,
                'waktu_datang' => Carbon::now()->toTimeString(),
                'keterangan_presensi' => 'Hadir',
                'catatan' => $request->catatan ?? null, // Bisa diisi atau dikosongkan
            ]);

            return back()->with('success', 'Presensi datang berhasil ditambahkan.');
        } elseif ($request->waktu == 'waktu_pulang') {
            // Update waktu pulang pada presensi yang sudah ada
            $presensi = Presensi::where('id_siswa', $siswaId)
                ->where('tanggal', $tanggalHariIni)
                ->first();

            if ($presensi) {
                $presensi->update([
                    'waktu_pulang' => Carbon::now()->toTimeString(),
                ]);
                return back()->with('success', 'Presensi pulang berhasil diperbarui.');
            } else {
                return back()->with('error', 'Tidak ditemukan presensi datang untuk hari ini.');
            }
        }
    }
}
