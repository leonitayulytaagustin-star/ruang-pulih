@extends('layouts.dashboard', ['title' => 'Hasil Skrining'])

@section('content')
    <section
        class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden"
        style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
        <div style="position: relative; z-index: 2;">
            <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clipboard-check me-2"></i> Hasil Skrining</h1>
            <p class="mb-0 opacity-75">Hasil tes <strong>{{ $hasil->jenisSkrining->nama_skrining }}</strong> pada
                {{ $hasil->tanggal_skrining->format('d M Y') }}</p>
        </div>
        <div class="d-flex gap-2" style="position: relative; z-index: 2;">
            <a href="{{ route('pasien.skrining.riwayat') }}"
                class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat
            </a>
            <a href="{{ route('pasien.skrining.hasil.download', $hasil) }}"
                class="btn btn-light text-primary border-0 shadow-sm fw-bold">
                <i class="fa-solid fa-file-pdf me-1"></i> Unduh PDF
            </a>
            <a href="{{ route('pasien.dashboard') }}"
                class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold d-none d-md-inline-block">
                <i class="fa-solid fa-home me-1"></i> Beranda
            </a>
        </div>
    </section>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-star fs-3"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block mb-1">Total Skor</small>
                    <h3 class="mb-0 fw-bold">{{ $hasil->total_skor }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
                @php
                    $isBerat =
                        strtolower($hasil->kategori_hasil) === 'berat' ||
                        strtolower($hasil->kategori_hasil) === 'tinggi';
                @endphp
                <div class="{{ $isBerat ? 'bg-danger text-danger' : 'bg-warning text-warning' }} bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-chart-simple fs-3"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block mb-1">Kategori Hasil</small>
                    <span
                        class="badge {{ $isBerat ? 'bg-danger' : 'bg-warning' }} rounded-pill px-3 py-2 text-capitalize shadow-sm">
                        {{ $hasil->kategori_hasil }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3"
                style="background-color: #f0fdf4;">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                    style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-doctor fs-3"></i>
                </div>
                <div class="flex-grow-1">
                    <small class="text-success fw-semibold d-block mb-2">Rekomendasi</small>
                    <a href="{{ route('pasien.konsultasi.index') }}"
                        class="btn btn-success w-100 fw-bold shadow-sm rounded-pill py-2 text-decoration-none">
                        Konsultasi Psikolog <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm p-4 h-100 bg-primary text-white border-start border-white border-4">
                <h5 class="fw-bold mb-3 text-white"><i class="fa-solid fa-circle-info me-2"></i> Keterangan Hasil</h5>
                <p class="text-white opacity-75 mb-0" style="line-height: 1.6; font-size: 1.05rem;">
                    {{ $hasil->keterangan_hasil }}
                </p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-list-check text-primary me-2"></i> Detail
                    Jawaban Anda</h5>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="py-3 px-4" style="width: 5%">No</th>
                                <th class="py-3 px-4" style="width: 60%">Pertanyaan</th>
                                <th class="py-3 px-4">Jawaban</th>
                                <th class="py-3 px-4 text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil->detail as $detail)
                                <tr class="border-bottom">
                                    <td class="px-4 text-muted fw-semibold">{{ $loop->iteration }}</td>
                                    <td class="px-4 text-dark">{{ $detail->pertanyaan->pertanyaan }}</td>
                                    <td class="px-4 fw-medium text-primary">{{ $detail->jawaban->teks_jawaban }}</td>
                                    <td class="px-4 text-center fw-bold">{{ $detail->nilai_jawaban }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
