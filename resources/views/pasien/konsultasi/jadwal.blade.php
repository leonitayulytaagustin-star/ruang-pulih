@extends('layouts.dashboard', ['title' => 'Pilih Jadwal'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-regular fa-calendar-check me-2"></i> Pilih Jadwal Konsultasi</h1>
        <p class="mb-0 opacity-75">Dengan <strong>{{ $psikolog->user->nama_lengkap }}</strong> - {{ $psikolog->spesialisasi ?? 'Psikolog Umum' }}</p>
    </div>
    <a href="{{ route('pasien.konsultasi.psikolog') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Batal & Kembali
    </a>
</section>

<form method="POST" action="{{ route('pasien.konsultasi.jadwal.store', $psikolog) }}">
    @csrf
    <div class="row g-4">
        <!-- Main Area: Schedule Selection -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-regular fa-calendar-days text-primary me-2"></i> Jadwal Tersedia</h5>
                
                <div class="d-flex flex-column gap-4">
                    @forelse ($jadwal as $tanggal => $slots)
                        <div class="schedule-group">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-calendar-day text-success me-2"></i> {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</h6>
                            <div class="row g-3">
                                @foreach ($slots as $slot)
                                    <div class="col-sm-6 col-md-4">
                                        <label class="schedule-option d-block h-100 p-3 rounded-4 border border-2 cursor-pointer transition-all bg-light text-center hover-bg-white" style="cursor: pointer;">
                                            <input type="radio" name="id_jadwal" value="{{ $slot->id_jadwal }}" class="d-none" required onchange="document.querySelectorAll('.schedule-option').forEach(el => { el.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10', 'text-primary'); el.classList.add('border-light', 'bg-light'); }); this.closest('.schedule-option').classList.remove('border-light', 'bg-light'); this.closest('.schedule-option').classList.add('border-primary', 'bg-primary', 'bg-opacity-10', 'text-primary'); document.getElementById('btnSubmitSchedule').removeAttribute('disabled');">
                                            <i class="fa-regular fa-clock d-block fs-4 mb-2 opacity-75"></i>
                                            <strong class="d-block">{{ str_replace(':', '.', substr($slot->jam_mulai, 0, 5)) }} - {{ str_replace(':', '.', substr($slot->jam_selesai, 0, 5)) }}</strong>
                                            <small class="opacity-75">WIB</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted bg-light rounded-4 border">
                            <i class="fa-regular fa-calendar-xmark fs-1 opacity-25 mb-3 d-block"></i>
                            <h6 class="fw-bold">Jadwal Penuh / Belum Tersedia</h6>
                            <p class="mb-0 small">Maaf, psikolog ini belum memiliki jadwal yang tersedia dalam waktu dekat. Silakan kembali lagi nanti atau pilih psikolog lain.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            @if ($jadwal->isNotEmpty())
                <div class="card border-0 p-3 shadow-sm bg-white sticky-bottom mt-2 d-flex justify-content-end rounded-4" style="bottom: 20px; z-index: 10;">
                    <button class="btn btn-success shadow-sm px-5 py-2 fw-bold rounded-pill" type="submit" id="btnSubmitSchedule" disabled>
                        <i class="fa-solid fa-calendar-plus me-2"></i> Konfirmasi & Simpan Jadwal
                    </button>
                </div>
            @endif
        </div>

        <!-- Sidebar Info Area -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4 sticky-top" style="top: 20px;">
                <div class="card border-0 shadow-sm p-4 rounded-4 text-center">
                    @if ($psikolog->user->foto_profil)
                        <img src="{{ $psikolog->user->foto_profil_url }}" alt="{{ $psikolog->user->nama_lengkap }}" class="rounded-circle mx-auto mb-3 object-fit-cover border border-light-subtle shadow-sm" style="width: 80px; height: 80px;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-user-doctor fs-1"></i>
                        </div>
                    @endif
                    <h5 class="fw-bold text-dark mb-1">{{ $psikolog->user->nama_lengkap }}</h5>
                    <p class="text-primary fw-medium mb-3 small">{{ $psikolog->spesialisasi ?? 'Psikolog Umum' }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4 text-muted small">
                        <span class="bg-light px-2 py-1 rounded"><i class="fa-solid fa-briefcase me-1"></i> {{ $psikolog->pengalaman ?? 0 }} Thn</span>
                        <span class="bg-light px-2 py-1 rounded"><i class="fa-solid fa-venus-mars me-1"></i> {{ ucfirst($psikolog->user->jenis_kelamin ?? '-') }}</span>
                    </div>

                    <div class="text-start bg-light p-3 rounded-4">
                        <strong class="d-block mb-2 text-dark small"><i class="fa-solid fa-circle-info text-primary me-1"></i> Tentang Psikolog</strong>
                        <p class="text-muted small mb-0 fst-italic" style="line-height: 1.6;">"{{ $psikolog->bio ?? 'Berdedikasi untuk membantu pasien mengatasi permasalahan kesehatan mental dengan pendekatan profesional dan empati.' }}"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .transition-all { transition: all 0.2s ease; }
    .hover-bg-white:hover { background-color: #fff !important; border-color: #dee2e6 !important; }
</style>
@endsection
