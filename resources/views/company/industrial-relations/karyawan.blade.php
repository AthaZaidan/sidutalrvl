@extends('layouts.main')
@section('title', 'Data Karyawan Perusahaan - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Data Karyawan Perusahaan</h4>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Tambah Karyawan</h6>
                <form method="POST" action="{{ route('company.hi.karyawan.store') }}">
                    @csrf
                    <input type="text" name="identity" class="form-control mb-2" placeholder="NIK" required>
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
                    <select name="sex" class="form-select mb-2"><option value="1">Laki-laki</option><option value="2">Perempuan</option></select>
                    <input type="text" name="tmpt_lahir" class="form-control mb-2" placeholder="Tempat Lahir" required>
                    <input type="date" name="tgl_lahir" class="form-control mb-2" required>
                    <input type="text" name="jabatan" class="form-control mb-2" placeholder="Jabatan" required>
                    <select name="education" class="form-select mb-2">@foreach($educationLevels as $ed)<option value="{{ $ed->id_educationlevel }}">{{ $ed->name_educationlevel }}</option>@endforeach</select>
                    <input type="number" name="salary" class="form-control mb-2" placeholder="Gaji (Rp)" required>
                    <div class="form-check"><input type="checkbox" name="is_bpjs_tk" value="1" class="form-check-input" id="bpjstk"><label for="bpjstk" class="form-check-label small">Terdaftar BPJS TK</label></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_bpjs_kesehatan" value="1" class="form-check-input" id="bpjsks"><label for="bpjsks" class="form-check-label small">Terdaftar BPJS Kesehatan</label></div>
                    <button class="btn btn-primary w-100 btn-sm">Simpan Karyawan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-3">
                <table class="table table-sm">
                    <thead><tr><th>NIK</th><th>Nama</th><th>Jabatan</th><th>Gaji</th><th>BPJS</th></tr></thead>
                    <tbody>
                        @foreach($employees as $emp)
                            <tr>
                                <td>{{ $emp->identity }}</td>
                                <td>{{ $emp->nama }}</td>
                                <td>{{ $emp->jabatan }}</td>
                                <td>{{ \App\Support\DateHelper::formatRupiah($emp->salary) }}</td>
                                <td>
                                    @if($emp->is_bpjs_tk)<span class="badge bg-success">TK</span>@endif
                                    @if($emp->is_bpjs_kesehatan)<span class="badge bg-info text-dark">KS</span>@endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
