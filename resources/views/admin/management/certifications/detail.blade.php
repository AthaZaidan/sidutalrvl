@extends('layouts.admin')
@section('title', 'Detail Sertifikasi - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">{{ $certification->name_certification }}</h1>
<div class="card shadow p-4 mb-3">
    <p><strong>LPK:</strong> {{ $certification->lpk?->name_lpk ?? '-' }} | <strong>Kejuruan:</strong> {{ $certification->vocational?->name_vocational ?? '-' }}</p>
    <p><strong>Peserta:</strong></p>
    <ul>
        @foreach($certification->participants as $p)
            <li>{{ $p->user?->full_name ?? '-' }} — Kode: <code>{{ $p->certification_code ?? 'Belum terbit' }}</code></li>
        @endforeach
    </ul>
    <div class="d-flex">
        @if($certification->process_status < 5)
            <form method="POST" action="{{ route('adm.management.certification.advance', $certification->id_certification) }}" class="mr-2">@csrf
                <button class="btn btn-success btn-sm">Setujui Tahap Ini</button>
            </form>
            <form method="POST" action="{{ route('adm.management.certification.reject', $certification->id_certification) }}" class="form-inline">@csrf
                <input type="text" name="reason" class="form-control form-control-sm mr-1" placeholder="Alasan tolak" required>
                <button class="btn btn-danger btn-sm">Tolak</button>
            </form>
        @endif
    </div>
</div>
@endsection
