@extends('layouts.auth')
@section('title', 'Masuk LPK - SIDUTA')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:460px;">
    <div class="card-body p-4">
        <h4 class="fw-bold text-center mb-1">Masuk LPK / OPD</h4>
        <p class="text-muted text-center small mb-4">Lembaga Pelatihan Kerja Kota Medan</p>
        <form method="POST" action="{{ route('lpk.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email LPK</label>
                <input type="email" name="inputEmail" class="form-control" value="{{ old('inputEmail') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="inputPassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk</button>
        </form>
        <div class="d-flex justify-content-between mt-3 small">
            <a href="{{ route('password.forgot') }}">Lupa Password?</a>
            <a href="{{ route('lpk.register') }}">Daftar LPK</a>
        </div>
    </div>
</div>
@endsection
