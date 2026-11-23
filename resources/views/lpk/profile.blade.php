@extends('layouts.main')
@section('title', 'Profil LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-3">Profil LPK</h4>
        <form method="POST" action="{{ route('lpk.profile.update') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama LPK</label><input type="text" name="name_lpk" class="form-control" value="{{ $lpk->name_lpk }}" required></div>
                <div class="col-md-6"><label class="form-label">Nama Pimpinan</label><input type="text" name="name_leader" class="form-control" value="{{ $lpk->name_leader }}" required></div>
                <div class="col-md-6"><label class="form-label">No. Telepon</label><input type="text" name="no_telp" class="form-control" value="{{ $lpk->no_telp }}" required></div>
                <div class="col-md-6"><label class="form-label">No. HP Pimpinan</label><input type="text" name="nohp_pimpinan" class="form-control" value="{{ $lpk->nohp_pimpinan }}" required></div>
                <div class="col-md-6"><label class="form-label">Daya Tampung</label><input type="number" name="daya_tampung_lpk" class="form-control" value="{{ $lpk->daya_tampung_lpk }}"></div>
                <div class="col-md-6"><label class="form-label">Jumlah Instruktur/Staf</label><input type="number" name="count_staff" class="form-control" value="{{ $lpk->count_staff }}"></div>
                <div class="col-12"><label class="form-label">Alamat</label><input type="text" name="address_lpk" class="form-control" value="{{ $lpk->address_lpk }}" required></div>
                <div class="col-12">
                    <label class="form-label">Kejuruan</label>
                    @php($vocIds = $lpk->vocationals->pluck('id_vocational')->all())
                    <div class="row">
                        @foreach($vocationals as $v)
                            <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="vocationals[]" value="{{ $v->id_vocational }}" @checked(in_array($v->id_vocational, $vocIds))><label class="form-check-label small">{{ $v->name_vocational }}</label></div></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan Profil</button>
        </form>
    </div>
</div>
@endsection
