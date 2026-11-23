@extends('layouts.main')
@section('title', ($vacancy ? 'Edit' : 'Ajukan') . ' Lowongan Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-3">{{ $vacancy ? 'Edit Lowongan Kerja' : 'Ajukan Lowongan Kerja Baru' }}</h4>
        <form method="POST" action="{{ $vacancy ? route('company.job_vacancy.update', $vacancy->id_jobvacancy) : route('company.job_vacancy.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul Lowongan</label><input type="text" name="title_jobvacancy" class="form-control" value="{{ old('title_jobvacancy', $vacancy?->title_jobvacancy) }}" required></div>
                <div class="col-md-3">
                    <label class="form-label">Bidang Pekerjaan</label>
                    <select name="jobfield_vacancy" class="form-select" required>
                        @foreach($jobFields as $jf)
                            <option value="{{ $jf->id_jobfield }}" @selected(old('jobfield_vacancy', $vacancy?->jobfield_vacancy) == $jf->id_jobfield)>{{ $jf->name_jobfield }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sub Bidang</label>
                    <select name="subjobfield_vacancy" class="form-select" required>
                        @foreach($subJobFields as $sjf)
                            <option value="{{ $sjf->id_subjobfield }}" @selected(old('subjobfield_vacancy', $vacancy?->subjobfield_vacancy) == $sjf->id_subjobfield)>{{ $sjf->name_subjobfield }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kota Penempatan</label>
                    <select name="city_vacancy" class="form-select" required>
                        @foreach($cities as $c)
                            <option value="{{ $c->id_city }}" @selected(old('city_vacancy', $vacancy?->city_vacancy) == $c->id_city)>{{ $c->city_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Minimal Pendidikan</label>
                    <select name="education_level" class="form-select">
                        @foreach($educationLevels as $ed)
                            <option value="{{ $ed->id_educationlevel }}" @selected(old('education_level', $vacancy?->education_level) == $ed->id_educationlevel)>{{ $ed->name_educationlevel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Pengalaman (Tahun)</label><input type="number" name="experience_vacancy" class="form-control" value="{{ old('experience_vacancy', $vacancy?->experience_vacancy ?? 0) }}" required></div>
                <div class="col-md-4"><label class="form-label">Gaji Awal (Rp)</label><input type="text" name="salary_start" class="form-control" value="{{ old('salary_start', $vacancy?->salary_start ?? '3800000') }}"></div>
                <div class="col-md-4"><label class="form-label">Gaji Akhir (Rp)</label><input type="text" name="salary_end" class="form-control" value="{{ old('salary_end', $vacancy?->salary_end ?? '5000000') }}"></div>
                <div class="col-md-4"><label class="form-label">Batas Lamaran</label><input type="date" name="deadline_vacancy" class="form-control" value="{{ old('deadline_vacancy', $vacancy?->deadline_vacancy) }}"></div>
                <div class="col-12"><label class="form-label">Deskripsi Pekerjaan</label><textarea name="desc_vacancy" class="form-control" rows="4" required>{{ old('desc_vacancy', $vacancy?->desc_vacancy) }}</textarea></div>
                <div class="col-md-6">
                    <label class="form-label">Keahlian</label>
                    @php($selectedSkills = $vacancy ? $vacancy->skills->pluck('id_skill')->all() : [])
                    <div class="border rounded p-2" style="max-height:160px;overflow-y:auto;">
                        @foreach($skills as $sk)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $sk->id_skill }}" @checked(in_array($sk->id_skill, $selectedSkills))>
                                <label class="form-check-label small">{{ $sk->name_skill }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ramah Disabilitas?</label>
                    <select name="disability_status" class="form-select mb-2">
                        <option value="0" @selected(old('disability_status', $vacancy?->disability_status) == 0)>Tidak</option>
                        <option value="1" @selected(old('disability_status', $vacancy?->disability_status) == 1)>Ya</option>
                    </select>
                    @php($selectedDis = $vacancy ? $vacancy->disabilities->pluck('id_disability')->all() : [])
                    @foreach($disabilities as $d)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="disabilities[]" value="{{ $d->id_disability }}" @checked(in_array($d->id_disability, $selectedDis))>
                            <label class="form-check-label small">{{ $d->name_disability }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4 fw-bold">Simpan Lowongan</button>
        </form>
    </div>
</div>
@endsection
