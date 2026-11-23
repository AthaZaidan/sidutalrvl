@extends('layouts.main')
@section('title', 'Kelola Lowongan Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Lowongan Kerja Perusahaan</h4>
        <a href="{{ route('company.job_vacancy.create') }}" class="btn btn-primary btn-sm">+ Ajukan Lowongan</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Judul</th><th>Bidang</th><th>Kota</th><th>Status</th><th>Pelamar</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($vacancies as $v)
                        <tr>
                            <td>{{ $v->title_jobvacancy }}</td>
                            <td>{{ $v->jobField?->name_jobfield ?? '-' }}</td>
                            <td>{{ $v->city?->city_name ?? '-' }}</td>
                            <td>
                                @if($v->publish_status == 1)<span class="badge bg-success">Terbit</span>
                                @elseif($v->publish_status == 2)<span class="badge bg-danger">Ditolak</span>
                                @elseif($v->publish_status == 3)<span class="badge bg-secondary">Ditutup</span>
                                @else<span class="badge bg-warning text-dark">Menunggu Verifikasi</span>@endif
                            </td>
                            <td><a href="{{ route('company.job_vacancy.applicants', $v->id_jobvacancy) }}" class="btn btn-sm btn-outline-info">{{ $v->applicants_count }} Pelamar</a></td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('company.job_vacancy.edit', $v->id_jobvacancy) }}" class="btn btn-sm btn-warning">Edit</a>
                                @if($v->publish_status == 1)
                                    <form method="POST" action="{{ route('company.job_vacancy.close', $v->id_jobvacancy) }}">@csrf
                                        <button class="btn btn-sm btn-secondary">Tutup</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada lowongan kerja.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $vacancies->links() }}</div>
</div>
@endsection
