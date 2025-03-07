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
                <div class="col-md-6 grid-margin transparent">
                    <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Today’s Bookings</p>
                                    <p class="fs-30 mb-2">4006</p>
                                    <p>10.00% (30 days)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Total Bookings</p>
                                    <p class="fs-30 mb-2">61344</p>
                                    <p>22.00% (30 days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                    <p class="mb-4">Number of Meetings</p>
                                    <p class="fs-30 mb-2">34040</p>
                                    <p>2.00% (30 days)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 stretch-card transparent">
                            <div class="card card-light-danger">
                                <div class="card-body">
                                    <p class="mb-4">Number of Clients</p>
                                    <p class="fs-30 mb-2">47033</p>
                                    <p>0.22% (30 days)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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