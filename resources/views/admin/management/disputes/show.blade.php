@extends('layouts.admin')
@section('title', 'Detail Perselisihan - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Detail Perselisihan #{{ $dispute->id }}</h1>
<div class="row">
    <div class="col-md-7">
        <div class="card shadow p-4 mb-3">
            <p><strong>Kategori:</strong> {{ $dispute->title }}</p>
            <p><strong>Pelapor:</strong> {{ $dispute->nama }} (NIK: {{ $dispute->nik }})</p>
            <p><strong>Perusahaan:</strong> {{ $dispute->company }}</p>
            <p><strong>Uraian:</strong> {{ $dispute->description }}</p>
            <hr>
            <form method="POST" action="{{ route('adm.management.dispute.process', $dispute->id) }}" class="mb-2">@csrf
                <input type="hidden" name="action" value="accept_psp">
                <button class="btn btn-sm btn-primary">1. Verifikasi Admin PSP</button>
            </form>
            <form method="POST" action="{{ route('adm.management.dispute.process', $dispute->id) }}" class="form-inline mb-2">@csrf
                <input type="hidden" name="action" value="assign_mediator">
                <select name="mediator" class="form-control form-control-sm mr-2">@foreach($mediators as $m)<option value="{{ $m->id }}">{{ $m->full_name }}</option>@endforeach</select>
                <button class="btn btn-sm btn-warning">2. Tugaskan Mediator</button>
            </form>
            <form method="POST" action="{{ route('adm.management.dispute.process', $dispute->id) }}" class="mb-2">@csrf
                <input type="hidden" name="action" value="solved">
                <div class="input-group input-group-sm">
                    <input type="text" name="solving_description" class="form-control" placeholder="Hasil penyelesaian mediasi..." required>
                    <div class="input-group-append"><button class="btn btn-success">3. Tandai Selesai</button></div>
                </div>
            </form>
            <form method="POST" action="{{ route('adm.management.dispute.process', $dispute->id) }}">@csrf
                <input type="hidden" name="action" value="finish">
                <button class="btn btn-sm btn-dark">4. Tutup Kasus (KABID)</button>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow p-4">
            <h5>Timeline Penanganan</h5>
            <ul class="small pl-3">
                @foreach($dispute->logs as $lg)
                    <li><strong>{{ $lg->created }}</strong>: {{ $lg->action }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
