@extends('layouts.admin')
@section('title', 'Manajemen Pelatihan - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Pelatihan</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Judul</th><th>LPK</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($trainings as $tr)
                <tr>
                    <td>{{ $tr->title_training }}</td>
                    <td>{{ $tr->lpk?->name_lpk ?? '-' }}</td>
                    <td>{{ $tr->publish_status == 1 ? 'Terbit' : ($tr->publish_status == 2 ? 'Ditolak' : 'Pending') }}</td>
                    <td class="d-flex">
                        @if($tr->publish_status == 0)
                            <form method="POST" action="{{ route('adm.management.training.approve', $tr->id_training) }}" class="mr-1">@csrf<button class="btn btn-sm btn-success">Setujui</button></form>
                            <form method="POST" action="{{ route('adm.management.training.decline', $tr->id_training) }}" class="form-inline">@csrf
                                <input type="text" name="reason" class="form-control form-control-sm mr-1" placeholder="Alasan" required>
                                <button class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $trainings->links() }}
</div>
@endsection
