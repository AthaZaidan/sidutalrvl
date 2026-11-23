@extends('layouts.admin')
@section('title', 'Manajemen Pemagangan - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Pemagangan</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Judul</th><th>Penyelenggara</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($internships as $in)
                <tr>
                    <td>{{ $in->title_intern }}</td>
                    <td>{{ $in->organizer_name }}</td>
                    <td>{{ $in->publish_status == 1 ? 'Terbit' : ($in->publish_status == 2 ? 'Ditolak' : 'Pending') }}</td>
                    <td class="d-flex">
                        @if($in->publish_status == 0)
                            <form method="POST" action="{{ route('adm.management.internship.approve', $in->id_intern) }}" class="mr-1">@csrf<button class="btn btn-sm btn-success">Setujui</button></form>
                            <form method="POST" action="{{ route('adm.management.internship.decline', $in->id_intern) }}" class="form-inline">@csrf
                                <input type="text" name="reason" class="form-control form-control-sm mr-1" placeholder="Alasan" required>
                                <button class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $internships->links() }}
</div>
@endsection
