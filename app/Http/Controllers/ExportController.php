<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Presensi;
use RealRashid\SweetAlert\Facades\Alert;

class ExportController extends Controller
{
    public function exportToPdf()
    {
        // Ambil seluruh data presensi dengan relasi siswa
        $presensi = Presensi::with(['siswa.user', 'siswa.kelas'])->get();

        // Periksa apakah data presensi kosong
        if ($presensi->isEmpty()) {
            // Berikan alert atau redirect dengan pesan error
            Alert::error('Peringatan', 'Data presensi masih kosong.');
            return back();
        }

        // Kelompokkan data berdasarkan siswa dan hitung total kehadiran
        $data = $presensi->groupBy('id_siswa')->map(function ($items) {
            return [
                'nama_siswa' => $items->first()->siswa->user->name,
                'kelas' => $items->first()->siswa->kelas->nama_kelas,
                'nis' => $items->first()->siswa->nis,
                'hadir' => $items->where('keterangan_presensi', 'Hadir')->count(),
                'sakit' => $items->where('keterangan_presensi', 'Sakit')->count(),
                'izin' => $items->where('keterangan_presensi', 'Izin')->count(),
                'absen' => $items->where('keterangan_presensi', 'Absen')->count(),
            ];
        })->values();

        // Load view untuk PDF
        $pdf = Pdf::loadView('menu.exports.presensi_pdf', ['data' => $data])
            ->setPaper('a4', 'landscape');

        // Unduh file PDF
        return $pdf->download('data-kehadiran.pdf');
    }
}
