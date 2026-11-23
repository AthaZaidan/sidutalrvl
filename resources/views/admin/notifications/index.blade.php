@extends('layouts.admin')
@section('title', 'Notifikasi Admin - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Notifikasi Sistem</h1>
<div class="card shadow p-3">
    <ul class="list-group list-group-flush">
        @forelse($notifications as $n)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $n->desc_notif }}</span>
                <small class="text-muted">{{ $n->created_notif }}</small>
            </li>
        @empty
            <li class="list-group-item text-muted">Belum ada notifikasi.</li>
        @endforelse
    </ul>
    <div class="mt-3">{{ $notifications->links() }}</div>
</div>
@endsection
