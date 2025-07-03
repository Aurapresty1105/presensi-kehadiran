<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('user.store') }}" onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name"
                                    placeholder="Nama" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email"
                                    placeholder="Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" name="username"
                                    placeholder="Username" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password"
                                    name="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control form-control-sm" name="role" id="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                    <option value="admin">Admin</option>
                                    <option value="kepsek">Kepala Sekolah</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis">
                                <small>*Hanya untuk role siswa</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="text-right">
                        <a href="#" class="btn btn-light btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm mr-2">Tambah</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        function validateForm() {
            let role = document.getElementById("role").value;
            if (role !== "guru" && role !== "siswa" && role !== "admin" && role !== "kepsek") {
                alert("Harap pilih role yang valid (Guru, Siswa, Admin, atau Kepsek)!");
                return false;
            }
            return true;
        }
    </script>
@endsection