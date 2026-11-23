@extends('layouts.main')
@section('title', 'Sertifikasi LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Pengajuan Sertifikasi LPK</h4>
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Ajukan Sertifikasi Baru</h6>
                <form method="POST" action="{{ route('lpk.certification.store') }}">
                    @csrf
                    <input type="text" name="name_certification" class="form-control mb-2" placeholder="Nama Sertifikasi" required>
                    <select name="vocational_id" class="form-select mb-2">@foreach($vocationals as $v)<option value="{{ $v->id_vocational }}">{{ $v->name_vocational }}</option>@endforeach</select>
                    <input type="number" name="totalh_certification" class="form-control mb-2" placeholder="Total Jam Pelatihan" required>
                    <input type="date" name="date_certification" class="form-control mb-2" required>
                    <input type="text" name="loc_certification" class="form-control mb-2" placeholder="Lokasi Uji" required>
                    <label class="form-label small">Pilih Peserta (Opsional)</label>
                    <select name="participant_ids[]" class="form-select mb-2" multiple size="4">
                        @foreach($jobseekers as $js)<option value="{{ $js->id }}">{{ $js->full_name }} ({{ $js->email }})</option>@endforeach
                    </select>
                    <button class="btn btn-primary w-100 btn-sm">Ajukan Sertifikasi</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Daftar Pengajuan Sertifikasi</h6>
                @forelse($certifications as $c)
                    @php($st = \App\Support\SidutaConstants::certificationStatusLabel((int)$c->process_status))
                    <div class="border-bottom py-2 d-flex justify-content-between">
                        <div>
                            <div class="fw-semibold">{{ $c->name_certification }}</div>
                            <small class="text-muted">{{ $c->vocational?->name_vocational ?? '-' }} &middot; {{ $c->participants_count }} peserta</small>
                        </div>
                        <span class="badge bg-{{ $st['badge'] }} align-self-center">{{ $st['label'] }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Belum ada pengajuan sertifikasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
