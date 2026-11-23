@extends('layouts.main')
@section('title', 'Pelamar Magang - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Pelamar Magang: {{ $internship->title_intern }}</h4>
    <div class="card border-0 shadow-sm p-3">
        <table class="table">
            <thead><tr><th>Nama</th><th>Pendidikan</th><th>Status</th><th>Ubah</th></tr></thead>
            <tbody>
                @forelse($applicants as $app)
                    <tr>
                        <td>{{ $app->user?->full_name }}</td>
                        <td>{{ $app->user?->educationLevel?->name_educationlevel ?? '-' }}</td>
                        <td>{{ $app->process_apply == 2 ? 'Diterima' : ($app->process_apply == 3 ? 'Ditolak' : 'Pending') }}</td>
                        <td>
                            <form method="POST" action="{{ route('company.internship.applicant.status', $app->id_listapplicant) }}" class="d-flex gap-1">
                                @csrf
                                <select name="process_apply" class="form-select form-select-sm"><option value="1">Shortlist</option><option value="2">Terima</option><option value="3">Tolak</option></select>
                                <button class="btn btn-sm btn-primary">OK</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada pelamar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
