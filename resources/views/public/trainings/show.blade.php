@extends('layouts.main')
@section('title', $training->title_training . ' - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 p-4">
        <h3 class="fw-bold">{{ $training->title_training }}</h3>
        <p class="text-muted">{{ $training->lpk?->name_lpk ?? 'LPK' }} &middot; {{ $training->city?->city_name ?? 'Medan' }} &middot; Mulai: {{ \App\Support\DateHelper::tglIndo($training->date_training) }}</p>
        <hr>
        <div class="mb-4">{!! \App\Support\HtmlSanitizer::clean($training->desc_training) !!}</div>
        @if($hasApplied)
            <button class="btn btn-secondary" disabled>Anda Sudah Terdaftar</button>
        @else
            <form method="POST" action="{{ route('main.training.apply', $training->id_training) }}">
                @csrf
                <button type="submit" class="btn btn-primary fw-bold">Daftar Pelatihan Ini</button>
            </form>
        @endif
    </div>
</div>
@endsection
