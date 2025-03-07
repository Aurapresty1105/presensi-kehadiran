<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <!-- Admin -->
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="ti-id-badge menu-icon"></i>
                    <span class="menu-title">Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="ti-clipboard menu-icon"></i>
                    <span class="menu-title">Kehadiran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="ti-ruler-pencil menu-icon"></i>
                    <span class="menu-title">Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.view') }}">
                    <i class="ti-user menu-icon"></i>
                    <span class="menu-title">User</span>
                </a>
            </li>
        @endif
        <!-- Guru -->
        @if (Auth::user()->role == 'guru')
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="ti-clipboard menu-icon"></i>
                    <span class="menu-title">Rekap Kehadiran</span>
                </a>
            </li>
        @endif
        <!-- Siswa -->
        @if (Auth::user()->role == 'siswa')
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="ti-clipboard menu-icon"></i>
                    <span class="menu-title">Presensi</span>
                </a>
            </li>
        @endif
    </ul>
</nav>