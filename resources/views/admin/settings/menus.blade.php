@extends('layouts.admin')
@section('title', 'Pengaturan Menu - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Pengaturan Menu Navbar</h1>
<div class="card shadow p-3">
    <form method="POST" action="{{ route('adm.settings.menu.store') }}" class="form-inline mb-3">
        @csrf
        <input type="text" name="menu" class="form-control mr-2" placeholder="Nama Menu" required>
        <input type="number" name="position" class="form-control mr-2" placeholder="Urutan" value="10" required>
        <button class="btn btn-primary">Tambah Menu</button>
    </form>
    <table class="table table-bordered table-sm">
        <thead><tr><th>ID</th><th>Menu</th><th>Posisi</th></tr></thead>
        <tbody>@foreach($menus as $m)<tr><td>{{ $m->id }}</td><td>{{ $m->menu }}</td><td>{{ $m->position }}</td></tr>@endforeach</tbody>
    </table>
</div>
@endsection
