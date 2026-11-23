@extends('layouts.main')
@section('title', 'Dashboard Perusahaan - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-0">{{ $company->display_name }}</h3>
            <small class="text-muted">Status Legalitas: {{ $company->legal_status == '1' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('company.job_vacancy.index') }}" class="btn btn-primary btn-sm">Lowongan Kerja</a>
            <a href="{{ route('company.internship.index') }}" class="btn btn-outline-primary btn-sm">Pemagangan</a>
            <a href="{{ route('company.findjobseeker.index') }}" class="btn btn-outline-info btn-sm">Cari Pencaker</a>
            <a href="{{ route('company.hi.karyawan') }}" class="btn btn-outline-success btn-sm">Data Karyawan</a>
            <a href="{{ route('company.hi.wlkp') }}" class="btn btn-outline-secondary btn-sm">WLKP & Serikat</a>
            <a href="{{ route('company.hi.pelayanan') }}" class="btn btn-warning btn-sm">Pelayanan HI (PP/PKWT/PKB)</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Lowongan Kerja</div><div class="h4 fw-bold">{{ $stats['jobs'] }}</div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Pemagangan</div><div class="h4 fw-bold">{{ $stats['internships'] }}</div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Karyawan Aktif</div><div class="h4 fw-bold">{{ $stats['karyawan'] }}</div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Laporan WLKP</div><div class="h4 fw-bold">{{ $stats['wlkp'] }}</div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Pengajuan HI</div><div class="h4 fw-bold">{{ $stats['hi_requests'] }}</div></div></div>
    </div>
</div>
@endsection
