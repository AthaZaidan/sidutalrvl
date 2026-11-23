@extends('layouts.main')
@section('title', 'Ajukan Pelatihan LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-3">Ajukan Pelatihan Kerja</h4>
        <form method="POST" action="{{ route('lpk.training.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul Pelatihan</label><input type="text" name="title_training" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label">Kota</label><select name="city_training" class="form-select">@foreach($cities as $c)<option value="{{ $c->id_city }}">{{ $c->city_name }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">Metode</label><select name="method_training" class="form-select"><option value="1">Offline</option><option value="2">Online</option><option value="3">Hybrid</option></select></div>
                <div class="col-md-4"><label class="form-label">Tanggal Mulai</label><input type="date" name="date_training" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Batas Pendaftaran</label><input type="date" name="deadline_training" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Durasi (Hari)</label><input type="number" name="duration_training" class="form-control" value="30" required></div>
                <div class="col-md-6"><label class="form-label">Biaya (0 = Gratis)</label><input type="text" name="price_training" class="form-control" value="0"></div>
                <div class="col-md-6"><label class="form-label">Lokasi Pelaksanaan</label><input type="text" name="place_training" class="form-control"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="desc_training" class="form-control" rows="4" required></textarea></div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan & Ajukan</button>
        </form>
    </div>
</div>
@endsection
