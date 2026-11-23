@extends('layouts.main')
@section('title', 'Cari Pencari Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Cari Pencari Kerja</h4>
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="text" name="keyword" class="form-control" placeholder="Nama atau jurusan..." value="{{ request('keyword') }}"></div>
        <div class="col-md-3">
            <select name="job_field" class="form-select">
                <option value="">Semua Bidang</option>
                @foreach($jobFields as $jf)<option value="{{ $jf->id_jobfield }}" @selected(request('job_field') == $jf->id_jobfield)>{{ $jf->name_jobfield }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="education_level" class="form-select">
                <option value="">Semua Pendidikan</option>
                @foreach($educationLevels as $ed)<option value="{{ $ed->id_educationlevel }}" @selected(request('education_level') == $ed->id_educationlevel)>{{ $ed->name_educationlevel }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary">Cari</button></div>
    </form>
    <div class="row g-3">
        @foreach($jobseekers as $js)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold mb-1">{{ $js->full_name }}</h6>
                    <div class="small text-muted mb-2">{{ $js->jobField?->name_jobfield ?? '-' }} &middot; {{ $js->educationLevel?->name_educationlevel ?? '-' }}</div>
                    <a href="{{ route('company.findjobseeker.show', $js->id) }}" class="btn btn-sm btn-outline-primary mt-auto">Lihat Profil</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $jobseekers->links() }}</div>
</div>
@endsection
