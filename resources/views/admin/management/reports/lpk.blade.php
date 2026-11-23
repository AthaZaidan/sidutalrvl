@extends('layouts.admin')
@section('title', 'Monitoring Laporan LPK - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Laporan Semester LPK</h1>
<div class="card shadow p-3 mb-3">
    <h5>Rekap Karyawan LPK</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>LPK</th><th>Semester / Tahun</th><th>Tenaga Tetap (L/P)</th><th>Instruktur (L/P)</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($karyawan as $k)
                <tr>
                    <td>{{ $k->lpk?->name_lpk ?? '-' }}</td>
                    <td>{{ $k->sms }} / {{ $k->yr1 }}</td>
                    <td>{{ $k->tpt_lk }} / {{ $k->tpt_p }}</td>
                    <td>{{ $k->it_lk }} / {{ $k->it_p }}</td>
                    <td>{{ $k->is_locked ? 'Terkunci' : 'Terbuka' }}</td>
                    <td>
                        <form method="POST" action="{{ route('adm.management.report.lpk.lock', $k->id_jumlahkaryawan) }}">@csrf
                            <button class="btn btn-xs btn-warning">{{ $k->is_locked ? 'Buka Kunci' : 'Kunci' }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
