@extends('layouts.main')
@section('title', $internship->title_intern . ' - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 p-4">
        <h3 class="fw-bold">{{ $internship->title_intern }}</h3>
        <p class="text-muted">{{ $internship->organizer_name }} &middot; {{ $internship->city?->city_name ?? 'Medan' }} &middot; Durasi {{ $internship->length_intern }} Bulan</p>
        <hr>
        <div class="mb-4">{!! \App\Support\HtmlSanitizer::clean($internship->desc_intern) !!}</div>
        @if($hasApplied)
            <button class="btn btn-secondary" disabled>Anda Sudah Mendaftar</button>
        @else
            <form method="POST" action="{{ route('main.internship.apply', $internship->id_intern) }}">
                @csrf
                <button type="submit" class="btn btn-primary fw-bold">Daftar Magang Ini</button>
            </form>
        @endif
    </div>
</div>
@endsection
