@extends('layouts.dashboard', ['title' => 'Pilih Tes Skrining'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-list-check me-2"></i> Pilih Tes Skrining</h1>
        <p class="mb-0 opacity-75">Pilih tes yang sesuai dengan kondisi yang ingin kamu kenali.</p>
    </div>
    <div class="d-flex gap-2" style="position: relative; z-index: 2;">
        <a href="{{ route('pasien.skrining.riwayat') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold">
            <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat
        </a>
        <a href="{{ route('pasien.skrining.index') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</section>

<div class="row g-4">
    @forelse ($jenis as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 h-100 rounded-4 shadow-sm transition-hover overflow-hidden d-flex flex-column">
                <!-- Image Header -->
                <div class="position-relative" style="height: 180px;">
                    <img src="{{ $item->gambar_url ?: asset('assets/no-image.png') }}" 
                         onerror="this.onerror=null;this.src='{{ asset('assets/no-image.png') }}';"
                         class="w-100 h-100 object-fit-cover" 
                         alt="{{ $item->nama_skrining }}">
                    
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold shadow-sm border">
                            <i class="fa-solid fa-clipboard-list me-1"></i>
                            {{ $item->jumlah_pertanyaan ?: $item->pertanyaan_count }} Soal
                        </span>
                    </div>

                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-to-t" style="background: linear-gradient(transparent, rgba(0,0,0,0.6));">
                        <span class="badge bg-primary text-white px-2 py-1 rounded-1 small fw-medium">
                            {{ $item->jenis_penyakit }}
                        </span>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">{{ $item->nama_skrining }}</h5>
                    <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}
                    </p>
                    
                    <a class="btn btn-primary w-100 shadow-sm fw-bold rounded-pill mt-auto py-2" href="{{ route('pasien.skrining.tes', $item) }}">
                        Mulai Skrining <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5 text-center text-muted">
                <i class="fa-solid fa-folder-open fs-1 opacity-25 mb-3"></i>
                <h5 class="fw-bold">Belum Ada Tes Skrining</h5>
                <p class="mb-0">Saat ini belum ada tes skrining yang dipublikasikan oleh sistem.</p>
            </div>
        </div>
    @endforelse
</div>

<style>
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; border-color: var(--primary-green) !important; }
</style>
@endsection
