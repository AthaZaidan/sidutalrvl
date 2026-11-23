@extends('layouts.main')
@section('title', 'Dashboard Pencari Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Halo, {{ $user->full_name }}</h3>
            <small class="text-muted">Dashboard Pencari Kerja SIDUTA</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jobseeker.profile') }}" class="btn btn-outline-primary btn-sm">Profil Saya</a>
            <a href="{{ route('jobseeker.ak1.index') }}" class="btn btn-primary btn-sm">Kartu AK-1</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="small text-muted">Status AK-1</div>
                @if($ak1)
                    @php($st = \App\Support\SidutaConstants::ak1StatusLabel((int)$ak1->process_status))
                    <div class="fw-bold mt-1"><span class="badge bg-{{ $st['badge'] }}">{{ $st['label'] }}</span></div>
                @else
                    <div class="fw-bold text-secondary mt-1">Belum Mengajukan</div>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="small text-muted">Lamaran Kerja</div>
                <div class="h4 fw-bold mb-0">{{ $jobApps->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="small text-muted">Lamaran Magang</div>
                <div class="h4 fw-bold mb-0">{{ $internApps->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="small text-muted">Pelatihan Diikuti</div>
                <div class="h4 fw-bold mb-0">{{ $trainApps->count() }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold mb-3">Riwayat Lamaran Lowongan</h5>
                @forelse($jobApps as $app)
                    <div class="border-bottom py-2 d-flex justify-content-between">
                        <div>
                            <div class="fw-semibold">{{ $app->jobVacancy?->title_jobvacancy ?? '-' }}</div>
                            <small class="text-muted">{{ $app->jobVacancy?->company?->display_name ?? '-' }}</small>
                        </div>
                        <span class="badge bg-{{ $app->process_apply == 2 ? 'success' : ($app->process_apply == 3 ? 'danger' : 'secondary') }} align-self-center">
                            {{ $app->process_apply == 2 ? 'Diterima' : ($app->process_apply == 3 ? 'Ditolak' : 'Diproses') }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Belum ada lamaran kerja.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold mb-3">Panggilan Interview</h5>
                @forelse($calls as $call)
                    <div class="border-bottom py-2">
                        <div class="fw-semibold">{{ \App\Support\DateHelper::tglIndo($call->date_call) }} ({{ $call->hour_call }})</div>
                        <div class="small">{{ $call->place_call }} - {{ $call->desc_call }}</div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Belum ada panggilan interview.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
