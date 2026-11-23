@extends('layouts.auth')
@section('title', 'Pendidikan Pencari Kerja (Langkah 4/4)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Data Pendidikan Terakhir</h4>
            <span class="badge bg-primary">Langkah 4 / 4</span>
        </div>
        <form method="POST" action="{{ route('jobseeker.register.step4.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tingkat Pendidikan</label>
                    <select name="education_level" class="form-select" required>
                        @foreach($educationLevels as $ed)
                            <option value="{{ $ed->id_educationlevel }}">{{ $ed->name_educationlevel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Institusi (Sekolah / Universitas)</label>
                    <select name="educational_institutions" class="form-select" required>
                        <optgroup label="Universitas">
                            @foreach($universities as $u)
                                <option value="{{ $u->id_university }}">{{ $u->name_university }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Sekolah">
                            @foreach($schools as $s)
                                <option value="{{ $s->id_school }}">{{ $s->name_school }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jurusan</label>
                    <input type="text" name="major" class="form-control" value="{{ old('major') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="text" name="end_period" class="form-control" maxlength="4" value="{{ old('end_period', date('Y')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">IPK / Nilai</label>
                    <input type="number" step="0.01" name="ipk" class="form-control" value="{{ old('ipk', '3.50') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100 mt-4 fw-bold">Selesaikan Pendaftaran</button>
        </form>
    </div>
</div>
@endsection
