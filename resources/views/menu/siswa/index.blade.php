@extends('master')
@section('content')
    @include('menu.siswa.add')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addSiswaModal">Tambah Siswa</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Manaje SIswa</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($siswa->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <strong>Tidak ada data user yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->kelas->nama_kelas }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $item->id }}">
                                                    <i class="ti-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editUserModal{{ $item->id }}">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
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