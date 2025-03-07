@extends('master')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('user.add') }}" class="btn btn-primary">Tambah User</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title mb-0">Manaje User</p>
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
                                            <a href="" class="btn btn-danger btn-sm">
                                                <i class="ti-trash"></i>
                                            </a>
                                            <a href="" class="btn btn-info btn-sm">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {!! $user->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
@endsection