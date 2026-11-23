@extends('layouts.main')
@section('title', 'Pengaduan Perselisihan Hubungan Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-3">Formulir Pengaduan Perselisihan Hubungan Kerja</h4>
                <form method="POST" action="{{ route('main.dispute.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori Perselisihan</label>
                            <select name="title" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelapor</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" value="{{ old('nik') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="hp" class="form-control" value="{{ old('hp') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Perusahaan</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Pelapor</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Perusahaan</label>
                            <input type="text" name="address_company" class="form-control" value="{{ old('address_company') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kronologi / Uraian Perselisihan</label>
                            <textarea name="description" class="form-control" rows="3" maxlength="256" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Pendukung (PDF/Gambar, maks 5MB)</label>
                            <input type="file" name="evidence" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 fw-bold">Kirim Pengaduan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 p-4 mb-3">
                <h5 class="fw-bold mb-3">Lacak Status Pengaduan</h5>
                <form method="GET" action="{{ route('main.dispute.index') }}" class="input-group mb-3">
                    <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK Pelapor..." value="{{ request('nik') }}">
                    <button class="btn btn-outline-primary">Cek</button>
                </form>
                @forelse($trackedDisputes as $d)
                    @php($st = \App\Support\SidutaConstants::disputeStatusLabel((int)$d->status))
                    <div class="border rounded p-3 mb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <strong>{{ $d->title }}</strong>
                            <span class="badge bg-{{ $st['badge'] }}">{{ $st['label'] }}</span>
                        </div>
                        <div class="small text-muted">{{ $d->company }} &middot; {{ $d->description }}</div>
                        @if($d->logs->isNotEmpty())
                            <ul class="small mt-2 mb-0 ps-3">
                                @foreach($d->logs as $lg)
                                    <li>{{ $lg->action }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @empty
                    <p class="small text-muted mb-0">Masukkan NIK untuk melihat riwayat pengaduan Anda.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
