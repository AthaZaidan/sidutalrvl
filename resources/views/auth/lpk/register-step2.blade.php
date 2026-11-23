@extends('layouts.auth')
@section('title', 'Dokumen Perizinan LPK (Langkah 2/2)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Lengkapi Perizinan & Kejuruan LPK</h4>
            <span class="badge bg-primary">Langkah 2 / 2</span>
        </div>
        <form method="POST" action="{{ route('lpk.register.step2.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Izin LPK</label>
                    <input type="text" name="no_izin_lpk" class="form-control" value="{{ old('no_izin_lpk', $lpk->no_izin_lpk) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Akreditasi LPK</label>
                    <input type="text" name="no_akreditasi_lpk" class="form-control" value="{{ old('no_akreditasi_lpk', $lpk->no_akreditasi_lpk) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Daya Tampung Peserta</label>
                    <input type="number" name="daya_tampung_lpk" class="form-control" value="{{ old('daya_tampung_lpk', $lpk->daya_tampung_lpk ?? 50) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jumlah Instruktur / Staf</label>
                    <input type="number" name="count_staff" class="form-control" value="{{ old('count_staff', $lpk->count_staff ?? 5) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Kejuruan LPK</label>
                    <div class="row">
                        @foreach($vocationals as $v)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="vocationals[]" value="{{ $v->id_vocational }}" id="voc_{{ $v->id_vocational }}">
                                    <label class="form-check-label small" for="voc_{{ $v->id_vocational }}">{{ $v->name_vocational }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Izin LPK</label>
                    <input type="file" name="izin_file" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Akreditasi</label>
                    <input type="file" name="akreditasi_file" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100 mt-4 fw-bold">Simpan & Selesai</button>
        </form>
    </div>
</div>
@endsection
