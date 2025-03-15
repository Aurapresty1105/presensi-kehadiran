@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Form Filter -->
            <form action="{{ route('kehadiran2.view') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="kelas">Kelas:</label>
                        <select name="kelas" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('kehadiran2.view') }}" class="btn btn-secondary ml-2">Reset</a>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Tabel Kehadiran</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($presensi->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <strong>Tidak ada data kehadiran yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($presensi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->siswa->user->name }}</td>
                                            <td>{{ $item->siswa->nis }}</td>
                                            <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                            <td>{{ date('d M Y', strtotime($item->tanggal)) }}</td>
                                            <td>{{ date('H:i', strtotime($item->waktu_datang)) }}</td>
                                            <td>
                                                @if ($item->waktu_pulang != NULL)
                                                    {{ date('H:i', strtotime($item->waktu_pulang)) }}
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#addCatatanModal-{{ $item->id }}">
                                                    Tambah
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Tambah Catatan untuk setiap item -->
                                        <div class="modal fade" id="addCatatanModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="addCatatanModalLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addCatatanModalLabel-{{ $item->id }}">Tambah
                                                            Catatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('presensi.updateCatatan', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="catatan">Catatan</label>
                                                                <textarea class="form-control" name="catatan" id="catatan" rows="3"
                                                                    required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
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