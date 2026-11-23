@extends('layouts.main')
@section('title', $jobvacancy->title_jobvacancy . ' - SIDUTA')
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('main.job_vacancy.index') }}">Lowongan Kerja</a></li>
            <li class="breadcrumb-item active">{{ $jobvacancy->title_jobvacancy }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="fw-bold">{{ $jobvacancy->title_jobvacancy }}</h3>
                <p class="text-muted mb-2">
                    <i class="fas fa-building me-1"></i> {{ $jobvacancy->company?->display_name ?? '-' }} &middot;
                    <i class="fas fa-map-marker-alt me-1"></i> {{ $jobvacancy->city?->city_name ?? 'Medan' }}
                </p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-primary">{{ $jobvacancy->jobField?->name_jobfield ?? '-' }}</span>
                    <span class="badge bg-secondary">Pendidikan: {{ $jobvacancy->educationLevel?->name_educationlevel ?? 'Semua' }}</span>
                    <span class="badge bg-success">Gaji: {{ \App\Support\DateHelper::formatRupiah($jobvacancy->salary_start) }} - {{ \App\Support\DateHelper::formatRupiah($jobvacancy->salary_end) }}</span>
                    @if($jobvacancy->deadline_vacancy)
                        <span class="badge bg-warning text-dark">Batas: {{ \App\Support\DateHelper::tglIndo($jobvacancy->deadline_vacancy) }}</span>
                    @endif
                </div>
                <hr>
                <h5 class="fw-bold">Deskripsi Pekerjaan</h5>
                <div class="mb-4">{!! \App\Support\HtmlSanitizer::clean($jobvacancy->desc_vacancy) !!}</div>

                @if($jobvacancy->skills->isNotEmpty())
                    <h6 class="fw-bold">Keahlian Dibutuhkan</h6>
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @foreach($jobvacancy->skills as $sk)
                            <span class="badge bg-light text-dark border">{{ $sk->name_skill }}</span>
                        @endforeach
                    </div>
                @endif

                @if($jobvacancy->disabilities->isNotEmpty())
                    <h6 class="fw-bold">Disabilitas yang Dapat Melamar</h6>
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @foreach($jobvacancy->disabilities as $dis)
                            <span class="badge bg-info text-dark">{{ $dis->name_disability }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="mt-3">
                    @if($hasApplied)
                        <button class="btn btn-secondary" disabled>Anda Sudah Melamar</button>
                    @else
                        <form method="POST" action="{{ route('main.job_vacancy.apply', $jobvacancy->id_jobvacancy) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Lamar Pekerjaan Ini</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <h5 class="fw-bold mb-3">Lowongan Lainnya</h5>
                @foreach($similarJobs as $sj)
                    <div class="border-bottom pb-2 mb-2">
                        <a href="{{ route('main.job_vacancy.detail', $sj->id_jobvacancy) }}" class="fw-semibold text-decoration-none">{{ $sj->title_jobvacancy }}</a>
                        <div class="small text-muted">{{ $sj->company?->display_name ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
