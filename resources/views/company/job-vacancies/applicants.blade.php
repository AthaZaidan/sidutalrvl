@extends('layouts.main')
@section('title', 'Daftar Pelamar - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Pelamar Lowongan: {{ $vacancy->title_jobvacancy }}</h4>
    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Nama</th><th>Pendidikan</th><th>Status</th><th>Ubah Status</th><th>Panggil Interview</th></tr></thead>
                <tbody>
                    @forelse($applicants as $app)
                        <tr>
                            <td>{{ $app->user?->full_name }}<br><small class="text-muted">{{ $app->user?->email }}</small></td>
                            <td>{{ $app->user?->educationLevel?->name_educationlevel ?? '-' }} ({{ $app->user?->major ?? '-' }})</td>
                            <td><span class="badge bg-secondary">{{ $app->process_apply == 2 ? 'Diterima' : ($app->process_apply == 3 ? 'Ditolak' : ($app->process_apply == 1 ? 'Shortlist' : 'Pending')) }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('company.job_vacancy.applicant.status', $app->id_listapplicant) }}" class="d-flex gap-1">
                                    @csrf
                                    <select name="process_apply" class="form-select form-select-sm">
                                        <option value="0" @selected($app->process_apply == 0)>Pending</option>
                                        <option value="1" @selected($app->process_apply == 1)>Shortlist</option>
                                        <option value="2" @selected($app->process_apply == 2)>Terima</option>
                                        <option value="3" @selected($app->process_apply == 3)>Tolak</option>
                                    </select>
                                    <button class="btn btn-sm btn-primary">OK</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('company.job_vacancy.applicant.call', $app->id_listapplicant) }}" class="row g-1">
                                    @csrf
                                    <div class="col-6"><input type="date" name="date_call" class="form-control form-control-sm" required></div>
                                    <div class="col-6"><input type="text" name="hour_call" class="form-control form-control-sm" placeholder="10:00 WIB" required></div>
                                    <div class="col-6"><input type="text" name="place_call" class="form-control form-control-sm" placeholder="Lokasi" required></div>
                                    <div class="col-6"><input type="text" name="desc_call" class="form-control form-control-sm" placeholder="Catatan" required></div>
                                    <div class="col-12"><button class="btn btn-sm btn-success w-100">Kirim Panggilan</button></div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada pelamar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
