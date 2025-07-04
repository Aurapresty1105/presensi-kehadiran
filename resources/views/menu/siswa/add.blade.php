<div class="modal fade" id="addSiswaModal" tabindex="-1" role="dialog" aria-labelledby="addSiswaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSiswaModalLabel">Tambah Siswa</h5>
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
                <form method="POST" action="{{ route('siswa.store') }}" onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_user">Siswa</label>
                                <select class="form-control form-control-sm" name="id_user" id="siswaSelect" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($daftarSiswa as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kelas">Kelas</label>
                                <select class="form-control form-control-sm" name="id_kelas" id="id_kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="form-group">
                            <label for="password">Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <!-- Tombol Submit -->
                    <div class="text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-light btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm mr-2">Tambah</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>