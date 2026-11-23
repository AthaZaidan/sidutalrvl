@extends('layouts.main')
@section('title', 'Laporan Semester LPK - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Laporan Semester LPK ({{ $lpk->name_lpk }})</h4>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3 mb-3">
                <h6 class="fw-bold">1. Jumlah Karyawan & Instruktur</h6>
                <form method="POST" action="{{ route('lpk.report.store', 'karyawan') }}" class="row g-2 mb-2">
                    @csrf
                    <div class="col-3"><input type="number" name="sms" class="form-control form-control-sm" value="1" placeholder="Semester"></div>
                    <div class="col-3"><input type="number" name="yr1" class="form-control form-control-sm" value="{{ date('Y') }}" placeholder="Tahun"></div>
                    <div class="col-3"><input type="number" name="tpt_lk" class="form-control form-control-sm" placeholder="Tenaga Tetap L" required></div>
                    <div class="col-3"><input type="number" name="tpt_p" class="form-control form-control-sm" placeholder="Tenaga Tetap P" required></div>
                    <div class="col-4"><input type="number" name="it_lk" class="form-control form-control-sm" placeholder="Instruktur L" required></div>
                    <div class="col-4"><input type="number" name="it_p" class="form-control form-control-sm" placeholder="Instruktur P" required></div>
                    <div class="col-4"><button class="btn btn-primary btn-sm w-100">Simpan</button></div>
                </form>
                <div class="small text-muted">Tercatat: {{ $karyawan->count() }} entri</div>
            </div>

            <div class="card border-0 shadow-sm p-3 mb-3">
                <h6 class="fw-bold">2. Kegiatan Pelatihan (P2)</h6>
                <form method="POST" action="{{ route('lpk.report.store', 'p2') }}" class="row g-2 mb-2">
                    @csrf
                    <div class="col-6"><input type="text" name="nama_pelatihan" class="form-control form-control-sm" placeholder="Nama Pelatihan" required></div>
                    <div class="col-6"><input type="date" name="jadwal_pelatihan" class="form-control form-control-sm" required></div>
                    <div class="col-3"><input type="number" name="jumlah_pesertalat" class="form-control form-control-sm" placeholder="Peserta" required></div>
                    <div class="col-3"><input type="number" name="jumlah_lulusanlat" class="form-control form-control-sm" placeholder="Lulusan" required></div>
                    <div class="col-3"><input type="number" name="jumlah_lulusanker" class="form-control form-control-sm" placeholder="Bekerja" required></div>
                    <div class="col-3"><input type="number" name="jumlah_lulusanwir" class="form-control form-control-sm" placeholder="Wirausaha" required></div>
                    <div class="col-12"><button class="btn btn-primary btn-sm">Simpan P2</button></div>
                </form>
                <div class="small text-muted">Tercatat: {{ $p2->count() }} kegiatan</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3 mb-3">
                <h6 class="fw-bold">3. Kemitraan LPK</h6>
                <form method="POST" action="{{ route('lpk.report.store', 'kemitraan') }}" class="row g-2 mb-2">
                    @csrf
                    <div class="col-4"><input type="text" name="nama_mitra" class="form-control form-control-sm" placeholder="Nama Mitra" required></div>
                    <div class="col-4"><input type="text" name="alamat" class="form-control form-control-sm" placeholder="Alamat" required></div>
                    <div class="col-4"><input type="text" name="bentuk_kemitraan" class="form-control form-control-sm" placeholder="Bentuk" required></div>
                    <div class="col-12"><button class="btn btn-primary btn-sm">Simpan Kemitraan</button></div>
                </form>
                <div class="small text-muted">Tercatat: {{ $kemitraan->count() }} mitra</div>
            </div>

            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold">4. Kendala & Solusi</h6>
                <form method="POST" action="{{ route('lpk.report.store', 'kendala') }}" class="row g-2 mb-2">
                    @csrf
                    <div class="col-6"><input type="text" name="kendala" class="form-control form-control-sm" placeholder="Kendala" required></div>
                    <div class="col-6"><input type="text" name="solusi" class="form-control form-control-sm" placeholder="Solusi" required></div>
                    <div class="col-12"><button class="btn btn-primary btn-sm">Simpan Kendala</button></div>
                </form>
                <div class="small text-muted">Tercatat: {{ $kendala->count() }} entri</div>
            </div>
        </div>
    </div>
</div>
@endsection
