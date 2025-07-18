@extends('master')
@section('content')
    @include('menu.siswa.add')
    @include('menu.siswa.edit', ['item' => $siswa])
    <div class="main-panel">
        <div class="content-wrapper">
            @if (Auth::user()->role == 'admin')
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addSiswaModal">Tambah Siswa</button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Manage Siswa</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    @if (Auth::user()->role == 'admin')
                                        <th colspan="2">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($siswa->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <strong>Tidak ada data siswa yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                @if($item->jenis_kelamin === 'P')
                                                    Perempuan
                                                @elseif($item->jenis_kelamin === 'L')
                                                    Laki-laki
                                                @endif
                                            </td>
                                            <td>{{ $item->kelas->nama_kelas }}</td>
                                            <td>{{ $item->nis }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal{{ $item->id }}">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editSiswaModal{{ $item->id }}">
                                                        <i class="ti-pencil"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>

                                        @if (Auth::user()->role == 'admin')
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
                                                            <p>Apakah Anda yakin ingin menghapus siswa
                                                                <strong>{{ $item->user->name }}</strong>?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-dismiss="modal">Batal</button>
                                                            <form action="{{ route('siswa.destroy', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('GET')
                                                                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($siswa->isNotEmpty())
                        <div class="d-flex justify-content-end mt-3">
                            {!! $siswa->links('pagination::bootstrap-4') !!}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        new TomSelect("#siswaSelect", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>

@endsection