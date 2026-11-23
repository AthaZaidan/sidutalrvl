@extends('layouts.admin')
@section('title', 'Manajemen Sertifikasi - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Sertifikasi LPK</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Program Sertifikasi</th><th>LPK</th><th>Kejuruan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($certifications as $c)
                @php($st = \App\Support\SidutaConstants::certificationStatusLabel((int)$c->process_status))
                <tr>
                    <td>{{ $c->name_certification }}</td>
                    <td>{{ $c->lpk?->name_lpk ?? '-' }}</td>
                    <td>{{ $c->vocational?->name_vocational ?? '-' }}</td>
                    <td><span class="badge badge-{{ $st['badge'] }}">{{ $st['label'] }}</span></td>
                    <td>
                        <a href="{{ route('adm.management.certification.show', $c->id_certification) }}" class="btn btn-sm btn-info">Detail</a>
                        @if($c->process_status < 5)
                            <form method="POST" action="{{ route('adm.management.certification.advance', $c->id_certification) }}" class="d-inline">@csrf
                                <button class="btn btn-sm btn-success">Proses Tahap Berikutnya</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $certifications->links() }}
</div>
@endsection
