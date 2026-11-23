@extends('layouts.admin')
@section('title', 'Manajemen FAQ - SIDUTA')
@section('content')
<h1 class="h3 mb-3 text-gray-800">Manajemen FAQ</h1>
<div class="card shadow p-3 mb-3">
    <form method="POST" action="{{ route('adm.management.faq.store') }}" class="row">
        @csrf
        <div class="col-md-3"><select name="id_category_faq" class="form-control mb-2">@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="category_user" class="form-control mb-2"><option value="0">Pencari Kerja</option><option value="1">LPK</option><option value="2">Perusahaan</option></select></div>
        <div class="col-md-6"><input type="text" name="question" class="form-control mb-2" placeholder="Pertanyaan" required></div>
        <div class="col-md-10"><input type="text" name="answer" class="form-control mb-2" placeholder="Jawaban" required></div>
        <div class="col-md-2"><button class="btn btn-primary btn-block">Tambah FAQ</button></div>
    </form>
</div>
<div class="card shadow p-3">
    <table class="table table-sm table-bordered">
        <thead><tr><th>Kategori</th><th>Pertanyaan</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($faqs as $f)
                <tr>
                    <td>{{ $f->category?->name }}</td>
                    <td>{{ $f->question }}</td>
                    <td><form method="POST" action="{{ route('adm.management.faq.destroy', $f->id) }}">@csrf @method('DELETE')<button class="btn btn-xs btn-danger">Hapus</button></form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $faqs->links() }}
</div>
@endsection
