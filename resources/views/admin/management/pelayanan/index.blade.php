@extends('layouts.admin')
@section('title', 'Manajemen Pelayanan HI - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Pelayanan Hubungan Industrial (PP / PKWT / PKB)</h1>
<div class="row mb-3">
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong>Total Karyawan Terlapor:</strong> {{ $karyawanCount }}</div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong>Laporan WLKP:</strong> {{ $wlkps->count() }}</div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm"><strong>Serikat Pekerja:</strong> {{ $serikats->count() }}</div></div>
</div>

@foreach(['pp' => ['title' => 'Permohonan Peraturan Perusahaan (PP)', 'rows' => $pps, 'pk' => 'id_pp'], 'pkwt' => ['title' => 'Permohonan PKWT', 'rows' => $pkwts, 'pk' => 'id_pkwt'], 'pkb' => ['title' => 'Permohonan PKB', 'rows' => $pkbs, 'pk' => 'id_pkb']] as $type => $blk)
    <div class="card shadow p-3 mb-4">
        <h5>{{ $blk['title'] }}</h5>
        <table class="table table-bordered table-sm">
            <thead><tr><th>Perusahaan</th><th>NPP</th><th>BPJS TK</th><th>BPJS KS</th><th>Mediator</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($blk['rows'] as $row)
                    <tr>
                        <td>{{ $row->company?->display_name ?? '-' }}</td>
                        <td>{{ $row->npp }}</td>
                        <td>{{ $row->bpjs_tk_status ? 'OK' : '-' }}</td>
                        <td>{{ $row->bpjs_ks_status ? 'OK' : '-' }}</td>
                        <td>{{ $row->mediator_status ? 'OK' : '-' }}</td>
                        <td>{{ $row->process_status == 3 ? 'Disetujui' : ($row->process_status == 99 ? 'Ditolak' : 'Proses') }}</td>
                        <td>
                            <form method="POST" action="{{ route('adm.management.pelayanan.verify', [$type, $row->{$blk['pk']}]) }}" class="d-inline">@csrf
                                <button class="btn btn-xs btn-success">Verifikasi / Setujui</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach
@endsection
