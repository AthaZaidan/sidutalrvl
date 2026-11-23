@extends('layouts.main')
@section('title', 'Peserta Pelatihan - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Peserta Pelatihan: {{ $training->title_training }}</h4>
    <div class="card border-0 shadow-sm p-3">
        <form method="POST" action="{{ route('lpk.training.close', $training->id_training) }}">
            @csrf
            <table class="table">
                <thead><tr><th>Lulus?</th><th>Nama Peserta</th><th>Email</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($applicants as $app)
                        <tr>
                            <td><input type="checkbox" name="graduated[]" value="{{ $app->user_id }}" @checked($app->is_graduated == 1)></td>
                            <td>{{ $app->user?->full_name }}</td>
                            <td>{{ $app->user?->email }}</td>
                            <td>{{ $app->is_graduated === 1 ? 'Lulus' : ($app->is_graduated === 0 ? 'Tidak Lulus' : 'Terdaftar') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <button class="btn btn-success btn-sm">Tutup Pelatihan & Simpan Kelulusan</button>
        </form>
    </div>
</div>
@endsection
