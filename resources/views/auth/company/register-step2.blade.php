@extends('layouts.auth')
@section('title', 'Legalitas Perusahaan (Langkah 2/2)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Lengkapi Legalitas Perusahaan</h4>
            <span class="badge bg-primary">Langkah 2 / 2</span>
        </div>
        <form method="POST" action="{{ route('company.register.step2.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NPWP Perusahaan</label>
                    <input type="text" name="npwp_company" class="form-control" value="{{ old('npwp_company', $company->npwp_company) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIB Perusahaan</label>
                    <input type="text" name="nib_company" class="form-control" value="{{ old('nib_company', $company->nib_company) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Direktur</label>
                    <input type="text" name="name_direktur" class="form-control" value="{{ old('name_direktur', $company->name_direktur) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jabatan Penanggung Jawab</label>
                    <input type="text" name="jabatan_pj" class="form-control" value="{{ old('jabatan_pj', $company->jabatan_pj) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Akta Pendirian (PDF/Gambar)</label>
                    <input type="file" name="akta_file" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Logo Perusahaan</label>
                    <input type="file" name="logo_file" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100 mt-4 fw-bold">Simpan & Selesai</button>
        </form>
    </div>
</div>
@endsection
