@extends('layouts.auth')
@section('title', 'Lupa Password - SIDUTA')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:480px;">
    <div class="card-body p-4">
        <h4 class="fw-bold text-center mb-3">Lupa Password</h4>
        <form method="POST" action="{{ route('password.forgot.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tipe Akun</label>
                <select name="account_type" class="form-select" required>
                    <option value="jobseeker">Pencari Kerja</option>
                    <option value="company">Perusahaan</option>
                    <option value="lpk">LPK</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Terdaftar</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Buat Link Reset Password</button>
        </form>
    </div>
</div>
@endsection
