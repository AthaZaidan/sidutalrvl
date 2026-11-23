@extends('layouts.admin')
@section('title', 'Ubah Password - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Ubah Password</h1>
<div class="card shadow p-4" style="max-width:500px;">
    <form method="POST" action="{{ route('adm.user.changepassword.update') }}">
        @csrf
        <div class="form-group"><label>Password Saat Ini</label><input type="password" name="current_password" class="form-control" required></div>
        <div class="form-group"><label>Password Baru</label><input type="password" name="new_password" class="form-control" required></div>
        <div class="form-group"><label>Konfirmasi Password Baru</label><input type="password" name="new_password_confirmation" class="form-control" required></div>
        <button class="btn btn-primary">Ubah Password</button>
    </form>
</div>
@endsection
