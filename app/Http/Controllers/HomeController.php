<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $filterAngkatan = $request->get('angkatan');

        $presensi_hari_ini = Presensi::whereDate('tanggal', $today)->get();
        $ringkasan_hari_ini = $presensi_hari_ini->countBy('keterangan_presensi');

        // Ambil semua data presensi dengan relasi
        $akumulasi_presensi = Presensi::with(['siswa.user', 'siswa.kelas'])->get();

        // Filter berdasarkan angkatan jika diperlukan
        $filtered_presensi = $akumulasi_presensi->filter(function ($item) use ($filterAngkatan) {
            return !$filterAngkatan || $item->siswa->kelas->angkatan == $filterAngkatan;
        });

        // Proses akumulasi per siswa
        $collection = $filtered_presensi->groupBy('id_siswa')->map(function ($items) {
            return (object) [
                'siswa' => $items->first()->siswa,
                'hadir' => $items->where('keterangan_presensi', 'Hadir')->count(),
                'sakit' => $items->where('keterangan_presensi', 'Sakit')->count(),
                'izin' => $items->where('keterangan_presensi', 'Izin')->count(),
                'absen' => $items->where('keterangan_presensi', 'Absen')->count(),
            ];
        })->values(); // penting untuk pagination

        // Simulasikan pagination manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $collection->forPage($currentPage, $perPage);

        $akumulasi = new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $angkatanList = Kelas::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');

        $userId = auth()->id();
        $siswa = Siswa::where('id_user', $userId)->first();

        if (!$siswa) {
            return view('home', [
                'presensi' => null,
                'hadir_hari_ini' => $ringkasan_hari_ini['Hadir'] ?? 0,
                'izin_hari_ini' => $ringkasan_hari_ini['Izin'] ?? 0,
                'sakit_hari_ini' => $ringkasan_hari_ini['Sakit'] ?? 0,
                'absen_hari_ini' => $ringkasan_hari_ini['Absen'] ?? 0,
                'akumulasi' => $akumulasi,
                'akumulasi_hadir' => 0,
                'akumulasi_sakit' => 0,
                'akumulasi_izin' => 0,
                'akumulasi_absen' => 0,
                'angkatanList' => $angkatanList,
                'filterAngkatan' => $filterAngkatan,
            ]);
        }

        $presensi_siswa = Presensi::where('id_siswa', $siswa->id)->latest()->get();
        $akumulasi_siswa = $presensi_siswa->countBy('keterangan_presensi');

        return view('home', [
            'presensi' => $presensi_siswa,
            'hadir_hari_ini' => $ringkasan_hari_ini['Hadir'] ?? 0,
            'izin_hari_ini' => $ringkasan_hari_ini['Izin'] ?? 0,
            'sakit_hari_ini' => $ringkasan_hari_ini['Sakit'] ?? 0,
            'absen_hari_ini' => $ringkasan_hari_ini['Absen'] ?? 0,
            'akumulasi' => $akumulasi,
            'akumulasi_hadir' => $akumulasi_siswa['Hadir'] ?? 0,
            'akumulasi_sakit' => $akumulasi_siswa['Sakit'] ?? 0,
            'akumulasi_izin' => $akumulasi_siswa['Izin'] ?? 0,
            'akumulasi_absen' => $akumulasi_siswa['Absen'] ?? 0,
            'angkatanList' => $angkatanList,
            'filterAngkatan' => $filterAngkatan,
        ]);
    }


}
