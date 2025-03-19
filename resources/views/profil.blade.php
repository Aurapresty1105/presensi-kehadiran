@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Profil Pengguna</p>
                    <div id="initial" style="width: 100px;
                                                                height: 100px;
                                                                border-radius: 50%;
                                                                background-color: #007BFF;
                                                                color: white;
                                                                font-size: 32px;
                                                                font-weight: bold;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;
                                                                margin: 20px auto;"></div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        @if (in_array(Auth::user()->role, ['admin', 'guru']))
                            <div class="row">
                                <!-- Nama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                                            value="{{ $user->name }}" disabled>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control form-control-sm" id="username" name="username"
                                            value="{{ $user->username }}" disabled>
                                    </div>
                                </div>
                                <!-- Role -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" class="form-control form-control-sm" id="role" name="role"
                                            value="{{ $user->role }}" disabled>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->role == 'admin')
                                <form action="{{ route('profil.store') }}" method="POST">
                                    @csrf
                                    <div class="row"> <!-- Whatsapp -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="whatsapp">Whatsapp</label>
                                                <input type="text" class="form-control form-control-sm" id="whatsapp" name="whatsapp"
                                                    value="{{ $wa->no_wa }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="no_wa">Input Nomor Whatsapp</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm" id="no_wa" name="no_wa"
                                                        placeholder="Masukkan No Whatsapp">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            @endif
                        @endif
                        @if (Auth::user()->role == 'siswa')
                            <div class="row">
                                <!-- Nama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                                            value="{{ $siswa->user->name }}" disabled>
                                    </div>
                                </div>
                                <!-- NIS -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="text" class="form-control form-control-sm" id="nis" name="nis"
                                            value="{{ $siswa->nis }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Kelas -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Kelas</label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                                            value="{{ $siswa->kelas->nama_kelas }}" disabled>
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <input type="text" class="form-control form-control-sm" id="jenis_kelamin"
                                            name="jenis_kelamin"
                                            value="{{ $siswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control form-control-sm" id="username" name="username"
                                            value="{{ $siswa->user->username }}" disabled>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                            value="{{ $siswa->user->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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

            // Update elemen dengan inisial pengguna jika elemen ditemukan
            let profileInitialElement = document.getElementById("initial");
            if (profileInitialElement) {
                profileInitialElement.textContent = getInitials(userName);
            }
        });
    </script>

@endsection