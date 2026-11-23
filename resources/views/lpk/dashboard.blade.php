@extends('layouts.main')
@section('title', 'Dashboard LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-0">{{ $lpk->name_lpk ?? $lpk->email_lpk }}</h3>
            <small class="text-muted">VIN: {{ $lpk->no_vin }} | Status Legalitas: {{ $lpk->legal_status == 3 ? 'Terverifikasi' : 'Proses Verifikasi' }}</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('lpk.training.index') }}" class="btn btn-primary btn-sm">Pelatihan</a>
            <a href="{{ route('lpk.internship.index') }}" class="btn btn-outline-primary btn-sm">Pemagangan</a>
            <a href="{{ route('lpk.certification.index') }}" class="btn btn-outline-info btn-sm">Sertifikasi</a>
            <a href="{{ route('lpk.report.index') }}" class="btn btn-warning btn-sm">Laporan Semester LPK</a>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-4"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Pelatihan</div><div class="h4 fw-bold">{{ $stats['trainings'] }}</div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Pemagangan</div><div class="h4 fw-bold">{{ $stats['internships'] }}</div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Pengajuan Sertifikasi</div><div class="h4 fw-bold">{{ $stats['certifications'] }}</div></div></div>
    </div>
</div>
@endsection
