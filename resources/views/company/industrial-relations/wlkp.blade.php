@extends('layouts.main')
@section('title', 'WLKP & Serikat Pekerja - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold mb-3">Wajib Lapor Ketenagakerjaan (WLKP)</h5>
                <form method="POST" action="{{ route('company.hi.wlkp.store') }}" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <input type="text" name="no_wlkp" class="form-control mb-2" placeholder="Nomor WLKP" required>
                    <input type="text" name="tahun_wlkp" class="form-control mb-2" maxlength="4" value="{{ date('Y') }}" required>
                    <input type="file" name="file_lampiran" class="form-control mb-2">
                    <button class="btn btn-primary btn-sm">Simpan WLKP</button>
                </form>
                <ul class="list-group list-group-flush">
                    @foreach($wlkps as $w)
                        <li class="list-group-item">{{ $w->no_wlkp }} (Tahun {{ $w->tahun_wlkp }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold mb-3">Serikat Pekerja / Buruh</h5>
                <form method="POST" action="{{ route('company.hi.serikat.store') }}" class="mb-3">
                    @csrf
                    <input type="text" name="nama_serikat" class="form-control mb-2" placeholder="Nama Serikat Pekerja" required>
                    <input type="text" name="no_serikat_reg" class="form-control mb-2" placeholder="Nomor Pencatatan">
                    <input type="number" name="jumlah_anggota" class="form-control mb-2" placeholder="Jumlah Anggota" required>
                    <button class="btn btn-primary btn-sm">Simpan Serikat</button>
                </form>
                <ul class="list-group list-group-flush">
                    @foreach($serikats as $s)
                        <li class="list-group-item">{{ $s->nama_serikat }} ({{ $s->jumlah_anggota }} anggota)</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
