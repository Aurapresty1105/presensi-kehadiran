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
                <form method="POST" action="#" onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Siswa</label>
                                <select class="form-control form-control-sm" name="role" id="role" required>
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
                                <label for="role">Kelas</label>
                                <select class="form-control form-control-sm" name="role" id="role" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- NIS -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control form-control-sm" id="nis" name="nis"
                                    placeholder="NIS" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
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