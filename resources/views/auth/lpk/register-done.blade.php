@extends('layouts.auth')
@section('title', 'Registrasi LPK Selesai')
@section('content')
<div class="card shadow-sm border-0 mx-auto text-center p-5" style="max-width:560px;">
    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
    <h3 class="fw-bold">Registrasi LPK Selesai!</h3>
    <p class="text-muted">Dokumen perizinan LPK Anda akan diverifikasi oleh Admin Disnaker Kota Medan.</p>
    <a href="{{ route('lpk.dashboard') }}" class="btn btn-primary mt-2">Masuk ke Dashboard LPK</a>
</div>
@endsection
