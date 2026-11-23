@extends('layouts.admin')
@section('title', 'Detail AK-1 - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Detail Pengajuan AK-1 #{{ $ak1->id_ak1 }}</h1>
<div class="card shadow p-4">
    <p><strong>Nama:</strong> {{ $ak1->user?->full_name }} | <strong>NIK:</strong> {{ $ak1->user?->nik }}</p>
    <p><strong>Pendidikan:</strong> {{ $ak1->user?->educationLevel?->name_educationlevel ?? '-' }} ({{ $ak1->user?->major ?? '-' }})</p>
    <p><strong>Pekerjaan Diinginkan:</strong> {{ $ak1->desiredJob?->position ?? '-' }} ({{ $ak1->desiredJob?->placement ?? '-' }})</p>
    <hr>
    <div class="d-flex">
        <form method="POST" action="{{ route('adm.management.ak1.validate', $ak1->id_ak1) }}" class="mr-2">@csrf
            <button class="btn btn-success btn-sm">Setujui / Teruskan AK-1</button>
        </form>
        <form method="POST" action="{{ route('adm.management.ak1.decline', $ak1->id_ak1) }}" class="form-inline">@csrf
            <input type="text" name="notes_penolakan" class="form-control form-control-sm mr-1" placeholder="Catatan penolakan" required>
            <button class="btn btn-danger btn-sm">Tolak</button>
        </form>
    </div>
</div>
@endsection
