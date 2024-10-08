<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('manup-master/img/logo_UISEB.png') }}" alt="" height="30">
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $active == 'dashboard' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA || Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
        {{-- <li class="nav-item {{ $active == 'registration' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.user') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Registration</span></a>
        </li> --}}
    @endif

    @if (Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN || Auth::user()->type == \App\Models\User::TYPE_ADMIN)
        <li class="nav-item {{ $active == 'editor' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('access.editor') }}">
                <i class="fas fa-arrow-right"></i>
                <span>Akses Editor</span></a>
        </li>
        <li class="nav-item {{ $active == 'reviewer' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('access.reviewer') }}">
                <i class="fas fa-arrow-right"></i>
                <span>Akses Reviewer</span></a>
        </li>
    @endif

    @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN || Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
        <li class="nav-item {{ $active == 'page' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('pages.index') }}">
                <i class="fas fa-fw fa-paste"></i>
                <span>Manajemen Halaman</span></a>
        </li>
        <li class="nav-item {{ $active == 'category' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Manajemen Kategori</span></a>
        </li>
        <li class="nav-item {{ $active == 'user' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Manajemen User</span></a>
        </li>
        <li class="nav-item {{ $active == 'validation' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.validation') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Validasi Pendaftaran</span></a>
        </li>
        {{-- <li class="nav-item {{ $active == 'review' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.reviews') }}">
                <i class="fas fa-fw fa-star"></i>
                <span>Review Paper</span></a>
        </li> --}}
        <li class="nav-item {{ $active == 'published' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('paper.published.review') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Validasi Publikasi</span></a>
        </li>
        <li class="nav-item {{ $active == 'published_history' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('paper.published.history') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>History Publikasi</span></a>
        </li>
        <li class="nav-item {{ $active == 'registration' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.history') }}">
                <i class="fas fa-fw fa-clock"></i>
                <span>Riwayat Pendaftaran</span></a>
        </li>
        <li class="nav-item {{ $active == 'setting' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('settings.edit', 1) }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Pengaturan</span></a>
        </li>
    @endif

    @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
        {{-- <li class="nav-item {{ $active == 'validation' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.validation') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Validasi Pendaftaran</span></a>
        </li> --}}
    @endif

    @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
            Auth::user()->type == \App\Models\User::TYPE_REVIEWER ||
            Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
        {{-- <li class="nav-item {{ $active == 'review' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('registration.reviews') }}">
                <i class="fas fa-fw fa-star"></i>
                <span>Review Paper</span></a>
        </li> --}}
    @endif

    @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
        <li class="nav-item {{ $active == 'signature' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('upload.signature') }}">
                <i class="fas fa-upload"></i>
                <span>Signature</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
