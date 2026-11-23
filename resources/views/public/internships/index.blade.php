@extends('layouts.main')
@section('title', 'Pemagangan - SIDUTA')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">Program Pemagangan</h3>
    <form method="GET" action="{{ route('main.internship.index') }}" class="row g-2 mb-4">
        <div class="col-md-6"><input type="text" name="keyword" class="form-control" placeholder="Cari program magang..." value="{{ request('keyword') }}"></div>
        <div class="col-md-4">
            <select name="city" class="form-select">
                <option value="">Semua Kota</option>
                @foreach($cities as $c)
                    <option value="{{ $c->id_city }}" @selected(request('city') == $c->id_city)>{{ $c->city_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary">Filter</button></div>
    </form>
    <div class="row g-3">
        @forelse($internships as $in)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <span class="badge bg-info text-dark mb-2">Durasi {{ $in->length_intern }} Bulan</span>
                        <h5 class="fw-bold"><a href="{{ route('main.internship.detail', $in->id_intern) }}" class="text-decoration-none text-dark">{{ $in->title_intern }}</a></h5>
                        <p class="small text-muted mb-2">{{ $in->organizer_name }} &middot; {{ $in->city?->city_name ?? 'Medan' }}</p>
                        <a href="{{ route('main.internship.detail', $in->id_intern) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Belum ada program pemagangan aktif.</div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $internships->links() }}</div>
</div>
@endsection
