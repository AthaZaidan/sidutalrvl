@extends('layouts.admin')
@section('title', 'Pengaturan Submenu - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Pengaturan Submenu</h1>
<div class="card shadow p-3">
    <form method="POST" action="{{ route('adm.settings.submenu.store') }}" class="row mb-3">
        @csrf
        <div class="col-md-2"><select name="menu_id" class="form-control">@foreach($menus as $m)<option value="{{ $m->id }}">{{ $m->menu }}</option>@endforeach</select></div>
        <div class="col-md-3"><input type="text" name="title" class="form-control" placeholder="Judul" required></div>
        <div class="col-md-3"><input type="text" name="url" class="form-control" placeholder="adm/..." required></div>
        <div class="col-md-2"><input type="text" name="icon" class="form-control" value="fas fa-circle" required></div>
        <div class="col-md-2"><button class="btn btn-primary btn-block">Tambah</button></div>
    </form>
    <table class="table table-bordered table-sm">
        <thead><tr><th>Menu</th><th>Judul</th><th>URL</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($submenus as $sm)
                <tr>
                    <td>{{ $sm->menu?->menu }}</td>
                    <td>{{ $sm->title }}</td>
                    <td><code>{{ $sm->url }}</code></td>
                    <td>{{ $sm->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>
                        <form method="POST" action="{{ route('adm.settings.submenu.toggle', $sm->id) }}">@csrf
                            <button class="btn btn-sm btn-warning">Toggle</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
