<!DOCTYPE html>
<html lang="id">

<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

<style>
.pc-sidebar .pc-link {
    padding: 9px 13px !important;
}

.pc-sidebar .pc-micon {
    width: 35px;
    height: 35px;
}

.pc-sidebar .pc-mtext {
    font-size: 16px;
}

.pc-sidebar .pc-item {
    margin-bottom: 5px;
}

.pc-sidebar .pc-caption label {
    font-size: 14px;
    margin-bottom: 7px;
}

.pc-sidebar {
    height: 100vh;
}

.pc-sidebar .navbar-content {
    height: 100%;
    overflow-y: auto;
}
</style>

<head>
    <title>@yield('title', 'Dashboard') | Aplikasi Inventaris</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header" style="height: auto; padding: 20px 10px; text-align: center; display: flex; justify-content: center; align-items: center;">
                <a href="{{ url('/') }}" class="b-brand text-primary" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="width: 60px; height: auto; object-fit: contain;">
                    <div class="brand-text-container">
                        <h5 class="m-0 fw-bold" style="color: #333; font-size: 1rem; letter-spacing: 1px;">SI-LAPORTIK</h5>
                        <p class="m-0 text-muted" style="font-size: 10px; line-height: 1.2; text-transform: uppercase; font-weight: 500;">
                            Sistem Informasi Pelaporan Kerusakan dan Perawatan TIK
                    </div>
                </a>
            </div>
            <div class="navbar-content">

                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Kelola Data</label>
                    </li>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li class="pc-item">
                            <a href="{{ route('admin.dashboard') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-status-up"></use></svg></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.kecamatan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-layer"></use></svg></span>
                                <span class="pc-mtext">Data Kecamatan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.users.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-user-bold"></use></svg></span>
                                <span class="pc-mtext">Data Operator</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.inventaris.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-box-1"></use></svg></span>
                                <span class="pc-mtext">Inventaris</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.perawatan.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-setting-outline"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Monitoring Perawatan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.laporan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-document-text"></use></svg></span>
                                <span class="pc-mtext">Laporan Kerusakan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.rekap.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-clipboard"></use></svg></span>
                                <span class="pc-mtext">Rekap Laporan Kerusakan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('admin.rekap_perawatan.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-clipboard"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Rekap Perawatan</span>
                            </a>
                        </li>

                    @elseif(Auth::check() && Auth::user()->role === 'kabid')
                        <li class="pc-item">
                            <a href="{{ route('kabid.dashboard') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-status-up"></use></svg></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.kecamatan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-layer"></use></svg></span>
                                <span class="pc-mtext">Monitoring Kecamatan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.inventaris.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-box-1"></use></svg></span>
                                <span class="pc-mtext">Monitoring Inventaris</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.perawatan.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-setting-outline"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Monitoring Perawatan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.laporan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-document-text"></use></svg></span>
                                <span class="pc-mtext">Persetujuan Laporan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.rekap.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-clipboard"></use></svg></span>
                                <span class="pc-mtext">Rekap Laporan Kerusakan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('kabid.rekap_perawatan.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-clipboard"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Rekap Perawatan</span>
                            </a>
                        </li>

                    @elseif(Auth::check() && Auth::user()->role === 'operator')
                        <li class="pc-item">
                            <a href="{{ route('operator.dashboard') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-status-up"></use></svg></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('operator.inventaris.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-box-1"></use></svg></span>
                                <span class="pc-mtext">Data Inventaris</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('operator.laporan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-document-text"></use></svg></span>
                                <span class="pc-mtext">Laporan Kerusakan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('operator.perawatan.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-setting-outline"></use></svg></span>
                                <span class="pc-mtext">Perawatan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('operator.rekap.index') }}" class="pc-link">
                                <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-clipboard"></use></svg></span>
                                <span class="pc-mtext">Rekap Laporan Kerusakan</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="{{ route('operator.rekap_perawatan.index') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-clipboard"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Rekap Perawatan</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Profile</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar wid-35" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ Auth::user()->name ?? 'User Name' }}</h6>
                                            <span>{{ Auth::user()->email ?? 'user@email.com' }}</span>
                                        </div>
                                    </div>
                                    <hr class="border-secondary border-opacity-50" />
                                    <form action="{{ route('logout') }}" method="POST" class="d-grid mb-3">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <svg class="pc-icon me-2">
                                                <use xlink:href="#custom-logout-1-outline"></use>
                                            </svg>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">@yield('title', 'Dashboard')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')

        </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Application System &copy; {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/lslstrength.min.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>change_box_container('false');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change("preset-1");</script>

    @stack('scripts')
    <style>
    .pc-sidebar .m-header {
        justify-content: center !important;
    }

    .b-brand {
        text-decoration: none !important;
        width: 100%;
    }

    .brand-text-container {
        padding: 0 5px;
        text-align: center;
    }
    .pc-sidebar.pc-sidebar-hide .brand-text-container {
        display: none;
    }
</style>
</body>

</html>
