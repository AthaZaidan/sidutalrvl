@extends('layouts.main')
@section('title', 'Kelola Pelatihan LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Pelatihan LPK</h4>
        <a href="{{ route('lpk.training.create') }}" class="btn btn-primary btn-sm">+ Ajukan Pelatihan</a>
    </div>
    <div class="card border-0 shadow-sm">
        <table class="table mb-0">
            <thead><tr><th>Judul</th><th>Tanggal</th><th>Status</th><th>Peserta</th></tr></thead>
            <tbody>
                @forelse($trainings as $tr)
                    <tr>
                        <td>{{ $tr->title_training }}</td>
                        <td>{{ \App\Support\DateHelper::tglIndo($tr->date_training) }}</td>
                        <td><span class="badge bg-{{ $tr->publish_status == 1 ? 'success' : ($tr->publish_status == 3 ? 'secondary' : 'warning text-dark') }}">{{ $tr->publish_status == 1 ? 'Terbit' : ($tr->publish_status == 3 ? 'Selesai' : 'Pending') }}</span></td>
                        <td><a href="{{ route('lpk.training.applicants', $tr->id_training) }}" class="btn btn-sm btn-outline-info">{{ $tr->applicants_count }} Peserta</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada pelatihan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
