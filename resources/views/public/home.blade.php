@extends('layouts.main')
@section('title', 'Beranda - Sistem Informasi Terpadu Ketenagakerjaan Kota Medan')
@section('content')
<section id="body">
    <div class="container-search">
        <div class="container py-4">
            <p class="title-search mt-2">Temukan <span class="title-a">lowongan pekerjaan</span> baru setiap bulan!</p>
            <form class="row g-2 pb-4 pt-2" method="GET" action="{{ route('main.job_vacancy.index') }}">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari lowongan pekerjaan..." name="job_filter" value="{{ request('job_filter') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select select2" id="category_field" name="category_field">
                        <option value="all">Semua Bidang Pekerjaan</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id_jobfield }}">{{ $category->name_jobfield }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="button btn w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container-landingpage">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="greeting-landing">
                        <h1 class="text-sidehome">SIDUTA</h1>
                        <h2 class="text-detail-sidehome h4">Selamat datang di Sistem Informasi Terpadu Ketenagakerjaan Kota Medan.</h2>
                        <div class="mt-4 d-flex flex-wrap gap-2">
                            <a href="{{ route('jobseeker.register') }}" class="btn btn-reg">Daftar Sekarang</a>
                            <a href="{{ route('main.survey.index') }}" class="btn btn-outline-light">Survei Kepuasan (IKM)</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/images/bg-2.png') }}" class="img-fluid" style="max-height:320px;" alt="SIDUTA Medan">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">KEMBANGKAN KARIR DAN PENGALAMANMU DI DUNIA KERJA</h2>
            <p class="text-muted">Bangun karir, daftar pelatihan, urus AK-1, dan akses layanan ketenagakerjaan Kota Medan.</p>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-md-3 col-6">
                <a href="{{ route('main.job_vacancy.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 text-center p-3">
                        <img src="{{ asset('assets/images/deal.svg') }}" alt="" class="mx-auto mb-2" width="64">
                        <h5 class="fw-bold text-dark">Lowongan Kerja</h5>
                        <span class="badge bg-primary mx-auto">{{ $stats['jobs'] }} Aktif</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('main.internship.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 text-center p-3">
                        <img src="{{ asset('assets/images/article.svg') }}" alt="" class="mx-auto mb-2" width="64">
                        <h5 class="fw-bold text-dark">Pemagangan</h5>
                        <span class="badge bg-info mx-auto">{{ $stats['internships'] }} Aktif</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('main.training.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 text-center p-3">
                        <img src="{{ asset('assets/images/outline.svg') }}" alt="" class="mx-auto mb-2" width="64">
                        <h5 class="fw-bold text-dark">Pelatihan LPK</h5>
                        <span class="badge bg-success mx-auto">{{ $stats['trainings'] }} Aktif</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('main.faq.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 text-center p-3">
                        <img src="{{ asset('assets/images/discuss.svg') }}" alt="" class="mx-auto mb-2" width="64">
                        <h5 class="fw-bold text-dark">FAQ & Bantuan</h5>
                        <span class="badge bg-secondary mx-auto">Info Layanan</span>
                    </div>
                </a>
            </div>
        </div>

        @if($latestJobs->isNotEmpty())
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Lowongan Kerja Terbaru</h4>
                <a href="{{ route('main.job_vacancy.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="row g-3">
                @foreach($latestJobs as $job)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <span class="badge bg-light text-primary border mb-2">{{ $job->jobField?->name_jobfield ?? 'Umum' }}</span>
                                <h5 class="fw-bold mb-1">
                                    <a href="{{ route('main.job_vacancy.detail', $job->id_jobvacancy) }}" class="text-decoration-none text-dark">{{ $job->title_jobvacancy }}</a>
                                </h5>
                                <p class="text-muted small mb-2"><i class="fas fa-building me-1"></i> {{ $job->company?->display_name ?? '-' }}</p>
                                <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> {{ $job->city?->city_name ?? 'Kota Medan' }}</p>
                                <p class="small fw-semibold text-success mb-0">
                                    {{ \App\Support\DateHelper::formatRupiah($job->salary_start) }} - {{ \App\Support\DateHelper::formatRupiah($job->salary_end) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
@push('scripts')
<script>$('#category_field').select2({ theme: 'bootstrap-5' });</script>
@endpush
