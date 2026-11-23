@extends('layouts.auth')
@section('title', 'Registrasi Perusahaan Selesai')
@section('content')
<div class="card shadow-sm border-0 mx-auto text-center p-5" style="max-width:560px;">
    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
    <h3 class="fw-bold">Registrasi Perusahaan Selesai!</h3>
    <p class="text-muted">Data perusahaan Anda telah tercatat dan akan diverifikasi oleh Admin Disnaker Kota Medan.</p>
    <a href="{{ route('company.dashboard') }}" class="btn btn-primary mt-2">Masuk ke Dashboard Perusahaan</a>
</div>
@endsection
