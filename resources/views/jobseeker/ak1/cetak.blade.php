<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cetak Kartu AK-1 - {{ $user->full_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } }
        .ak1-box { max-width: 820px; margin: 20px auto; border: 2px solid #222; padding: 24px; background: #fff; }
        .qr-wrap svg { width: 130px; height: 130px; }
    </style>
</head>
<body class="bg-light">
    <div class="text-center my-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">Cetak Kartu AK-1</button>
    </div>
    <div class="ak1-box">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <div>
                <h5 class="fw-bold mb-0">PEMERINTAH KOTA MEDAN</h5>
                <h6 class="fw-bold mb-0">DINAS KETENAGAKERJAAN</h6>
                <small>KARTU TANDA BUKTI PENDAFTARAN PENCARI KERJA (AK-1)</small>
            </div>
            <div class="qr-wrap">{!! $qrcodeSvg !!}</div>
        </div>
        <table class="table table-sm table-bordered">
            <tr><th style="width:32%">Nomor Pendaftaran</th><td>AK1-{{ str_pad((string)$ak1->id_ak1, 6, '0', STR_PAD_LEFT) }}</td></tr>
            <tr><th>NIK</th><td>{{ $user->nik ?? '-' }}</td></tr>
            <tr><th>Nama Lengkap</th><td>{{ $user->full_name }}</td></tr>
            <tr><th>Tempat / Tgl Lahir</th><td>{{ $user->place_birth }}, {{ \App\Support\DateHelper::tglIndo(optional($user->dob)->format('Y-m-d')) }}</td></tr>
            <tr><th>Jenis Kelamin</th><td>{{ ucfirst($user->gender ?? '-') }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->address ?? '-' }}</td></tr>
            <tr><th>Pendidikan Terakhir</th><td>{{ $user->educationLevel?->name_educationlevel ?? '-' }} - {{ $user->major ?? '-' }}</td></tr>
            <tr><th>Pekerjaan Diinginkan</th><td>{{ $ak1->desiredJob?->position ?? '-' }} ({{ $ak1->desiredJob?->placement ?? '-' }})</td></tr>
            <tr><th>Berlaku Sampai</th><td>{{ $ak1->updated_at ? \App\Support\DateHelper::tglIndo(\Carbon\Carbon::parse($ak1->updated_at)->addYears(2)->toDateString()) : '-' }}</td></tr>
        </table>
        <div class="row mt-4 small">
            <div class="col-6">
                <strong>Jadwal Lapor:</strong>
                <ul class="mb-0">
                    <li>Lapor I: {{ $ak1->updated_at ? \App\Support\DateHelper::tglIndo(\Carbon\Carbon::parse($ak1->updated_at)->addMonths(6)->toDateString()) : '-' }}</li>
                    <li>Lapor II: {{ $ak1->updated_at ? \App\Support\DateHelper::tglIndo(\Carbon\Carbon::parse($ak1->updated_at)->addMonths(12)->toDateString()) : '-' }}</li>
                    <li>Lapor III: {{ $ak1->updated_at ? \App\Support\DateHelper::tglIndo(\Carbon\Carbon::parse($ak1->updated_at)->addMonths(18)->toDateString()) : '-' }}</li>
                </ul>
            </div>
            <div class="col-6 text-end">
                <div>Medan, {{ \App\Support\DateHelper::tglIndo($ak1->updated_at ?? now()->toDateString()) }}</div>
                <div class="mt-4 fw-bold">{{ $ak1->approver?->full_name ?? 'Pengantar Kerja Disnaker Kota Medan' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
