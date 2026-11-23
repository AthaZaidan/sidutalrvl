@extends('layouts.admin')
@section('title', 'Manajemen Lowongan Kerja - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Lowongan Kerja</h1>
<div class="mb-3">
    @foreach(['all' => 'Semua', 'pending' => 'Pending', 'process' => 'Diproses', 'published' => 'Terbit', 'declined' => 'Ditolak', 'closed' => 'Ditutup'] as $k => $lbl)
        <a href="{{ route('adm.management.job_vacancy.index', ['status' => $k]) }}" class="btn btn-sm btn-{{ $status === $k ? 'primary' : 'outline-primary' }}">{{ $lbl }}</a>
    @endforeach
</div>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Judul</th><th>Perusahaan</th><th>Bidang</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($vacancies as $v)
                <tr>
                    <td>{{ $v->title_jobvacancy }}</td>
                    <td>{{ $v->company?->display_name ?? '-' }}</td>
                    <td>{{ $v->jobField?->name_jobfield ?? '-' }}</td>
                    <td>{{ $v->publish_status == 1 ? 'Terbit' : ($v->publish_status == 2 ? 'Ditolak' : ($v->publish_status == 3 ? 'Ditutup' : 'Menunggu')) }} (Tahap {{ $v->process_status }})</td>
                    <td class="d-flex">
                        <a href="{{ route('adm.management.job_vacancy.show', $v->id_jobvacancy) }}" class="btn btn-sm btn-info mr-1">Detail</a>
                        @if($v->publish_status == 0)
                            <form method="POST" action="{{ route('adm.management.job_vacancy.approve', $v->id_jobvacancy) }}" class="mr-1">@csrf<button class="btn btn-sm btn-success">Setujui</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $vacancies->links() }}
</div>
@endsection
