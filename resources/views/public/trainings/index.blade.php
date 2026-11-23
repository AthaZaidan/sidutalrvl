@extends('layouts.main')
@section('title', 'Pelatihan - SIDUTA')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">Pelatihan Kerja LPK</h3>
    <form method="GET" action="{{ route('main.training.index') }}" class="row g-2 mb-4">
        <div class="col-md-6"><input type="text" name="keyword" class="form-control" placeholder="Cari pelatihan..." value="{{ request('keyword') }}"></div>
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
        @forelse($trainings as $tr)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <span class="badge bg-success mb-2">{{ ((int)$tr->price_training === 0) ? 'Gratis' : \App\Support\DateHelper::formatRupiah($tr->price_training) }}</span>
                        <h5 class="fw-bold"><a href="{{ route('main.training.detail', $tr->id_training) }}" class="text-decoration-none text-dark">{{ $tr->title_training }}</a></h5>
                        <p class="small text-muted mb-2">{{ $tr->lpk?->name_lpk ?? 'LPK' }} &middot; {{ $tr->city?->city_name ?? 'Medan' }}</p>
                        <a href="{{ route('main.training.detail', $tr->id_training) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Belum ada pelatihan aktif.</div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $trainings->links() }}</div>
</div>
@endsection
