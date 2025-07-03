<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Presensi;
use RealRashid\SweetAlert\Facades\Alert;

class ExportController extends Controller
{
    public function exportToPdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Validasi input bulan dan tahun
        if (!$bulan || !$tahun) {
            Alert::error('Peringatan', 'Bulan dan tahun harus dipilih.');
            return back();
        }

        // Ambil data presensi berdasarkan bulan dan tahun yang dipilih
        $presensi = Presensi::with(['siswa.user', 'siswa.kelas'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Periksa apakah data presensi kosong
        if ($presensi->isEmpty()) {
            Alert::error('Peringatan', 'Data presensi untuk bulan dan tahun yang dipilih masih kosong.');
            return back();
        }

        // Kelompokkan dan rekap data
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

        // Format nama file PDF
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $namaFile = "data-kehadiran-{$namaBulan}-{$tahun}.pdf";

        // Load view dan buat PDF
        $pdf = Pdf::loadView('menu.exports.presensi_pdf', [
            'data' => $data,
            'bulan' => $namaBulan,
            'tahun' => $tahun,
        ])->setPaper('a4', 'landscape');

        // Unduh file PDF
        return $pdf->download($namaFile);
    }

}
