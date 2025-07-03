@foreach ($user as $item)
    <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editUserModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel{{ $item->id }}">Formulir Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('user.update', $item->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        value="{{ $item->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-sm" name="email"
                                        value="{{ $item->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control form-control-sm" name="username"
                                        value="{{ $item->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control form-control-sm" name="password">
                                    <small class="form-text text-muted" style="font-size: 0.75rem;">Kosongkan jika tidak
                                        ingin mengubah
                                        password.</small>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control form-control-sm" name="role" required>
                                        <option value="siswa" {{ $item->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        <option value="guru" {{ $item->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="kepsek" {{ $item->role == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" value="{{ $item->nis}}">
                                    <small>*Hanya untuk role siswa</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach