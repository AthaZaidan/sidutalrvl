@extends('layouts.admin-auth')
@section('title', 'Login Admin SIDUTA')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-7 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo/logo-utama.png') }}" alt="SIDUTA" style="max-height:50px;" class="mb-3">
                    <h1 class="h4 text-gray-900">Login Admin & Petugas Disnaker</h1>
                </div>
                @if(session('flash_error'))
                    <div class="alert alert-danger">{{ session('flash_error') }}</div>
                @endif
                @if(session('flash_success'))
                    <div class="alert alert-success">{{ session('flash_success') }}</div>
                @endif
                <form method="POST" action="{{ route('adm.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="inputEmail" class="form-control form-control-user" value="{{ old('inputEmail') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="inputPassword" class="form-control form-control-user" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Masuk</button>
                </form>
                <hr>
                <div class="text-center d-flex justify-content-between">
                    <a class="small" href="{{ route('adm.forgot_password') }}">Lupa Password?</a>
                    <a class="small" href="{{ route('home') }}">Kembali ke Portal Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
