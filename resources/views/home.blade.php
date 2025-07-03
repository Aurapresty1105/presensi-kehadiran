@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Selamat Datang {{ Auth::user()->name}}</h3>
                            @if (in_array(Auth::user()->role, ['admin', 'kepsek']))
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                            @if (Auth::user()->role == 'guru')
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                            @if (Auth::user()->role == 'siswa')
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                        </div>
                        @if (in_array(Auth::user()->role, ['admin', 'kepsek']))
                            <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                        data-target="#modalFilterBulan">
                                        <i class="fas fa-calendar-alt"></i> Cetak Data per Bulan
                                    </button>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card tale-bg">
                        <div class="card-people mt-auto">
                            <img src="{{ asset('assets/images/dashboard/people.svg') }}" alt="people">
                            <div class="weather-info">
                                <div class="d-flex">
                                    <div>
                                        <h2 id="current-date" class="mb-0 font-weight-normal"><i
                                                class="ti-calendar mr-2"></i></h2>
                                    </div>
                                    <div class="ml-2">
                                        <h4 id="current-month" class="location font-weight-normal"></h4>
                                        <h6 id="current-year" class="font-weight-normal"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (in_array(Auth::user()->role, ['admin', 'guru', 'kepsek']))
                    <div class="col-md-6 grid-margin transparent">
                        <div class="row">
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-tale">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Hadir Hari Ini</p>
                                        <p class="fs-30 mb-2">{{$hadir_hari_ini}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Sakit Hari Ini</p>
                                        <p class="fs-30 mb-2">{{$sakit_hari_ini}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                <div class="card card-light-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Izin Hari Ini</p>
                                        <p class="fs-30 mb-2">{{$izin_hari_ini}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 stretch-card transparent">
                                <div class="card card-light-danger">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Absen Hari Ini</p>
                                        <p class="fs-30 mb-2">{{$absen_hari_ini}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->role == 'siswa')
                    <div class="col-md-6 grid-margin transparent">
                        <div class="row">
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-tale">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Hadir</p>
                                        <p class="fs-30 mb-2">{{$akumulasi_hadir}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Sakit</p>
                                        <p class="fs-30 mb-2">{{$akumulasi_sakit}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                <div class="card card-light-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Izin</p>
                                        <p class="fs-30 mb-2">{{$akumulasi_izin}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 stretch-card transparent">
                                <div class="card card-light-danger">
                                    <div class="card-body">
                                        <p class="mb-4">Jumlah Absen</p>
                                        <p class="fs-30 mb-2">{{$akumulasi_absen}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @if (in_array(Auth::user()->role, ['admin', 'guru', 'kepsek']))
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Tabel Rekapitulasi Kehadiran</h5>
                            <form method="GET" action="{{ route('home') }}" class="form-inline">
                                <div class="form-group mr-2">
                                    <label for="angkatan" class="mr-2">Angkatan:</label>
                                    <select name="angkatan" id="angkatan" class="form-control">
                                        <option value="">-- Semua Angkatan --</option>
                                        @foreach ($angkatanList as $angkatan)
                                            <option value="{{ $angkatan }}" {{ $filterAngkatan == $angkatan ? 'selected' : '' }}>
                                                {{ $angkatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Terapkan</button>
                                @if ($filterAngkatan)
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                                @endif
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Hadir</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Absen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($akumulasi->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <strong>Tidak ada data kehadiran yang tersedia.</strong>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($akumulasi as $data)
                                            <tr>
                                                <td>{{ $data->siswa->user->name }}</td>
                                                <td>{{ $data->siswa->nis }}</td>
                                                <td>{{ $data->siswa->kelas->nama_kelas }}</td>
                                                <td>{{ $data->hadir }}</td>
                                                <td>{{ $data->sakit }}</td>
                                                <td>{{ $data->izin }}</td>
                                                <td>{{ $data->absen }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
    {{ $akumulasi->links('pagination::bootstrap-4') }}
</div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- main-panel ends -->

        <!-- Modal Filter Bulan untuk Ekspor PDF -->
        <div class="modal fade" id="modalFilterBulan" tabindex="-1" role="dialog" aria-labelledby="modalFilterBulanLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('cetak.pdf') }}" method="GET" target="_blank">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFilterBulanLabel">Pilih Bulan untuk Ekspor PDF</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="bulan">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-control" required>
                                    @php
                                        $currentYear = now()->year;
                                    @endphp
                                    @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Cetak PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        const today = new Date();
        let date = today.getDate();
        const month = today.toLocaleString('default', { month: 'long' }); // Nama bulan
        const year = today.getFullYear();

        // Ubah tanggal menjadi dua digit (misalnya: 01, 02, ..., 09, 10, 11, ...)
        date = date < 10 ? '0' + date : date;

        // Update elemen dengan nilai yang sesuai
        document.getElementById("current-date").innerHTML += date;
        document.getElementById("current-month").textContent = month;
        document.getElementById("current-year").textContent = year;
    </script>
@endsection