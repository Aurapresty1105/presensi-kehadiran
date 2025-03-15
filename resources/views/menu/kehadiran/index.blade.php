@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <form action="{{ route('kehadiran.view') }}" method="GET" class="mb-3">
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
                        <a href="{{ route('kehadiran.view') }}" class="btn btn-secondary ml-2">Reset</a>
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
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Keterangan</th>
                                    <th>Lihat</th>
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
                                            <td>{{ $item->siswa->user->name }} ({{date('H:i', strtotime($item->waktu_datang)) }} -
                                                {{ date('H:i', strtotime($item->waktu_pulang))  }})
                                            </td>
                                            <td>{{ $item->siswa->nis }}</td>
                                            <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                            <td>
                                                <span class="badge badge-pill 
                                                    {{ $item->keterangan_presensi == 'Hadir' ? 'badge-primary' : '' }}
                                                    {{ $item->keterangan_presensi == 'Sakit' ? 'badge-secondary' : '' }}
                                                    {{ $item->keterangan_presensi == 'Izin' ? 'badge-info' : '' }}
                                                    {{ $item->keterangan_presensi == 'Absen' ? 'badge-danger' : '' }}">
                                                    {{ $item->keterangan_presensi }}
                                                </span>
                                                <button class="btn btn-sm btn-outline-secondary edit-status" data-id="{{ $item->id }}">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                                <select class="form-control form-control-sm change-status d-none" data-id="{{ $item->id }}">
                                                    <option value="Hadir" {{ $item->keterangan_presensi == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="Sakit" {{ $item->keterangan_presensi == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                                    <option value="Izin" {{ $item->keterangan_presensi == 'Izin' ? 'selected' : '' }}>Izin</option>
                                                    <option value="Absen" {{ $item->keterangan_presensi == 'Absen' ? 'selected' : '' }}>Absen</option>
                                                </select>
                                            </td>
                                            <td>
                                                @if ($item->catatan != NULL)
                                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                        data-target="#lihatCatatanModal-{{ $item->id }}">
                                                        <i class="ti-eye"></i>
                                                    </button>
                                                @elseif($item->catatan == NULL)
                                                    <button class="btn btn-outline-primary btn-sm" disabled>
                                                        <i class="ti-eye"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- modal lihat -->
                                        <div class="modal fade" id="lihatCatatanModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="lihatCatatanModalLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="lihatCatatanModalLabel-{{ $item->id }}"> {{ $item->siswa->user->name }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="catatan">Catatan</label>
                                                            <textarea class="form-control" name="catatan" disabled>{{ old('catatan', $item->catatan) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
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
@section('script')
<script>
    $(document).ready(function() {
        $('.edit-status').click(function() {
            var parentTd = $(this).closest('td');
            parentTd.find('.badge').addClass('d-none'); // Sembunyikan badge
            $(this).addClass('d-none'); // Sembunyikan ikon edit
            parentTd.find('.change-status').removeClass('d-none').focus(); // Tampilkan dropdown
        });

        $('.change-status').change(function() {
            var presensiId = $(this).data('id');
            var newStatus = $(this).val();
            var parentTd = $(this).closest('td');

            $.ajax({
                url: "{{ route('kehadiran.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: presensiId,
                    keterangan_presensi: newStatus
                },
                success: function(response) {
                    var badgeClass = 'badge-primary';
                    if (newStatus == 'Sakit') badgeClass = 'badge-secondary';
                    else if (newStatus == 'Izin') badgeClass = 'badge-info';
                    else if (newStatus == 'Absen') badgeClass = 'badge-danger';

                    var newBadge = `<span class="badge badge-pill ${badgeClass}">${newStatus}</span>`;

                    parentTd.find('.change-status').addClass('d-none'); // Sembunyikan dropdown
                    parentTd.find('.edit-status').removeClass('d-none'); // Tampilkan ikon edit
                    parentTd.find('.badge').replaceWith(newBadge); // Ganti badge dengan yang baru

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Keterangan kehadiran telah diperbarui.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                    });
                }
            });
        });
    });
</script>

@endsection