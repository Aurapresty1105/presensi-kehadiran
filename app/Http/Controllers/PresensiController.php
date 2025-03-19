<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\WhatsappNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class PresensiController extends Controller
{
    public function index_kehadiran(Request $request)
    {
        // Query dasar untuk presensi
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

        // Ambil data presensi terbaru
        $presensi = $query->latest()->get();

        // Proses setiap item presensi untuk memecah catatan menjadi array
        $presensi->each(function ($item) {
            $item->formatted_catatan = !empty($item->catatan)
                ? explode("; ", $item->catatan) // Pisahkan berdasarkan "; "
                : [];
        });

        // Ambil data tambahan untuk dropdown/filter
        $kelas = Kelas::all();
        $siswa = Siswa::all();

        // Kirim data ke view
        return view('menu.kehadiran.index', compact('presensi', 'kelas', 'siswa'));
    }
    public function index_presensi()
    {
        $userId = auth()->user()->id; // Sesuaikan dengan sumber ID siswa
        $siswa = Siswa::where('id_user', $userId)->first();
        if (!$siswa) {
            return view('menu.presensi.index', ['presensi' => null]);
        }
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

        $presensi = $query->latest()->paginate(25);
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
        // Validasi input
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Cari data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($id);
        $siswa = $presensi->siswa->user->name;

        // Aktor (pengguna yang sedang login)
        $aktor = auth()->user()->name;

        // Ambil catatan lama dari database
        $catatanLama = $presensi->catatan ?? ''; // Jika catatan lama kosong, gunakan string kosong

        // Format catatan baru: tambahkan catatan lama jika ada, lalu sambungkan dengan catatan baru
        $catatanBaru = trim($catatanLama) !== ''
            ? $catatanLama . "; " . $request->catatan . " (" . $aktor . ")"
            : $request->catatan . " (" . $aktor . ")";

        // Update catatan di database
        $presensi->update([
            'catatan' => $catatanBaru,
        ]);

        // Mengirim OTP menggunakan cURL
        $adminId = User::where('role', 'admin')->first();
        $whatsapp = WhatsappNumber::where('id_user', $adminId->id)->first();
        $number = $whatsapp->no_wa;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $number,
                'message' => 'Ada catatan untuk: ' . $siswa . ' ' . $catatanBaru,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: nctHnWs9PbWxxxgDPx4M'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Tampilkan pesan sukses
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
