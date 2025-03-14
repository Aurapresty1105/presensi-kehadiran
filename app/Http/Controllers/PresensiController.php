<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class PresensiController extends Controller
{
    public function index_kehadiran(Request $request)
    {
        $query = Presensi::query();

        // Ambil tanggal hari ini jika tidak ada filter tanggal
        $tanggalHariIni = date('Y-m-d');
        $tanggalFilter = $request->filled('tanggal') ? $request->tanggal : $tanggalHariIni;

        // Filter berdasarkan tanggal (default hari ini jika tidak difilter)
        $query->whereDate('created_at', $tanggalFilter);

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->kelas);
            });
        }

        $presensi = $query->latest()->get();
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        return view('menu.kehadiran.index', compact('presensi', 'kelas', 'siswa'));
    }
    public function index_presensi()
    {
        $userId = auth()->user()->id; // Sesuaikan dengan sumber ID siswa
        $siswa = Siswa::where('id_user', $userId)->first();
        $siswaId = $siswa->id;
        $presensi = Presensi::where('id_siswa', $siswaId)->latest()->get();
        return view('menu.presensi.index', compact('presensi'));
    }

    public function kehadiran(Request $request)
    {
        $query = Presensi::query();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->kelas);
            });
        }

        $presensi = $query->latest()->get();
        $kelas = Kelas::all();

        return view('menu.kehadiran.index_guru', compact('presensi', 'kelas'));
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
                Alert::info('Peringatan', 'Anda sudah melakukan presensi datang hari ini');
                return back();
            }

            // Buat presensi baru
            Presensi::create([
                'id_siswa' => $siswaId,
                'tanggal' => $tanggalHariIni,
                'waktu_datang' => Carbon::now()->toTimeString(),
                'keterangan_presensi' => 'Hadir',
                'catatan' => $request->catatan ?? null, // Bisa diisi atau dikosongkan
            ]);

            Alert::success('Berhasil', 'Berhasil melakukan presensi datang');
            return back();
        } elseif ($request->waktu == 'waktu_pulang') {
            // Update waktu pulang pada presensi yang sudah ada
            $presensi = Presensi::where('id_siswa', $siswaId)
                ->where('tanggal', $tanggalHariIni)
                ->first();

            if ($presensi) {
                $presensi->update([
                    'waktu_pulang' => Carbon::now()->toTimeString(),
                ]);

                Alert::success('Berhasil', 'Berhasil melakukan presensi pulang');
                return back();
            } else {
                Alert::info('Peringatan', 'Anda perlu melakukan presensi datang terlebih dahulu');
                return back();
            }
        }
    }

    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Cari data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($id);

        // Update catatan
        $presensi->update([
            'catatan' => $request->catatan,
        ]);

        Alert::success('Berhasil', 'Catatan berhasil diperbarui');
        return back();
    }

    public function updateKeterangan(Request $request)
    {
        $presensi = Presensi::findOrFail($request->id);
        $presensi->keterangan_presensi = $request->keterangan_presensi;
        $presensi->save();

        Alert::success('Berhasil', 'Keterangan berhasil diperbarui');
        return back();
    }
    public function store_kehadiran(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'keterangan_presensi' => 'required',
        ]);
        $tanggalHariIni = Carbon::today()->toDateString();

        // Buat presensi baru
        Presensi::create([
            'id_siswa' => $request->id_siswa,
            'tanggal' => $tanggalHariIni,
            'waktu_datang' => 'null',
            'keterangan_presensi' => $request->keterangan_presensi,
            'catatan' => null, // Bisa diisi atau dikosongkan
        ]);

        Alert::success('Berhasil', 'Berhasil menambahka data kehadiran');
        return back();
    }

}
