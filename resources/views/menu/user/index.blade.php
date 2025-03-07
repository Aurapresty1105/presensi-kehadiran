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
                                                <!-- Tombol Hapus dengan SweetAlert -->
                                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                                    <i class="ti-trash"></i>
                                                </button>

                                                <!-- Form Hapus (Hidden) -->
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('GET')
                                                </form>
                                                <a href="{{ route('user.edit', $item->id) }}" class="btn btn-info btn-sm">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination -->
                    @if ($user->isNotEmpty())
                        <div class="d-flex justify-content-end mt-3">
                            {!! $user->links('pagination::bootstrap-4') !!}
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
@section('script')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

@endsection