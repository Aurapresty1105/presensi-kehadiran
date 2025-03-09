<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ Auth::user()->role }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.css" rel="stylesheet" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <style>
        .profile-circle {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            /* Warna latar belakang */
            color: white;
            /* Warna teks */
            font-weight: bold;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            /* Membuatnya lingkaran */
            text-transform: uppercase;
        }
    </style>
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-smk.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('component.header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('component.sidebar')
            <!-- partial -->
            @yield('content')
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin Ingin Keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih Tombol "Keluar" Untuk Keluar Dari Halaman Ini</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:partials/_footer.html -->
        @include('component.footer')
        @include('sweetalert::alert')

        <!-- partial -->
        <!-- plugins:js -->
        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/js/template.js') }}"></script>
        <script src="{{ asset('assets/js/settings.js') }}"></script>
        <script src="{{ asset('assets/js/todolist.js') }}"></script>
        <script>
            let userName = "{{ Auth::user()->name }}";

            // Fungsi untuk mendapatkan inisial
            function getInitials(name) {
                let nameParts = name.split(" ");
                let initials = nameParts[0][0]; // Ambil huruf pertama dari nama depan

                if (nameParts.length > 1) {
                    initials += nameParts[1][0]; // Ambil huruf pertama dari nama belakang (jika ada)
                }

                return initials.toUpperCase(); // Pastikan inisial selalu huruf besar
            }

            // Update elemen dengan inisial pengguna
            document.getElementById("profile-initial").textContent = getInitials(userName);
        </script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
        @yield('script')
        <!-- End custom js for this page-->
    </div>
</body>

</html>