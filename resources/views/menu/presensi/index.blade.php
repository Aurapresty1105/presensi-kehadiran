@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addPresensiModal">Tambah Presensi</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Tabel Kehadiran</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($presensi->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <strong>Tidak ada data kehadiran yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($presensi as $item)
                                        <tr>
                                            <td>{{ $item->siswa->user->name }}</td>
                                            <td>{{ $item->siswa->nis }}</td>
                                            <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->waktu_datang }}</td>
                                            <td>{{ $item->waktu_pulang }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <!-- Modal Tambah Presensi -->
                <div class="modal fade" id="addPresensiModal" tabindex="-1" role="dialog"
                    aria-labelledby="addPresensiModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPresensiModalLabel">Tambah Presensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('presensi.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="kelas">Pilih Waktu</label>
                                        <select class="form-control" name="waktu" id="waktu">
                                            <option value="">-- Pilih Waktu --</option>
                                            <option value="waktu_datang">Datang</option>
                                            <option value="waktu_pulang">Pulang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection