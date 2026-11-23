@extends('layouts.main')
@section('title', 'Pelayanan Hubungan Industrial - SIDUTA')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Pelayanan Hubungan Industrial (PP / PKWT / PKB)</h4>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold">Ajukan Peraturan Perusahaan (PP)</h6>
                <form method="POST" action="{{ route('company.hi.pp.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="npp" class="form-control form-control-sm mb-2" placeholder="NPP BPJS" required>
                    <input type="text" name="kode_badan_usaha" class="form-control form-control-sm mb-2" placeholder="Kode Badan Usaha" required>
                    <input type="text" name="nib" class="form-control form-control-sm mb-2" placeholder="NIB" required>
                    <select name="status_modal_company" class="form-select form-select-sm mb-2">
                        @foreach($statusModals as $sm)<option value="{{ $sm->id }}">{{ $sm->name }}</option>@endforeach
                    </select>
                    <input type="text" name="bidang_usaha" class="form-control form-control-sm mb-2" placeholder="Bidang Usaha" required>
                    <input type="date" name="tgl_surat_izin" class="form-control form-control-sm mb-2" required>
                    <input type="number" name="upah_min" class="form-control form-control-sm mb-2" placeholder="Upah Min" required>
                    <input type="number" name="upah_max" class="form-control form-control-sm mb-2" placeholder="Upah Max" required>
                    <input type="file" name="file_naskah_pp" class="form-control form-control-sm mb-2">
                    <button class="btn btn-primary btn-sm w-100">Ajukan PP</button>
                </form>
                <hr>
                @foreach($pps as $pp)<div class="small border-bottom py-1">NPP: {{ $pp->npp }} - <span class="badge bg-info text-dark">Status {{ $pp->process_status }}</span></div>@endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold">Ajukan Pencatatan PKWT</h6>
                <form method="POST" action="{{ route('company.hi.pkwt.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="pemberi_kerja" class="form-control form-control-sm mb-2" placeholder="Pemberi Kerja" required>
                    <input type="text" name="penerima_kerja" class="form-control form-control-sm mb-2" placeholder="Penerima Kerja" required>
                    <input type="text" name="npp" class="form-control form-control-sm mb-2" placeholder="NPP BPJS" required>
                    <input type="text" name="kode_badan_usaha" class="form-control form-control-sm mb-2" placeholder="Kode Badan Usaha" required>
                    <input type="file" name="perjanjian_kerja_file" class="form-control form-control-sm mb-2">
                    <button class="btn btn-primary btn-sm w-100">Ajukan PKWT</button>
                </form>
                <hr>
                @foreach($pkwts as $pkwt)<div class="small border-bottom py-1">{{ $pkwt->penerima_kerja }} ({{ $pkwt->npp }}) - <span class="badge bg-info text-dark">Status {{ $pkwt->process_status }}</span></div>@endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold">Ajukan Pendaftaran PKB</h6>
                <form method="POST" action="{{ route('company.hi.pkb.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="tahun_company" class="form-control form-control-sm mb-2" maxlength="4" value="{{ date('Y') }}" required>
                    <input type="text" name="npp" class="form-control form-control-sm mb-2" placeholder="NPP BPJS" required>
                    <input type="text" name="kode_badan_usaha" class="form-control form-control-sm mb-2" placeholder="Kode Badan Usaha" required>
                    <input type="text" name="bidang_usaha" class="form-control form-control-sm mb-2" placeholder="Bidang Usaha" required>
                    <input type="number" name="upah_min" class="form-control form-control-sm mb-2" placeholder="Upah Min" required>
                    <input type="number" name="upah_max" class="form-control form-control-sm mb-2" placeholder="Upah Max" required>
                    <input type="file" name="file_naskah_pkb" class="form-control form-control-sm mb-2">
                    <button class="btn btn-primary btn-sm w-100">Ajukan PKB</button>
                </form>
                <hr>
                @foreach($pkbs as $pkb)<div class="small border-bottom py-1">NPP: {{ $pkb->npp }} - <span class="badge bg-info text-dark">Status {{ $pkb->process_status }}</span></div>@endforeach
            </div>
        </div>
    </div>
</div>
@endsection
