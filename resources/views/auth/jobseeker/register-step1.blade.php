@extends('layouts.auth')
@section('title', 'Daftar Pencari Kerja (Langkah 1/4) - SIDUTA')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:600px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Registrasi Pencari Kerja</h4>
            <span class="badge bg-primary">Langkah 1 / 4</span>
        </div>
        <form method="POST" action="{{ route('jobseeker.register.step1.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Depan</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold">Lanjut ke Data Diri</button>
        </form>
        <div class="text-center mt-3 small">Sudah punya akun? <a href="{{ route('jobseeker.login') }}">Masuk di sini</a></div>
    </div>
</div>
@endsection
