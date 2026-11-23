@extends('layouts.main')
@section('title', 'Pengajuan Kartu AK-1 - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Ajukan Pembuatan Kartu AK-1</h5>
                <form method="POST" action="{{ route('jobseeker.ak1.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Jabatan yang Diinginkan</label>
                        <input type="text" name="position" class="form-control" required placeholder="Contoh: Web Developer">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Ekspektasi Gaji (Rp)</label>
                        <input type="text" name="sallary" class="form-control" required value="5000000">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Penempatan</label>
                        <select name="placement" class="form-select">
                            <option value="Dalam Kota">Dalam Kota</option>
                            <option value="Luar Kota">Luar Kota</option>
                            <option value="Luar Negeri">Luar Negeri</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Penempatan</label>
                        <select name="location" class="form-select">
                            @foreach($cities as $c)
                                <option value="{{ $c->id_city }}">{{ $c->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Kirim Pengajuan AK-1</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Riwayat Pengajuan Kartu AK-1</h5>
                @forelse($ak1List as $ak)
                    @php($st = \App\Support\SidutaConstants::ak1StatusLabel((int)$ak->process_status))
                    <div class="border rounded p-3 mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">AK-1 #{{ $ak->id_ak1 }} - {{ $ak->desiredJob?->position ?? '-' }}</div>
                            <span class="badge bg-{{ $st['badge'] }}">{{ $st['label'] }}</span>
                            @if($ak->decline_reason)
                                <div class="small text-danger mt-1">Catatan: {{ $ak->decline_reason }}</div>
                            @endif
                        </div>
                        <a href="{{ route('jobseeker.ak1.cetak', $ak->id_ak1) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-print me-1"></i> Cetak AK-1
                        </a>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Anda belum memiliki pengajuan AK-1.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
