@extends('layouts.main')
@section('title', 'Ajukan Pemagangan - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-3">Ajukan Program Pemagangan</h4>
        <form method="POST" action="{{ route('company.internship.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul Pemagangan</label><input type="text" name="title_intern" class="form-control" required></div>
                <div class="col-md-3">
                    <label class="form-label">Bidang</label>
                    <select name="jobfield_intern" class="form-select">@foreach($jobFields as $jf)<option value="{{ $jf->id_jobfield }}">{{ $jf->name_jobfield }}</option>@endforeach</select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sub Bidang</label>
                    <select name="subjobfield_intern" class="form-select">@foreach($subJobFields as $sj)<option value="{{ $sj->id_subjobfield }}">{{ $sj->name_subjobfield }}</option>@endforeach</select>
                </div>
                <div class="col-md-4"><label class="form-label">Kota</label><select name="city_intern" class="form-select">@foreach($cities as $c)<option value="{{ $c->id_city }}">{{ $c->city_name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Min. Pendidikan</label><select name="min_edu_level" class="form-select">@foreach($educationLevels as $ed)<option value="{{ $ed->id_educationlevel }}">{{ $ed->name_educationlevel }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Durasi (Bulan)</label><input type="number" name="length_intern" class="form-control" value="3" required></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="desc_intern" class="form-control" rows="4" required></textarea></div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan & Ajukan</button>
        </form>
    </div>
</div>
@endsection
