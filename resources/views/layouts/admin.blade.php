<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin SIDUTA')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favico/android-chrome-512x512.png') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-admin.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    @stack('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('adm.administrator') }}">
                <div class="box-logo" style="width: 150px; height: 44px;">
                    <img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="siduta-logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </a>
            <hr class="sidebar-divider my-0">

            @foreach($sidebarMenus as $menu)
                @php($collapseId = 'menu_' . $menu->id)
                @php($isCurrentGroup = ($activeMenu ?? '') === $menu->menu)
                <li class="nav-item {{ $isCurrentGroup ? 'active' : '' }}">
                    <a class="nav-link {{ $isCurrentGroup ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#{{ $collapseId }}" aria-expanded="{{ $isCurrentGroup ? 'true' : 'false' }}">
                        <span>{{ $menu->menu }}</span>
                    </a>
                    <div id="{{ $collapseId }}" class="collapse {{ $isCurrentGroup ? 'show' : '' }}" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach($menu->subMenus as $sm)
                                <a class="collapse-item {{ request()->is(ltrim($sm->url, '/') . '*') ? 'active' : '' }}" href="{{ url($sm->url) }}">
                                    <i class="{{ $sm->icon }} mr-1"></i>
                                    <span>{{ $sm->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @endforeach

            <li class="nav-item">
                <a class="nav-link" href="{{ route('main.manual.download', 'disnaker') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Panduan Disnaker</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="d-none d-sm-inline-block text-primary font-weight-bold">
                        SIDUTA - Dinas Ketenagakerjaan Kota Medan
                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter sumreg"></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <h6 class="dropdown-header">Notifikasi Admin</h6>
                                <div class="list_notifikasi" style="max-height:320px; overflow-y:auto;">
                                    <span class="dropdown-item small text-muted">Memuat notifikasi...</span>
                                </div>
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('adm.notifications.index') }}">Lihat Semua Notifikasi</a>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $adminUser?->full_name }} ({{ $adminUser?->role?->role }})</span>
                                <i class="fas fa-user-circle fa-lg text-primary"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="{{ route('adm.user.index') }}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profil</a>
                                <a class="dropdown-item" href="{{ route('adm.user.changepassword') }}"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Ubah Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Keluar</a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @if(session('flash_success') || session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('flash_success') ?? session('success') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>
                    @endif
                    @if(session('flash_error') || session('error') || $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('flash_error') ?? session('error') }}
                            @if($errors->any())
                                <ul class="mb-0 pl-3">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                            @endif
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SIDUTA {{ date('Y') }} - Dinas Ketenagakerjaan Kota Medan</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anda ingin keluar dari SIDUTA?</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">Pilih "Keluar" untuk mengakhiri sesi admin Anda.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('adm.logout') }}" method="POST">@csrf
                        <button type="submit" class="btn btn-primary">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $.get("{{ route('adm.user.notifications.json') }}", function(res) {
                $('.sumreg').text(res.sumNotif > 0 ? res.sumNotif : '');
                let html = '';
                if (!res.data || res.data.length === 0) {
                    html = '<span class="dropdown-item small text-muted">Tidak ada notifikasi</span>';
                } else {
                    res.data.forEach(function(n) {
                        html += '<a class="dropdown-item d-flex align-items-center" href="{{ route("adm.notifications.index") }}">' +
                            '<div class="mr-3"><div class="icon-circle bg-warning"><i class="fas fa-bell text-white"></i></div></div>' +
                            '<div><div class="small text-gray-500">' + (n.created_notif ?? '') + '</div><span class="font-weight-bold small">' + $('<div>').text(n.desc_notif).html() + '</span></div></a>';
                    });
                }
                $('.list_notifikasi').html(html);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
