@extends('layouts.main')
@section('title', 'Profil Kandidat - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold">{{ $jobseeker->full_name }}</h4>
        <p class="text-muted">{{ $jobseeker->jobField?->name_jobfield ?? '-' }} | {{ $jobseeker->educationLevel?->name_educationlevel ?? '-' }} ({{ $jobseeker->major ?? '-' }})</p>
        <p><strong>Email:</strong> {{ $jobseeker->email }} | <strong>HP:</strong> {{ $jobseeker->no_handphone ?? '-' }}</p>
        <h6>Keahlian</h6>
        <div class="d-flex flex-wrap gap-1 mb-3">
            @foreach($jobseeker->skills as $sk)<span class="badge bg-primary">{{ $sk->name_skill }}</span>@endforeach
        </div>
        <h6>Pengalaman</h6>
        <ul>@foreach($jobseeker->experiences as $exp)<li>{{ $exp->position }} - {{ $exp->company }} ({{ $exp->time }})</li>@endforeach</ul>
    </div>
</div>
@endsection
