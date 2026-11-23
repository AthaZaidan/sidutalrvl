@extends('layouts.main')
@section('title', 'FAQ SIDUTA')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">Pertanyaan yang Sering Diajukan (FAQ)</h3>
    <form method="GET" action="{{ route('main.faq.index') }}" class="row g-2 mb-4">
        <div class="col-md-4"><input type="text" name="q" class="form-control" placeholder="Cari pertanyaan..." value="{{ request('q') }}"></div>
        <div class="col-md-3">
            <select name="category_user" class="form-select">
                <option value="all">Semua Pengguna</option>
                <option value="0" @selected(request('category_user') === '0')>Pencari Kerja</option>
                <option value="1" @selected(request('category_user') === '1')>LPK</option>
                <option value="2" @selected(request('category_user') === '2')>Perusahaan</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="id_category_faq" class="form-select">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('id_category_faq') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary">Filter</button></div>
    </form>

    <div class="accordion" id="faqAccordion">
        @forelse($faqs as $idx => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                    <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}">
                        <span class="badge bg-secondary me-2">{{ $faq->category?->name ?? 'Umum' }}</span> {{ $faq->question }}
                    </button>
                </h2>
                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{!! \App\Support\HtmlSanitizer::clean($faq->answer) !!}</div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Belum ada FAQ yang cocok.</div>
        @endforelse
    </div>
</div>
@endsection
