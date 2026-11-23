@extends('layouts.auth')
@section('title', 'Data Diri Pencari Kerja (Langkah 2/4)')
@section('content')
<div class="card shadow-sm border-0 mx-auto" style="max-width:720px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Lengkapi Data Diri</h4>
            <span class="badge bg-primary">Langkah 2 / 4</span>
        </div>
        <form method="POST" action="{{ route('jobseeker.register.step2.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIK (16 Digit)</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}" required maxlength="16">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-select" required>
                        <option value="laki-laki" @selected(old('gender', $user->gender) === 'laki-laki')>Laki-laki</option>
                        <option value="perempuan" @selected(old('gender', $user->gender) === 'perempuan')>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="place_birth" class="form-control" value="{{ old('place_birth', $user->place_birth) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Handphone / WA</label>
                    <input type="text" name="no_handphone" class="form-control" value="{{ old('no_handphone', $user->no_handphone) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Agama</label>
                    <select name="religion" class="form-select" required>
                        @foreach(['Islam','Kristen Protestan','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                            <option value="{{ $ag }}" @selected(old('religion', $user->religion) === $ag)>{{ $ag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status Perkawinan</label>
                    <select name="status" class="form-select" required>
                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $st)
                            <option value="{{ $st }}" @selected(old('status', $user->status) === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="district" class="form-control" value="{{ old('district', $user->district) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="address" class="form-control" rows="2" required>{{ old('address', $user->address) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Disabilitas (Opsional)</label>
                    <div class="row">
                        @foreach($disabilities as $d)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="disabilities[]" value="{{ $d->id_disability }}" id="dis_{{ $d->id_disability }}">
                                    <label class="form-check-label small" for="dis_{{ $d->id_disability }}">{{ $d->name_disability }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold">Simpan & Lanjut</button>
        </form>
    </div>
</div>
@endsection
