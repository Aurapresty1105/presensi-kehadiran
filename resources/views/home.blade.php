@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Selamat Datang {{ Auth::user()->name}}</h3>
                            @if (Auth::user()->role == 'admin')
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                            @if (Auth::user()->role == 'guru')
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                            @if (Auth::user()->role == 'siswa')
                                <h6 class="font-weight-normal mb-0">Senang anda telah kembali</h6>
                            @endif
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <a href="{{ route('cetak.pdf') }}" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Cetak Data Kehadiran (PDF)
                                    </a>
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
                                        <h4 id="current-month" class="location font-weight-normal">Bangalore</h4>
                                        <h6 id="current-year" class="font-weight-normal">India</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (in_array(Auth::user()->role, ['admin', 'guru']))
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
            @if (in_array(Auth::user()->role, ['admin', 'guru']))
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Tabel Kehadiran</p>

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
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- main-panel ends -->
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