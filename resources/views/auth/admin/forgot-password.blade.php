@extends('layouts.admin-auth')
@section('title', 'Lupa Password Admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg my-5 p-5">
            <h4 class="mb-3 text-center">Lupa Password Admin</h4>
            @if(session('flash_error'))<div class="alert alert-danger">{{ session('flash_error') }}</div>@endif
            <form method="POST" action="{{ route('adm.forgot_password.submit') }}">
                @csrf
                <div class="form-group">
                    <label>Email Terdaftar</label>
                    <input type="email" name="inputEmail" class="form-control" required>
                </div>
                <button class="btn btn-primary btn-block">Kirim Reset</button>
            </form>
            <div class="text-center mt-3"><a href="{{ route('adm.login') }}">Kembali ke Login</a></div>
        </div>
    </div>
</div>
@endsection
