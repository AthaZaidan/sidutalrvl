@extends('layouts.main')
@section('title', 'Lowongan Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">Lowongan Kerja Kota Medan</h3>
    <form method="GET" action="{{ route('main.job_vacancy.index') }}" class="card shadow-sm border-0 p-3 mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="job_filter" class="form-control" placeholder="Kata kunci jabatan..." value="{{ request('job_filter') }}">
            </div>
            <div class="col-md-3">
                <select name="category_field" class="form-select">
                    <option value="all">Semua Bidang</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id_jobfield }}" @selected(request('category_field') == $c->id_jobfield)>{{ $c->name_jobfield }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="city" class="form-select">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id_city }}" @selected(request('city') == $city->id_city)>{{ $city->city_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="education_level" class="form-select">
                    <option value="">Min. Pendidikan</option>
                    @foreach($educationLevels as $ed)
                        <option value="{{ $ed->id_educationlevel }}" @selected(request('education_level') == $ed->id_educationlevel)>{{ $ed->name_educationlevel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <div class="form-check mt-2">
            <input type="checkbox" class="form-check-input" id="disCheck" name="disability" value="1" @checked(request()->boolean('disability'))>
            <label class="form-check-label small" for="disCheck">Hanya lowongan ramah disabilitas</label>
        </div>
    </form>

    <div class="row g-3">
        @forelse($jobvacancies as $job)
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-primary">{{ $job->jobField?->name_jobfield ?? 'Umum' }}</span>
                            @if($job->disability_status == 1)
                                <span class="badge bg-info text-dark">Ramah Disabilitas</span>
                            @endif
                        </div>
                        <h5 class="fw-bold mt-2">
                            <a href="{{ route('main.job_vacancy.detail', $job->id_jobvacancy) }}" class="text-decoration-none text-dark">{{ $job->title_jobvacancy }}</a>
                        </h5>
                        <div class="text-muted small mb-2">
                            <i class="fas fa-building me-1"></i> {{ $job->company?->display_name ?? '-' }} &middot;
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $job->city?->city_name ?? 'Medan' }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-success fw-semibold small">{{ \App\Support\DateHelper::formatRupiah($job->salary_start) }} - {{ \App\Support\DateHelper::formatRupiah($job->salary_end) }}</span>
                            <a href="{{ route('main.job_vacancy.detail', $job->id_jobvacancy) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Belum ada lowongan kerja yang sesuai filter.</div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $jobvacancies->links() }}</div>
</div>
@endsection
