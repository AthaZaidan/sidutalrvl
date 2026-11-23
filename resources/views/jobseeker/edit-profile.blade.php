@extends('layouts.main')
@section('title', 'Edit Profil Pencari Kerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Ubah Data Profil</h5>
                <form method="POST" action="{{ route('jobseeker.profile.update') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Depan</label><input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required></div>
                        <div class="col-md-6"><label class="form-label">Nama Belakang</label><input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}"></div>
                        <div class="col-md-6"><label class="form-label">No. Handphone</label><input type="text" name="no_handphone" class="form-control" value="{{ $user->no_handphone }}" required></div>
                        <div class="col-md-6"><label class="form-label">Kecamatan</label><input type="text" name="district" class="form-control" value="{{ $user->district }}"></div>
                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2" required>{{ $user->address }}</textarea></div>
                        <div class="col-md-6">
                            <label class="form-label">Bidang Pekerjaan</label>
                            <select name="job_field" class="form-select">
                                @foreach($jobFields as $jf)
                                    <option value="{{ $jf->id_jobfield }}" @selected($user->job_field == $jf->id_jobfield)>{{ $jf->name_jobfield }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="education_level" class="form-select">
                                @foreach($educationLevels as $ed)
                                    <option value="{{ $ed->id_educationlevel }}" @selected($user->education_level == $ed->id_educationlevel)>{{ $ed->name_educationlevel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keahlian</label>
                            @php($userSkillIds = $user->skills->pluck('id_skill')->all())
                            <div class="row">
                                @foreach($skills as $sk)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $sk->id_skill }}" @checked(in_array($sk->id_skill, $userSkillIds))>
                                            <label class="form-check-label small">{{ $sk->name_skill }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 mb-3">
                <h6 class="fw-bold mb-2">Tambah Pengalaman Kerja</h6>
                <form method="POST" action="{{ route('jobseeker.experience.store') }}">
                    @csrf
                    <input type="text" name="position" class="form-control mb-2" placeholder="Jabatan" required>
                    <input type="text" name="company" class="form-control mb-2" placeholder="Perusahaan" required>
                    <input type="text" name="time" class="form-control mb-2" placeholder="Periode (cth: 2022 - 2024)" required>
                    <button class="btn btn-sm btn-outline-primary">Tambah</button>
                </form>
            </div>
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold mb-2">Unggah Dokumen (CV / Ijazah / Sertifikat)</h6>
                <form method="POST" action="{{ route('jobseeker.file.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" class="form-control mb-2" placeholder="Judul Berkas" required>
                    <select name="type" class="form-select mb-2">
                        <option value="1">CV / Resume</option>
                        <option value="2">Ijazah</option>
                        <option value="3">Sertifikat</option>
                    </select>
                    <input type="file" name="file" class="form-control mb-2" required>
                    <button class="btn btn-sm btn-outline-success">Unggah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
