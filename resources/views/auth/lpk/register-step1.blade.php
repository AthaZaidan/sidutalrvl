@extends('layouts.auth')
@section('title', 'Daftar LPK (Langkah 1/2)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Registrasi LPK</h4>
            <span class="badge bg-primary">Langkah 1 / 2</span>
        </div>
        <form method="POST" action="{{ route('lpk.register.step1.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama LPK</label>
                    <input type="text" name="name_lpk" class="form-control" value="{{ old('name_lpk') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Pimpinan</label>
                    <input type="text" name="name_leader" class="form-control" value="{{ old('name_leader') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email LPK</label>
                    <input type="email" name="email_lpk" class="form-control" value="{{ old('email_lpk') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. VIN</label>
                    <input type="text" name="no_vin" class="form-control" value="{{ old('no_vin') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon LPK</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP Pimpinan</label>
                    <input type="text" name="nohp_pimpinan" class="form-control" value="{{ old('nohp_pimpinan') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Potensial Sektor</label>
                    <select name="potential_sector_id" class="form-select" required>
                        @foreach($sectors as $s)
                            <option value="{{ $s->id_sector }}">{{ $s->name_sector }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat LPK</label>
                    <input type="text" name="address_lpk" class="form-control" value="{{ old('address_lpk') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold">Lanjut ke Dokumen Perizinan</button>
        </form>
    </div>
</div>
@endsection
