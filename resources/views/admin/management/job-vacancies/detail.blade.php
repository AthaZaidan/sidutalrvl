@extends('layouts.admin')
@section('title', 'Detail Lowongan - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">{{ $vacancy->title_jobvacancy }}</h1>
<div class="card shadow p-4 mb-3">
    <p><strong>Perusahaan:</strong> {{ $vacancy->company?->display_name ?? '-' }}</p>
    <p><strong>Bidang:</strong> {{ $vacancy->jobField?->name_jobfield ?? '-' }} / {{ $vacancy->subJobField?->name_subjobfield ?? '-' }}</p>
    <div>{!! \App\Support\HtmlSanitizer::clean($vacancy->desc_vacancy) !!}</div>
    <hr>
    <div class="d-flex">
        <form method="POST" action="{{ route('adm.management.job_vacancy.approve', $vacancy->id_jobvacancy) }}" class="mr-2">@csrf
            <button class="btn btn-success btn-sm">Setujui / Terbitkan</button>
        </form>
        <form method="POST" action="{{ route('adm.management.job_vacancy.decline', $vacancy->id_jobvacancy) }}" class="form-inline">@csrf
            <input type="text" name="reason" class="form-control form-control-sm mr-1" placeholder="Alasan penolakan" required>
            <button class="btn btn-danger btn-sm">Tolak</button>
        </form>
    </div>
</div>
@endsection
