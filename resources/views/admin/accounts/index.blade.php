@extends('layouts.admin')
@section('title', 'Manajemen Akun - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Akun Pengguna</h1>
<div class="card shadow p-3 mb-4">
    <h5>Tambah Akun Petugas / Admin</h5>
    <form method="POST" action="{{ route('adm.account.staff.store') }}" class="row">
        @csrf
        <div class="col-md-2"><input type="text" name="first_name" class="form-control mb-2" placeholder="Nama Depan" required></div>
        <div class="col-md-2"><input type="text" name="last_name" class="form-control mb-2" placeholder="Nama Belakang"></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control mb-2" placeholder="Email" required></div>
        <div class="col-md-2"><select name="role_id" class="form-control mb-2">@foreach($roles as $r)<option value="{{ $r->id_role }}">{{ $r->role }}</option>@endforeach</select></div>
        <div class="col-md-2"><input type="password" name="password" class="form-control mb-2" placeholder="Password" required></div>
        <div class="col-md-1"><button class="btn btn-primary btn-block">Buat</button></div>
    </form>
</div>

<div class="card shadow p-3 mb-4">
    <h5>Daftar Petugas & Admin</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($staff as $u)
                <tr>
                    <td>{{ $u->full_name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role?->role }}</td>
                    <td>{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td><form method="POST" action="{{ route('adm.account.user.toggle', $u->id) }}">@csrf<button class="btn btn-xs btn-warning">Toggle Aktif</button></form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card shadow p-3">
    <h5>Perusahaan & LPK</h5>
    <div class="row">
        <div class="col-md-6">
            <h6>Perusahaan ({{ $companies->total() }})</h6>
            @foreach($companies as $c)
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>{{ $c->display_name }}</span>
                    <form method="POST" action="{{ route('adm.account.company.toggle', $c->id_company) }}">@csrf<button class="btn btn-xs btn-outline-primary">{{ $c->is_activecompany ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h6>LPK ({{ $lpks->total() }})</h6>
            @foreach($lpks as $l)
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>{{ $l->name_lpk }}</span>
                    <form method="POST" action="{{ route('adm.account.lpk.toggle', $l->id_lpk) }}">@csrf<button class="btn btn-xs btn-outline-primary">{{ $l->is_activelpk ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
