@extends('layouts.admin')
@section('title', 'Survei Kepuasan Masyarakat - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen Survei Kepuasan Masyarakat (IKM)</h1>
<div class="card shadow p-3 mb-3">
    <p><strong>Rata-rata IKM (Skala 100):</strong> {{ $avgScore ? number_format($avgScore * 25, 1) : '0.0' }}</p>
    <h6>Tambah Pertanyaan Survei</h6>
    <form method="POST" action="{{ route('adm.management.survey.question.store') }}" class="row">
        @csrf
        <div class="col-md-4"><input type="text" name="questioner" class="form-control form-control-sm mb-2" placeholder="Pertanyaan..." required></div>
        <div class="col-md-2"><input type="text" name="label_name_1" class="form-control form-control-sm mb-2" value="Tidak Sesuai" required></div>
        <div class="col-md-2"><input type="text" name="label_name_2" class="form-control form-control-sm mb-2" value="Kurang Sesuai" required></div>
        <div class="col-md-2"><input type="text" name="label_name_3" class="form-control form-control-sm mb-2" value="Sesuai" required></div>
        <div class="col-md-2"><input type="text" name="label_name_4" class="form-control form-control-sm mb-2" value="Sangat Sesuai" required></div>
        <div class="col-12"><button class="btn btn-sm btn-primary">Tambah Pertanyaan</button></div>
    </form>
</div>
<div class="card shadow p-3">
    <h5>Daftar Responden Terbaru</h5>
    <table class="table table-sm table-bordered">
        <thead><tr><th>Nama</th><th>Layanan</th><th>Umur</th><th>Pendidikan</th><th>Saran</th></tr></thead>
        <tbody>
            @foreach($respondents as $r)
                <tr><td>{{ $r->name }}</td><td>{{ $r->service?->name }}</td><td>{{ $r->age }}</td><td>{{ $r->education }}</td><td>{{ $r->saran }}</td></tr>
            @endforeach
        </tbody>
    </table>
    {{ $respondents->links() }}
</div>
@endsection
