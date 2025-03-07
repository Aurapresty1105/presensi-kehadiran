@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Formulir Edit Data User</h4>
                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ $user->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-right">
                            <a href="{{ route('user.view') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
