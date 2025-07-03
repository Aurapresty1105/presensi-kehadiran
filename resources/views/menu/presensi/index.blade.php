@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Tabel Presensi</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($siswa === null)
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <strong>Anda belum terdaftar sebagai siswa.</strong>
                                        </td>
                                    </tr>
                                @else
                                    {{-- Baris Presensi Hari Ini --}}
                                    <tr>
                                        <td>{{ $siswa->user->name }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                                        <td>{{ \Carbon\Carbon::today()->format('Y-m-d') }}</td>

                                        {{-- Kolom Datang --}}
                                        <td>
                                            @if (is_null($presensiHariIni))
                                                <form action="{{ route('presensi.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="waktu" value="waktu_datang">
                                                    <button type="submit" class="btn btn-sm btn-success">Presensi Datang</button>
                                                </form>
                                            @else
                                                {{ $presensiHariIni->waktu_datang ?? '-' }}
                                            @endif
                                        </td>

                                        {{-- Kolom Pulang --}}
                                        <td>
                                            @if (!is_null($presensiHariIni) && !is_null($presensiHariIni->waktu_datang) && is_null($presensiHariIni->waktu_pulang))
                                                <form action="{{ route('presensi.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="waktu" value="waktu_pulang">
                                                    <button type="submit" class="btn btn-sm btn-warning">Presensi Pulang</button>
                                                </form>
                                            @elseif(!is_null($presensiHariIni))
                                                {{ $presensiHariIni->waktu_pulang ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Riwayat Presensi Sebelumnya --}}
                                    @foreach ($riwayatPresensi as $item)
                                        <tr>
                                            <td>{{ $item->siswa->user->name }}</td>
                                            <td>{{ $item->siswa->nis }}</td>
                                            <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->waktu_datang ?? '-' }}</td>
                                            <td>{{ $item->waktu_pulang ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection