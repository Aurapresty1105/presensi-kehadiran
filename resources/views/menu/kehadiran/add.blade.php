<div class="modal fade" id="addKehadiranModal" tabindex="-1" role="dialog" aria-labelledby="addKehadiranModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKehadiranModalLabel">Tambah Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kehadiran.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="id_siswa">Nama</label>
                        <select class="form-control" name="id_siswa" id="id_siswa">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_presensi">Keterangan</label>
                        <select class="form-control" name="keterangan_presensi" id="keterangan_presensi">
                            <option value="">-- Pilih Keterangan --</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Absen">Absen</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>