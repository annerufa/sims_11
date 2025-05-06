{{-- ambil data role dan route --}}
@php
    $role = auth()->user()->jabatan; // misalnya 'admin' atau 'kepala_sekolah'
    $current = request()->route()->getName(); // nama route saat ini
@endphp


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo kecil.png') }}" style="width: 80%;padding-left: 20%;">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ $current === 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                <!-- <span class="badge rounded-pill bg-danger ms-auto">5</span> -->
            </a>
        </li>

        <!-- Apps & Pages -->
        {{-- @if ($role === 'admin') --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Managemen Surat</span>
        </li>
        {{-- @endif --}}
        {{-- @if ($role === 'ks' || $role === 'admin') --}}
        <li class="menu-item {{ is_active_url(['surat-masuk', 'surat-masuk/*']) }}">
            <a href="{{ route('surat-masuk.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div class="text-truncate">Surat Masuk</div>
                @if ($role === 'ks')
                    @if ($unreadData > 0)
                        {{-- <span class="badge"></span> --}}
                        <span class="badge rounded-pill bg-danger ms-auto">{{ $unreadData }}</span>
                    @endif
                @endif
                <!-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> -->
            </a>
        </li>
        {{-- @endif --}}
        @if ($role !== 'admin')
            <li class="menu-item">
                <a href="{{ route('disposisi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-run"></i>
                    <div class="text-truncate">Disposisi</div>
                </a>
            </li>
        @endif
        @if ($role !== 'ks' && $role !== 'admin')
            <li class="menu-item {{ is_active_url(['validasi-surat', 'setujui', 'revisi']) }}">
                <a href="{{ route('validasi-surat') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-run"></i>
                    <div class="text-truncate">Validasi Surat Keluar</div>
                </a>
            </li>
        @endif
        <li class="menu-item {{ is_active_url(['surat-keluar', 'surat-keluar/*']) }}">
            <a href="{{ route('surat-keluar.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-mail-send"></i>
                <div class="text-truncate">Surat Keluar</div>
                {{-- <span class="badge rounded-pill bg-danger ms-auto">5</span> --}}
                <!-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> -->
            </a>
        </li>
        @if ($role === 'admin')
            <li class="menu-item {{ is_active_url(['agenda', 'agenda/*']) }}">
                <a href="{{ route('agenda.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div class="text-truncate">Data Agenda</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('instansi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-buildings"></i>
                    <div class="text-truncate">Data Instansi</div>
                </a>
            </li>
        @endif
        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Profil</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('profil.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bxs-face"></i>
                <div class="text-truncate">Profil</div>
            </a>
        </li>

    </ul>
</aside>
