@extends('layouts.admin-auth')
@section('title', 'Reset Password Admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg my-5 p-5">
            <h4 class="mb-3 text-center">Reset Password Admin</h4>
            <form method="POST" action="{{ route('adm.reset_password.submit') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password1" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Ulangi Password Baru</label>
                    <input type="password" name="password2" class="form-control" required>
                </div>
                <button class="btn btn-primary btn-block">Simpan Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
