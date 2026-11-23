@extends('layouts.main')
@section('title', 'Notifikasi - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Notifikasi Anda</h4>
    <div class="card shadow-sm border-0">
        <div class="list-group list-group-flush">
            @forelse($notifications as $notif)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold">{{ $notif->desc_notif }}</div>
                        <small class="text-muted">{{ \App\Support\DateHelper::diffForHumansId($notif->created_notif) }}</small>
                    </div>
                    @if($notif->status_read === '0')
                        <span class="badge bg-primary">Baru</span>
                    @endif
                </div>
            @empty
                <div class="list-group-item text-muted">Belum ada notifikasi.</div>
            @endforelse
        </div>
    </div>
    <div class="mt-3">{{ $notifications->links() }}</div>
</div>
@endsection
