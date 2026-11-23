@extends('layouts.auth')
@section('title', 'Spesialisasi Pencari Kerja (Langkah 3/4)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Spesialisasi & Keahlian</h4>
            <span class="badge bg-primary">Langkah 3 / 4</span>
        </div>
        <form method="POST" action="{{ route('jobseeker.register.step3.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Bidang Pekerjaan</label>
                <select name="job_field" class="form-select" required>
                    @foreach($jobFields as $jf)
                        <option value="{{ $jf->id_jobfield }}">{{ $jf->name_jobfield }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Sub Bidang Pekerjaan</label>
                <select name="sub_job_field" class="form-select" required>
                    @foreach($subJobFields as $sjf)
                        <option value="{{ $sjf->id_subjobfield }}">{{ $sjf->name_subjobfield }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Keahlian / Skills</label>
                <div class="row">
                    @foreach($skills as $sk)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $sk->id_skill }}" id="sk_{{ $sk->id_skill }}">
                                <label class="form-check-label small" for="sk_{{ $sk->id_skill }}">{{ $sk->name_skill }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan & Lanjut</button>
        </form>
    </div>
</div>
@endsection
