@extends('layouts.admin')
@section('title', 'Profil Saya - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Profil Petugas / Admin</h1>
<div class="card shadow p-4">
    <p><strong>Nama:</strong> {{ $user->full_name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role?->role ?? '-' }}</p>
    <p><strong>No. HP:</strong> {{ $user->no_handphone ?? '-' }}</p>
    <div>
        <a href="{{ route('adm.user.edit') }}" class="btn btn-primary btn-sm">Edit Profil</a>
        <a href="{{ route('adm.user.changepassword') }}" class="btn btn-warning btn-sm">Ubah Password</a>
    </div>
</div>
@endsection
