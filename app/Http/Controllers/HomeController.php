<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini

        // Ambil semua data presensi untuk keperluan admin
        $presensi_hari_ini = Presensi::whereDate('tanggal', $today)->get();

        // Hitung akumulasi presensi hari ini untuk admin
        $ringkasan_hari_ini = $presensi_hari_ini->countBy('keterangan_presensi');

        // Ambil seluruh data presensi dengan relasi siswa dan user (untuk admin)
        $akumulasi_presensi = Presensi::with(['siswa.user', 'siswa.kelas'])->get();

        // Kelompokkan data berdasarkan siswa dan hitung total kehadiran
        $akumulasi = $akumulasi_presensi->groupBy('id_siswa')->map(function ($items) {
            return (object) [
                'siswa' => $items->first()->siswa,
                'hadir' => $items->where('keterangan_presensi', 'Hadir')->count(),
                'sakit' => $items->where('keterangan_presensi', 'Sakit')->count(),
                'izin' => $items->where('keterangan_presensi', 'Izin')->count(),
                'absen' => $items->where('keterangan_presensi', 'Absen')->count(),
            ];
        });

        // Ambil data siswa berdasarkan user yang login (untuk siswa)
        $userId = auth()->id(); // Lebih singkat daripada auth()->user()->id
        $siswa = Siswa::where('id_user', $userId)->first();

        // Jika siswa tidak ditemukan, langsung return view dengan nilai default
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
            ]);
        }

        // Ambil data presensi siswa yang login
        $presensi_siswa = Presensi::where('id_siswa', $siswa->id)->latest()->get();

        // Hitung akumulasi presensi siswa yang login
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
        ]);
    }
}
