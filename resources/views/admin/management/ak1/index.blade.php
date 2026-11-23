@extends('layouts.admin')
@section('title', 'Manajemen AK-1 - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Kartu AK-1</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>ID</th><th>Nama Pencaker</th><th>Jabatan Diinginkan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($ak1s as $a)
                @php($st = \App\Support\SidutaConstants::ak1StatusLabel((int)$a->process_status))
                <tr>
                    <td>{{ $a->id_ak1 }}</td>
                    <td>{{ $a->user?->full_name ?? '-' }}</td>
                    <td>{{ $a->desiredJob?->position ?? '-' }}</td>
                    <td><span class="badge badge-{{ $st['badge'] }}">{{ $st['label'] }}</span></td>
                    <td>
                        <a href="{{ route('adm.management.ak1.show', $a->id_ak1) }}" class="btn btn-sm btn-warning">Detail</a>
                        <a href="{{ route('adm.management.ak1.cetak', $a->id_ak1) }}" target="_blank" class="btn btn-sm btn-info">Cetak</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $ak1s->links() }}
</div>
@endsection
