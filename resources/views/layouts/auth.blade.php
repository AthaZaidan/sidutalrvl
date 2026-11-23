<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIDUTA Kota Medan')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favico/favicon-16x16.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles-lowongankerja.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css">
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo/logo-utama.png') }}" alt="siduta-logo" style="max-height:56px;">
            </a>
        </div>

        @if(session('notyf_success') || session('success'))
            <div class="alert alert-success mx-auto" style="max-width:720px;">{{ session('notyf_success') ?? session('success') }}</div>
        @endif
        @if(session('notyf_error') || session('error') || $errors->any())
            <div class="alert alert-danger mx-auto" style="max-width:720px;">
                {{ session('notyf_error') ?? session('error') }}
                @if($errors->any())
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        @yield('content')

        <p class="text-center text-muted small mt-5">&copy; Copyright SIDUTA {{ date('Y') }} - Dinas Ketenagakerjaan Kota Medan</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>
</html>
