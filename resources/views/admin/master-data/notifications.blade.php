@extends('layouts.admin')
@section('title', 'Akses Notifikasi - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Akses Notifikasi Per Role</h1>
<div class="card shadow p-3">
    <form method="POST" action="{{ route('adm.data.notification.store') }}" class="form-inline mb-3">
        @csrf
        <input type="number" name="id_subtype" class="form-control form-control-sm mr-2" placeholder="ID Subtype" required>
        <select name="role_id" class="form-control form-control-sm mr-2">@foreach($roles as $rid => $rname)<option value="{{ $rid }}">{{ $rname }}</option>@endforeach</select>
        <button class="btn btn-primary btn-sm">Tambah</button>
    </form>
    <table class="table table-sm table-bordered">
        <thead><tr><th>ID Subtype</th><th>Role</th></tr></thead>
        <tbody>@foreach($items as $i)<tr><td>{{ $i->id_subtype }}</td><td>{{ $roles[$i->role_id] ?? $i->role_id }}</td></tr>@endforeach</tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
