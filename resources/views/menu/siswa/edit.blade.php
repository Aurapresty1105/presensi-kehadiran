@foreach ($siswa as $siswaItem)
    <div class="modal fade" id="editSiswaModal{{ $siswaItem->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editSiswaModalLabel{{ $siswaItem->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSiswaModalLabel{{ $siswaItem->id }}">Formulir Edit Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('siswa.update', $siswaItem->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Nama Siswa -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_user">Siswa</label>
                                    <select class="form-control form-control-sm" name="id_user" required>
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($daftarSiswa as $userItem)
                                            <option value="{{ $userItem->id }}" 
                                                {{ $userItem->id == $siswaItem->id_user ? 'selected' : '' }}>
                                                {{ $userItem->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Kelas -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_kelas">Kelas</label>
                                    <select class="form-control form-control-sm" name="id_kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelas as $kelasItem)
                                            <option value="{{ $kelasItem->id }}" 
                                                {{ $kelasItem->id == $siswaItem->id_kelas ? 'selected' : '' }}>
                                                {{ $kelasItem->nama_kelas }}
                                            </option>
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
                                    <input type="text" class="form-control" name="nis" value="{{ $siswaItem->nis }}" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="L" {{ $siswaItem->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ $siswaItem->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
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
@endforeach
