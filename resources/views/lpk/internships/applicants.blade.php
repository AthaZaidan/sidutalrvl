@extends('layouts.main')
@section('title', 'Pelamar Magang LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Pelamar Magang: {{ $internship->title_intern }}</h4>
    <div class="card border-0 shadow-sm p-3">
        <table class="table">
            <thead><tr><th>Nama</th><th>Email</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($applicants as $app)
                    <tr><td>{{ $app->user?->full_name }}</td><td>{{ $app->user?->email }}</td><td>Pending</td></tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada pelamar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
