@extends('layouts.auth')
@section('title', 'Daftar Perusahaan (Langkah 1/2)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Registrasi Perusahaan</h4>
            <span class="badge bg-primary">Langkah 1 / 2</span>
        </div>
        <form method="POST" action="{{ route('company.register.step1.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Badan Usaha</label>
                    <select name="badanusaha_company" class="form-select" required>
                        @foreach($badanUsaha as $bu)
                            <option value="{{ $bu->id_badanusaha }}">{{ $bu->name_badanusaha }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Perusahaan</label>
                    <input type="text" name="name_company" class="form-control" value="{{ old('name_company') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori Perusahaan</label>
                    <select name="category_company" class="form-select" required>
                        @foreach($categories as $c)
                            <option value="{{ $c->id_category }}">{{ $c->name_category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Perusahaan</label>
                    <input type="email" name="email_company" class="form-control" value="{{ old('email_company') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon Perusahaan</label>
                    <input type="text" name="hp_company" class="form-control" value="{{ old('hp_company') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Penanggung Jawab (PIC)</label>
                    <input type="text" name="pj_company" class="form-control" value="{{ old('pj_company') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kontak PIC</label>
                    <input type="text" name="cp_penanggungjawab" class="form-control" value="{{ old('cp_penanggungjawab') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat Perusahaan</label>
                    <input type="text" name="address_company" class="form-control" value="{{ old('address_company') }}" required>
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
            <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold">Lanjut ke Dokumen Legalitas</button>
        </form>
    </div>
</div>
@endsection
