@extends('layouts.dashboard', ['title' => 'Pilih Psikolog'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-user-doctor me-2"></i> Pilih Psikolog</h1>
        <p class="mb-0 opacity-75">Cari psikolog yang sesuai dengan preferensimu berdasarkan nama atau spesialisasi.</p>
    </div>
    <div style="position: relative; z-index: 2;">
        <form class="d-flex gap-2" method="GET">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white" style="width: 350px;">
                <span class="input-group-text bg-white border-0 ps-3 pe-2 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input class="form-control border-0 bg-white ps-0" name="search" value="{{ $search }}" placeholder="Cari nama atau spesialisasi..." style="box-shadow: none;">
                <button class="btn btn-primary fw-bold px-4 m-1 rounded-pill" type="submit">Cari</button>
            </div>
        </form>
    </div>
</section>

<div class="row g-4 mb-4">
    @forelse ($psikologs as $psikolog)
        <div class="col-md-6 col-xl-4">
            <div class="card border border-light-subtle h-100 p-4 rounded-4 shadow-sm transition-hover d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    @if ($psikolog->user->foto_profil)
                        <img src="{{ $psikolog->user->foto_profil_url }}" alt="{{ $psikolog->user->nama_lengkap }}" class="rounded-circle flex-shrink-0 object-fit-cover border border-light-subtle" style="width: 60px; height: 60px;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-user-doctor fs-3"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">{{ $psikolog->user->nama_lengkap }}</h6>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-medium"><i class="fa-solid fa-stethoscope me-1"></i> {{ $psikolog->spesialisasi ?? 'Psikolog Umum' }}</span>
                    </div>
                </div>
                
                <div class="mb-3 d-flex gap-2 flex-wrap text-muted small">
                    <span class="bg-light px-2 py-1 rounded"><i class="fa-solid fa-briefcase me-1 text-primary"></i> Pengalaman: {{ $psikolog->pengalaman ?? 0 }} tahun</span>
                    <span class="bg-light px-2 py-1 rounded"><i class="fa-solid fa-venus-mars me-1 text-primary"></i> {{ ucfirst($psikolog->user->jenis_kelamin ?? '-') }}</span>
                </div>
                
                <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">"{{ \Illuminate\Support\Str::limit($psikolog->bio ?? 'Berdedikasi untuk membantu pasien mengatasi permasalahan kesehatan mental dengan pendekatan profesional.', 120) }}"</p>
                
                <a class="btn btn-primary w-100 shadow-sm fw-bold rounded-pill mt-auto" href="{{ route('pasien.konsultasi.jadwal', $psikolog) }}">
                    Pilih Psikolog <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5 text-center text-muted rounded-4">
                <i class="fa-solid fa-user-doctor fs-1 opacity-25 mb-3"></i>
                <h5 class="fw-bold text-dark">Psikolog Tidak Ditemukan</h5>
                <p class="mb-0">Maaf, kami tidak dapat menemukan psikolog dengan kata kunci pencarian tersebut.</p>
                <div class="mt-3">
                    <a href="{{ route('pasien.konsultasi.psikolog') }}" class="btn btn-light rounded-pill px-4 text-primary fw-bold">Tampilkan Semua</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if ($psikologs->hasPages())
    <div class="d-flex justify-content-center">
        {{ $psikologs->links('pagination::bootstrap-5') }}
    </div>
@endif

<style>
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; border-color: var(--primary-green) !important; }
</style>
@endsection
