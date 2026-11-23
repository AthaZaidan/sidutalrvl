@extends('layouts.admin')
@section('title', 'Verifikasi LPK - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Verifikasi Registrasi LPK</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Nama LPK</th><th>VIN</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($lpks as $l)
                <tr>
                    <td>{{ $l->name_lpk }}</td>
                    <td>{{ $l->no_vin }}</td>
                    <td>{{ $l->email_lpk }}</td>
                    <td>{{ $l->legal_status == 3 ? 'Disetujui' : 'Menunggu' }}</td>
                    <td>
                        <form method="POST" action="{{ route('adm.registrasi.lpk.verify', $l->id_lpk) }}">@csrf
                            <input type="hidden" name="legal_status" value="3">
                            <button class="btn btn-sm btn-success">Setujui LPK</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lpks->links() }}
</div>
@endsection
