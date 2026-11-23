@extends('layouts.main')
@section('title', 'Cek Keaslian Sertifikat - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width:680px;">
        <h4 class="fw-bold mb-3">Verifikasi Keaslian Sertifikat Pelatihan / Kompetensi</h4>
        <form method="GET" action="{{ route('main.certificate.index') }}" class="input-group mb-4">
            <input type="text" name="code" class="form-control" placeholder="Contoh: SIDUTA-CERT-2026-0001" value="{{ $code }}">
            <button class="btn btn-primary">Periksa</button>
        </form>

        @if($code !== '')
            @if($record)
                <div class="alert alert-success">
                    <h5 class="fw-bold mb-2"><i class="fas fa-check-circle me-1"></i> Sertifikat Terverifikasi Asli</h5>
                    <p class="mb-1"><strong>Kode Sertifikat:</strong> {{ $record->certification_code }}</p>
                    <p class="mb-1"><strong>Nama Peserta:</strong> {{ $record->user?->full_name ?? '-' }}</p>
                    <p class="mb-1"><strong>Program:</strong> {{ $record->certification?->name_certification ?? '-' }}</p>
                    <p class="mb-1"><strong>LPK Penyelenggara:</strong> {{ $record->certification?->lpk?->name_lpk ?? '-' }}</p>
                    <p class="mb-0"><strong>Tanggal:</strong> {{ \App\Support\DateHelper::tglIndo($record->certification?->date_certification) }}</p>
                </div>
            @else
                <div class="alert alert-danger">Kode sertifikat <strong>{{ $code }}</strong> tidak ditemukan.</div>
            @endif
        @endif
    </div>
</div>
@endsection
