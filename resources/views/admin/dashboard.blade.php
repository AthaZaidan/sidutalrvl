@extends('layouts.admin')
@section('title', 'Dashboard Admin - SIDUTA')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard SIDUTA Kota Medan</h1>
<div class="row">
    @foreach([
        ['label' => 'Pencari Kerja', 'val' => $stats['jobseekers'], 'color' => 'primary'],
        ['label' => 'Perusahaan', 'val' => $stats['companies'], 'color' => 'success'],
        ['label' => 'LPK Terdaftar', 'val' => $stats['lpks'], 'color' => 'info'],
        ['label' => 'Lowongan Kerja', 'val' => $stats['job_vacancies'], 'color' => 'warning'],
        ['label' => 'Pemagangan', 'val' => $stats['internships'], 'color' => 'secondary'],
        ['label' => 'Pelatihan', 'val' => $stats['trainings'], 'color' => 'dark'],
        ['label' => 'Pengajuan AK-1', 'val' => $stats['ak1'], 'color' => 'primary'],
        ['label' => 'Perselisihan HI', 'val' => $stats['disputes'], 'color' => 'danger'],
        ['label' => 'Pelayanan HI (PP/PKWT/PKB)', 'val' => $stats['hi_services'], 'color' => 'success'],
        ['label' => 'Responden Survei IKM', 'val' => $stats['survey_respondents'], 'color' => 'info'],
        ['label' => 'Kunjungan Hari Ini', 'val' => $stats['visitors_today'], 'color' => 'warning'],
    ] as $card)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $card['color'] }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">{{ $card['label'] }}</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['val'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
