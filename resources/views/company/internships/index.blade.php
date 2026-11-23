@extends('layouts.main')
@section('title', 'Pemagangan Perusahaan - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Program Pemagangan Perusahaan</h4>
        <a href="{{ route('company.internship.create') }}" class="btn btn-primary btn-sm">+ Ajukan Magang</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead><tr><th>Judul</th><th>Durasi</th><th>Status</th><th>Pelamar</th></tr></thead>
            <tbody>
                @forelse($internships as $in)
                    <tr>
                        <td>{{ $in->title_intern }}</td>
                        <td>{{ $in->length_intern }} Bulan</td>
                        <td><span class="badge bg-{{ $in->publish_status == 1 ? 'success' : 'warning text-dark' }}">{{ $in->publish_status == 1 ? 'Terbit' : 'Pending' }}</span></td>
                        <td><a href="{{ route('company.internship.applicants', $in->id_intern) }}" class="btn btn-sm btn-outline-info">{{ $in->applicants_count }} Pelamar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada program magang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
