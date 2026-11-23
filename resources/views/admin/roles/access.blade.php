@extends('layouts.admin')
@section('title', 'Hak Akses Role - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Hak Akses Menu: {{ $role->role }}</h1>
<div class="card shadow p-3">
    <table class="table table-bordered">
        <thead><tr><th>Menu</th><th>Status Akses</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($menus as $m)
                @php($has = in_array($m->id, $grantedIds))
                <tr>
                    <td>{{ $m->menu }}</td>
                    <td><span class="badge badge-{{ $has ? 'success' : 'secondary' }}">{{ $has ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('adm.administrator.role.toggle_access') }}">
                            @csrf
                            <input type="hidden" name="role_id" value="{{ $role->id_role }}">
                            <input type="hidden" name="menu_id" value="{{ $m->id }}">
                            <button class="btn btn-sm btn-{{ $has ? 'danger' : 'primary' }}">{{ $has ? 'Cabut Akses' : 'Beri Akses' }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('adm.administrator.role') }}" class="btn btn-secondary btn-sm">Kembali</a>
</div>
@endsection
