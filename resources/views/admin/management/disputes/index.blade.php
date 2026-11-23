@extends('layouts.admin')
@section('title', 'Manajemen Perselisihan HI - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Perselisihan Hubungan Kerja</h1>
<div class="mb-3">
    @foreach(['all' => 'Semua', 'incoming' => 'Masuk', 'processed' => 'Diproses', 'cleared' => 'Diselesaikan Mediator', 'closed' => 'Ditutup'] as $k => $lbl)
        <a href="{{ route('adm.management.dispute.index', ['status' => $k]) }}" class="btn btn-sm btn-{{ $status === $k ? 'primary' : 'outline-primary' }}">{{ $lbl }}</a>
    @endforeach
</div>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Pelapor</th><th>Perusahaan</th><th>Kategori</th><th>Status</th><th>Mediator</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($disputes as $d)
                @php($st = \App\Support\SidutaConstants::disputeStatusLabel((int)$d->status))
                <tr>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->company }}</td>
                    <td>{{ $d->title }}</td>
                    <td><span class="badge badge-{{ $st['badge'] }}">{{ $st['label'] }}</span></td>
                    <td>{{ $d->mediatorUser?->full_name ?? '-' }}</td>
                    <td><a href="{{ route('adm.management.dispute.show', $d->id) }}" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $disputes->links() }}
</div>
@endsection
