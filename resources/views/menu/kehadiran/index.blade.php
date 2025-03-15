@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
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
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Absen</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($presensi->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <strong>Tidak ada data kehadiran yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($presensi as $item)
                                        <tr>
                                            <td>{{ $item->siswa->user->name }}</td>
                                            <td>{{ $item->siswa->nis }}</td>
                                            <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                            <td>{{ $item->siswa->id }}</td>
                                            <td>{{ $item->siswa->id }}</td>
                                            <td>{{ $item->siswa->id }}</td>
                                            <td>{{ $item->siswa->id }}</td>
                                            <td>{{ $item->catatan }}</td>
                                        </tr>
                                        <!-- modal delete -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi
                                                            Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus kelas
                                                            <strong>{{ $item->nama_kelas }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('kelas.destroy', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('GET')
                                                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
@endsection