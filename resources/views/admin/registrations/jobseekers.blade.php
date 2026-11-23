@extends('layouts.admin')
@section('title', 'Registrasi Angkatan Kerja - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Daftar Registrasi Angkatan Kerja</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Nama</th><th>NIK</th><th>Email</th><th>Status Reg</th><th>Aktif</th></tr></thead>
        <tbody>
            @foreach($users as $u)
                <tr><td>{{ $u->full_name }}</td><td>{{ $u->nik ?? '-' }}</td><td>{{ $u->email }}</td><td>{{ $u->reg_status == 3 ? 'Lengkap' : 'Tahap ' . $u->reg_status }}</td><td>{{ $u->is_active ? 'Ya' : 'Tidak' }}</td></tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
