@extends('master')
@section('content')
    @include('menu.user.add')
    @include('menu.user.edit', ['item' => $user])
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Tambah User</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Manage User</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($user->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <strong>Tidak ada data user yang tersedia.</strong>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td class="font-weight-medium">
                                                <div
                                                    class="badge {{ $item->role == 'guru' ? 'badge-secondary' : ($item->role == 'siswa' ? 'badge-success' : 'badge-secondary') }}">
                                                    {{ $item->role }}
                                                </div>
                                            </td>
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
                                        <!-- modal delete -->
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
                                                        <p>Apakah Anda yakin ingin menghapus user <strong>{{ $item->name }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST">
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

                    @if ($user->isNotEmpty())
                        <div class="d-flex justify-content-end mt-3">
                            {!! $user->links('pagination::bootstrap-4') !!}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection