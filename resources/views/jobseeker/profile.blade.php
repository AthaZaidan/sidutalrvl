@extends('layouts.main')
@section('title', 'Profil Pencari Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Profil Pencari Kerja</h4>
            <a href="{{ route('jobseeker.profile.edit') }}" class="btn btn-primary btn-sm">Edit Profil & Dokumen</a>
        </div>
        <div class="row g-3">
            <div class="col-md-6"><strong>Nama:</strong> {{ $user->full_name }}</div>
            <div class="col-md-6"><strong>NIK:</strong> {{ $user->nik ?? '-' }}</div>
            <div class="col-md-6"><strong>Email:</strong> {{ $user->email }}</div>
            <div class="col-md-6"><strong>No. HP:</strong> {{ $user->no_handphone ?? '-' }}</div>
            <div class="col-md-6"><strong>Bidang Kerja:</strong> {{ $user->jobField?->name_jobfield ?? '-' }}</div>
            <div class="col-md-6"><strong>Pendidikan:</strong> {{ $user->educationLevel?->name_educationlevel ?? '-' }} ({{ $user->major ?? '-' }})</div>
            <div class="col-12"><strong>Alamat:</strong> {{ $user->address ?? '-' }}</div>
        </div>
        <hr>
        <h6 class="fw-bold">Keahlian</h6>
        <div class="d-flex flex-wrap gap-1 mb-3">
            @forelse($user->skills as $sk)
                <span class="badge bg-primary">{{ $sk->name_skill }}</span>
            @empty
                <span class="text-muted small">Belum ada keahlian.</span>
            @endforelse
        </div>
        <h6 class="fw-bold">Pengalaman Kerja</h6>
        <ul>
            @forelse($user->experiences as $exp)
                <li><strong>{{ $exp->position }}</strong> di {{ $exp->company }} ({{ $exp->time }})</li>
            @empty
                <li class="text-muted small">Belum ada pengalaman kerja.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
