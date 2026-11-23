@extends('layouts.admin')
@section('title', 'Penempatan Pencaker (TKDN & CPMI) - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Penempatan Pencaker (TKDN & TKA/CPMI)</h1>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow p-3 mb-3">
            <h5>Penempatan Dalam Negeri (TKDN)</h5>
            <form method="POST" action="{{ route('adm.management.placement.tkdn.store') }}" class="row mb-3">
                @csrf
                <div class="col-6 mb-1"><input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama" required></div>
                <div class="col-6 mb-1"><input type="text" name="nik" class="form-control form-control-sm" placeholder="NIK" required></div>
                <div class="col-5 mb-1"><input type="text" name="jabatan" class="form-control form-control-sm" placeholder="Jabatan" required></div>
                <div class="col-5 mb-1"><input type="text" name="company_name" class="form-control form-control-sm" placeholder="Perusahaan" required></div>
                <div class="col-2 mb-1"><input type="text" name="year" class="form-control form-control-sm" value="{{ date('Y') }}" required></div>
                <div class="col-12"><button class="btn btn-sm btn-primary">Tambah TKDN</button></div>
            </form>
            <table class="table table-sm table-bordered">
                <thead><tr><th>Nama</th><th>Jabatan</th><th>Perusahaan</th><th>Tahun</th></tr></thead>
                <tbody>@foreach($tkdn as $r)<tr><td>{{ $r->nama }}</td><td>{{ $r->jabatan }}</td><td>{{ $r->company_name }}</td><td>{{ $r->year }}</td></tr>@endforeach</tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow p-3 mb-3">
            <h5>Penempatan Luar Negeri (CPMI/TKA)</h5>
            <form method="POST" action="{{ route('adm.management.placement.tka.store') }}" class="row mb-3">
                @csrf
                <div class="col-6 mb-1"><input type="text" name="name_cpmi" class="form-control form-control-sm" placeholder="Nama CPMI" required></div>
                <div class="col-6 mb-1"><input type="text" name="country_of_destination" class="form-control form-control-sm" placeholder="Negara Tujuan" required></div>
                <div class="col-5 mb-1"><input type="text" name="jabatan" class="form-control form-control-sm" placeholder="Jabatan"></div>
                <div class="col-5 mb-1"><input type="text" name="company" class="form-control form-control-sm" placeholder="P3MI/Perusahaan" required></div>
                <div class="col-2 mb-1"><input type="text" name="year" class="form-control form-control-sm" value="{{ date('Y') }}" required></div>
                <div class="col-12"><button class="btn btn-sm btn-primary">Tambah CPMI</button></div>
            </form>
            <table class="table table-sm table-bordered">
                <thead><tr><th>Nama</th><th>Negara</th><th>Perusahaan</th><th>Tahun</th></tr></thead>
                <tbody>@foreach($tka as $t)<tr><td>{{ $t->name_cpmi }}</td><td>{{ $t->country_of_destination }}</td><td>{{ $t->company }}</td><td>{{ $t->year }}</td></tr>@endforeach</tbody>
            </table>
        </div>
    </div>
</div>
@endsection
