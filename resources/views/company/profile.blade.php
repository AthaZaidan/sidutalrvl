@extends('layouts.main')
@section('title', 'Profil Perusahaan - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-3">Profil Perusahaan</h4>
        <form method="POST" action="{{ route('company.profile.update') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Badan Usaha</label>
                    <select name="badanusaha_company" class="form-select">
                        @foreach($badanUsaha as $b)
                            <option value="{{ $b->id_badanusaha }}" @selected($company->badanusaha_company == $b->id_badanusaha)>{{ $b->name_badanusaha }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8"><label class="form-label">Nama Perusahaan</label><input type="text" name="name_company" class="form-control" value="{{ $company->name_company }}" required></div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category_company" class="form-select">
                        @foreach($categories as $c)
                            <option value="{{ $c->id_category }}" @selected($company->category_company == $c->id_category)>{{ $c->name_category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">No. Telepon</label><input type="text" name="hp_company" class="form-control" value="{{ $company->hp_company }}" required></div>
                <div class="col-md-6"><label class="form-label">Penanggung Jawab</label><input type="text" name="pj_company" class="form-control" value="{{ $company->pj_company }}" required></div>
                <div class="col-md-6"><label class="form-label">Kontak PIC</label><input type="text" name="cp_penanggungjawab" class="form-control" value="{{ $company->cp_penanggungjawab }}" required></div>
                <div class="col-md-6"><label class="form-label">NPWP</label><input type="text" name="npwp_company" class="form-control" value="{{ $company->npwp_company }}"></div>
                <div class="col-md-6"><label class="form-label">NIB</label><input type="text" name="nib_company" class="form-control" value="{{ $company->nib_company }}"></div>
                <div class="col-12"><label class="form-label">Alamat</label><input type="text" name="address_company" class="form-control" value="{{ $company->address_company }}" required></div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan Profil</button>
        </form>
    </div>
</div>
@endsection
