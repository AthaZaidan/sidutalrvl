@extends('layouts.admin')
@section('title', 'Edit Profil Admin - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Profil</h1>
<div class="card shadow p-4">
    <form method="POST" action="{{ route('adm.user.update') }}">
        @csrf
        <div class="form-group"><label>Nama Depan</label><input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required></div>
        <div class="form-group"><label>Nama Belakang</label><input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}"></div>
        <div class="form-group"><label>No. HP</label><input type="text" name="no_handphone" class="form-control" value="{{ $user->no_handphone }}"></div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
