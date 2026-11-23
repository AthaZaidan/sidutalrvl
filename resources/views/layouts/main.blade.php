<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIDUTA - Sistem Informasi Terpadu Ketenagakerjaan Kota Medan')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favico/favicon-16x16.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="{{ asset('assets/summernote/summernote-lite.css') }}" rel="stylesheet">

    @if(($styles ?? 2) == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/styles-lowongankerja.css') }}">
    @endif

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    @stack('styles')
</head>
<body class="bg-light">
    <section id="header">
        <div class="container-fluid">
            <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white border-bottom shadow-sm p-3 mb-5 rounded" style="z-index: 1030;">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <div class="box-logo">
                            <img src="{{ asset('assets/images/logo/logo-utama.png') }}" alt="siduta-logo" class="logo-home" style="max-height:42px;">
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        @unless(Auth::guard('company')->check() || Auth::guard('lpk')->check())
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link mx-2 {{ request()->routeIs('main.job_vacancy*') ? 'active-nav' : '' }}" href="{{ route('main.job_vacancy.index') }}">LOWONGAN KERJA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mx-2 {{ request()->routeIs('main.internship*') ? 'active-nav' : '' }}" href="{{ route('main.internship.index') }}">MAGANG</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mx-2 {{ request()->routeIs('main.training*') ? 'active-nav' : '' }}" href="{{ route('main.training.index') }}">PELATIHAN</a>
                                </li>
                                <li class="nav-item dropdown mx-2">
                                    <a class="nav-link dropdown-toggle" href="#" id="pelayananDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">PELAYANAN</a>
                                    <ul class="dropdown-menu" aria-labelledby="pelayananDropdown">
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.ak1.index') }}">PEMBUATAN KARTU AK1</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.dispute.index') }}">PENGADUAN PERSELISIHAN HI</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.survey.index') }}">SURVEI KEPUASAN (IKM)</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.certificate.index') }}">CEK KEASLIAN SERTIFIKAT</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.faq.index') }}">FAQ SIDUTA</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown mx-2">
                                    <a class="nav-link dropdown-toggle" href="#" id="downloadDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">DOWNLOAD</a>
                                    <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                        <li><a class="dropdown-item" href="{{ route('main.manual.download', 'jobseeker') }}">PANDUAN ANGKATAN KERJA</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.manual.download', 'company') }}">PANDUAN PERUSAHAAN</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.manual.download', 'lpk') }}">PANDUAN LPK</a></li>
                                        <li><a class="dropdown-item" href="{{ route('main.jdih') }}">JARINGAN DOKUMENTASI & INFORMASI HUKUM</a></li>
                                    </ul>
                                </li>
                            </ul>
                        @endunless

                        <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                            @if(Auth::guard('company')->check())
                                @php($comp = Auth::guard('company')->user())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-building me-1"></i> {{ $comp->display_name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('company.dashboard') }}">DASHBOARD PERUSAHAAN</a></li>
                                        <li><a class="dropdown-item" href="{{ route('company.profile') }}">PROFIL PERUSAHAAN</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('company.logout') }}" method="POST">@csrf
                                                <button type="submit" class="dropdown-item text-danger">LOGOUT</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('main.notifications.index') }}">
                                        <i class="fas fa-bell"></i>
                                        @if($unreadNotifCount > 0)<span class="badge bg-danger">{{ $unreadNotifCount }}</span>@endif
                                    </a>
                                </li>
                            @elseif(Auth::guard('lpk')->check())
                                @php($lpk = Auth::guard('lpk')->user())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-chalkboard-teacher me-1"></i> {{ $lpk->name_lpk ?? $lpk->email_lpk }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('lpk.dashboard') }}">DASHBOARD LPK</a></li>
                                        <li><a class="dropdown-item" href="{{ route('lpk.profile') }}">PROFIL LPK</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('lpk.logout') }}" method="POST">@csrf
                                                <button type="submit" class="dropdown-item text-danger">LOGOUT</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('main.notifications.index') }}">
                                        <i class="fas fa-bell"></i>
                                        @if($unreadNotifCount > 0)<span class="badge bg-danger">{{ $unreadNotifCount }}</span>@endif
                                    </a>
                                </li>
                            @elseif(Auth::guard('web')->check() && (int) Auth::guard('web')->user()->role_id === \App\Support\SidutaConstants::ANGKATAN_KERJA)
                                @php($js = Auth::guard('web')->user())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-1"></i> {{ $js->full_name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.dashboard') }}">DASHBOARD</a></li>
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.profile') }}">PROFIL SAYA</a></li>
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.ak1.index') }}">KARTU AK-1</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('jobseeker.logout') }}" method="POST">@csrf
                                                <button type="submit" class="dropdown-item text-danger">LOGOUT</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('main.notifications.index') }}">
                                        <i class="fas fa-bell"></i>
                                        @if($unreadNotifCount > 0)<span class="badge bg-danger">{{ $unreadNotifCount }}</span>@endif
                                    </a>
                                </li>
                            @elseif(Auth::guard('web')->check())
                                <li class="nav-item">
                                    <a class="btn btn-sm btn-primary" href="{{ route(\App\Support\SidutaConstants::adminHomeRouteByRole((int) Auth::guard('web')->user()->role_id)) }}">PANEL ADMIN</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">DAFTAR</a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.register') }}">PENCARI KERJA</a></li>
                                        <li><a class="dropdown-item" href="{{ route('company.register') }}">PERUSAHAAN</a></li>
                                        <li><a class="dropdown-item" href="{{ route('lpk.register') }}">LPK</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">MASUK</a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('jobseeker.login') }}">PENCARI KERJA</a></li>
                                        <li><a class="dropdown-item" href="{{ route('lpk.login') }}">LPK / OPD</a></li>
                                        <li><a class="dropdown-item" href="{{ route('adm.login') }}">ADMIN DISNAKER</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nl-link btn-reg px-3 py-2" href="{{ route('company.login') }}" style="font-weight: 800; font-size: 11px">MASUK PERUSAHAAN</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </section>

    <div style="padding-top: 84px; min-height: 72vh;">
        @if(session('notyf_success') || session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('notyf_success') ?? session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if(session('notyf_error') || session('error') || $errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('notyf_error') ?? session('error') }}
                    @if($errors->any())
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <div class="modal fade" id="termModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ketentuan Dan Privasi SIDUTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Selamat datang di layanan informasi ketenagakerjaan <strong>SIDUTA Dinas Ketenagakerjaan Kota Medan</strong>. Data pribadi pengguna seperti NIK, email, nomor handphone, dan dokumen perizinan disimpan secara aman untuk proses verifikasi layanan ketenagakerjaan Kota Medan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <section id="footer" class="mt-5">
        <div class="container-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="siduta-logo" style="max-height:42px;" class="mb-3">
                        <p class="description">SIDUTA adalah Sistem Informasi Terpadu Ketenagakerjaan Dinas Ketenagakerjaan Kota Medan bagi pencari kerja, perusahaan, dan LPK.</p>
                        <p class="copyright mt-3">&copy; Copyright SIDUTA {{ date('Y') }} - Dinas Ketenagakerjaan Kota Medan</p>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-5">
                                <ul class="list-unstyled">
                                    <li class="title-linked mb-2">TAUTAN</li>
                                    <li><a href="{{ route('main.faq.index') }}" class="link">FAQ</a></li>
                                    <li><a href="{{ route('main.survey.index') }}" class="link">Survei IKM</a></li>
                                    <li><a href="{{ route('main.certificate.index') }}" class="link">Cek Sertifikat</a></li>
                                    <li><a href="#" class="link" data-bs-toggle="modal" data-bs-target="#termModal">Kebijakan & Privasi</a></li>
                                </ul>
                            </div>
                            <div class="col-7">
                                <ul class="list-unstyled">
                                    <li class="title-linked mb-2">DINAS KETENAGAKERJAAN KOTA MEDAN</li>
                                    <li class="small">Jl. K.H. Wahid Hasyim No.14, Merdeka, Kec. Medan Baru, Kota Medan, Sumatera Utara 20154</li>
                                    <li class="small mt-1">Telepon: (061) 4511428</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ asset('assets/summernote/summernote-lite.js') }}"></script>
    @stack('scripts')
</body>
</html>
