@extends('layouts.auth')
@section('title', 'Reset Password - SIDUTA')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:480px;">
    <div class="card-body p-4">
        <h4 class="fw-bold text-center mb-3">Reset Password Baru</h4>
        <form method="POST" action="{{ route('password.reset.submit') }}">
            @csrf
            <input type="hidden" name="account_type" value="{{ $account_type }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Simpan Password</button>
        </form>
    </div>
</div>
@endsection
