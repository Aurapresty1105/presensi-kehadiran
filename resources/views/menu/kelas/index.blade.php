@extends('master')
@section('content')
    @include('menu.kelas.add')
    @include('menu.kelas.edit', ['item' => $kelas])
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addKelasModal">Tambah Kelas</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Manaje Kelas</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Nama</th>
                                    <th class="text-center" style="width: 30%;">Angkatan</th>
                                    <th class="text-right" style="width: 30%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($kelas->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <strong>Tidak ada data kelas yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($kelas as $item)
                                        <tr>
                                            <td>{{ $item->nama_kelas }}</td>
                                            <td class="text-center">{{ $item->angkatan }}</td>
                                            <td class="text-right">
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $item->id }}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editKelasModal{{ $item->id }}">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($kelas->isNotEmpty())
                        <div class="d-flex justify-content-end mt-3">
                            {!! $kelas->links('pagination::bootstrap-4') !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus kelas <strong>{{ $item->nama_kelas }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection