@extends('layouts.auth')
@section('title', 'Pendaftaran Selesai - SIDUTA')
@section('content')
<div class="card shadow-sm border-0 mx-auto text-center p-5" style="max-width:560px;">
    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
    <h3 class="fw-bold">Pendaftaran Pencari Kerja Selesai!</h3>
    <p class="text-muted">Profil Anda sudah lengkap. Anda sekarang dapat mengajukan pembuatan Kartu AK-1 serta melamar lowongan kerja, magang, dan pelatihan.</p>
    <div class="d-flex justify-content-center gap-2 mt-3">
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
        <a href="{{ route('jobseeker.ak1.index') }}" class="btn btn-outline-primary">Ajukan Kartu AK-1</a>
    </div>
</div>
@endsection
