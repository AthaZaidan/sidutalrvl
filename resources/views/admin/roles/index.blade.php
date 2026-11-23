@extends('layouts.admin')
@section('title', 'Manajemen Role - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Role</h1>
<div class="card shadow mb-4 p-3">
    <form method="POST" action="{{ route('adm.administrator.role.store') }}" class="form-inline mb-3">
        @csrf
        <input type="text" name="role" class="form-control mr-2" placeholder="Nama Role Baru" required>
        <button class="btn btn-primary">Tambah Role</button>
    </form>
    <table class="table table-bordered table-sm">
        <thead><tr><th>ID</th><th>Nama Role</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td>{{ $r->id_role }}</td>
                    <td>{{ $r->role }}</td>
                    <td class="d-flex">
                        <a href="{{ route('adm.administrator.roleaccess', $r->id_role) }}" class="btn btn-sm btn-warning mr-1">Hak Akses Menu</a>
                        @if($r->id_role > 2)
                            <form method="POST" action="{{ route('adm.administrator.role.destroy', $r->id_role) }}">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
