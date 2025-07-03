@foreach ($kelas as $item)
    <div class="modal fade" id="editKelasModal{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editKelasModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKelasModalLabel{{ $item->id }}">Formulir Edit Data Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('kelas.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas"
                                value="{{ $item->nama_kelas }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_angkatan">Angkatan</label>
                            <input type="text" class="form-control" id="edit_angkatan" name="angkatan"
                                value="{{ $item->angkatan }}" required>
                        </div>
                        <!-- Tombol Submit -->
                        <div class="text-right">
                            <a href="#" data-dismiss="modal" class="btn btn-light btn-sm">Batal</a>
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
