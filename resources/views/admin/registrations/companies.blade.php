@extends('layouts.admin')
@section('title', 'Verifikasi Perusahaan - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Verifikasi Registrasi Perusahaan</h1>
<div class="card shadow p-3">
    <table class="table table-bordered table-sm">
        <thead><tr><th>Perusahaan</th><th>Email</th><th>NIB / NPWP</th><th>Status Legalitas</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($companies as $c)
                <tr>
                    <td>{{ $c->display_name }}</td>
                    <td>{{ $c->email_company }}</td>
                    <td>{{ $c->nib_company }} / {{ $c->npwp_company }}</td>
                    <td>{{ $c->legal_status == '1' ? 'Terverifikasi' : ($c->legal_status == '2' ? 'Ditolak' : 'Menunggu') }}</td>
                    <td class="d-flex">
                        <form method="POST" action="{{ route('adm.registrasi.company.verify', $c->id_company) }}" class="mr-1">@csrf
                            <input type="hidden" name="legal_status" value="1">
                            <button class="btn btn-sm btn-success">Verifikasi</button>
                        </form>
                        <form method="POST" action="{{ route('adm.registrasi.company.verify', $c->id_company) }}">@csrf
                            <input type="hidden" name="legal_status" value="2">
                            <button class="btn btn-sm btn-danger">Tolak</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $companies->links() }}
</div>
@endsection
