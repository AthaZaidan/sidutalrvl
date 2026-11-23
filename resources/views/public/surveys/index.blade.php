@extends('layouts.main')
@section('title', 'Survei Kepuasan Masyarakat (IKM) - SIDUTA')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-3">Survei Kepuasan Masyarakat (IKM) Disnaker Kota Medan</h4>
                <form method="POST" action="{{ route('main.survey.store') }}">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Layanan</label>
                            <select name="survey_service_id" class="form-select" required>
                                @foreach($services as $svc)
                                    <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Responden</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Usia</label>
                            <input type="number" name="age" class="form-control" min="15" max="99" value="25" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select" required>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="education" class="form-control" value="S1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="job" class="form-control" value="Karyawan Swasta" required>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Kuesioner Pelayanan</h5>
                    @foreach($questions as $idx => $q)
                        <div class="border rounded p-3 mb-3">
                            <p class="fw-semibold mb-2">{{ $idx + 1 }}. {{ $q->questioner }}</p>
                            <div class="row g-2">
                                @foreach([1 => $q->label_name_1, 2 => $q->label_name_2, 3 => $q->label_name_3, 4 => $q->label_name_4] as $val => $lbl)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="{{ $val }}" id="q{{ $q->id }}_{{ $val }}" @checked($val === 4)>
                                            <label class="form-check-label small" for="q{{ $q->id }}_{{ $val }}">{{ $lbl }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label">Saran / Masukan</label>
                        <textarea name="saran" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold">Kirim Survei</button>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-4 text-center">
                <h5 class="fw-bold">Ringkasan IKM</h5>
                <div class="display-5 fw-bold text-primary my-2">{{ $avgScore ? number_format($avgScore * 25, 1) : '0.0' }}</div>
                <p class="text-muted small">Skor Indeks Kepuasan (Skala 100) dari {{ $totalRespondents }} Responden</p>
            </div>
        </div>
    </div>
</div>
@endsection
