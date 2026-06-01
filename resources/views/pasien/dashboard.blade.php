@extends('layouts.dashboard', ['title' => 'Dashboard Pasien'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <p class="mb-1 fw-medium opacity-75">Selamat Pagi, {{ auth()->user()->nama_lengkap }}</p>
        <h1 class="mb-2 fw-bold">Bagaimana Perasaanmu Hari Ini?</h1>
        <p class="mb-0 opacity-75">Setiap langkah kecil sangat berarti. Yuk, luangkan waktu sejenak untuk mengecek kondisi mentalmu.</p>
    </div>
    <div class="bg-white bg-opacity-10 p-3 rounded-4 backdrop-blur shadow-sm d-flex flex-row align-items-start gap-3" style="position: relative; z-index: 2; width: 100%; max-width: 350px; backdrop-filter: blur(10px);">
        <i class="fa-solid fa-quote-left fs-3 opacity-50 mt-1"></i>
        <p class="mb-0 fst-italic fw-medium" style="line-height: 1.5; font-size: 0.95rem;">"Kesehatan mental bukan tujuan, melainkan sebuah proses."</p>
    </div>
</section>

<div class="row g-4">
    <!-- Main Content Area -->
    <div class="col-lg-8">
        <div class="d-flex flex-column gap-4">
            
            <!-- Mood Tracker -->
            <div class="card border-0 shadow-sm p-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-face-smile text-primary me-2"></i> Mood Tracker</h5>
                    <p class="text-muted small mb-0">Catat suasana hatimu hari ini untuk memantau progresmu.</p>
                </div>
                
                <form method="POST" action="{{ route('pasien.dashboard.mood') }}">
                    @csrf
                    <div class="row g-3 mb-4 justify-content-center">
                        @foreach ([
                            ['Sangat Baik', 'sangatbaik.png', 'text-success'],
                            ['Baik', 'baik.png', 'text-success opacity-75'],
                            ['Biasa Saja', 'biasasaja.png', 'text-warning'],
                            ['Tidak Baik', 'tidakbaik.png', 'text-danger opacity-75'],
                            ['Sangat Buruk', 'sangatburuk.png', 'text-danger'],
                        ] as [$mood, $img, $textClass])
                            <div class="col-6 col-sm-4 col-md text-center">
                                <label class="mood-label-wrapper d-block p-3 rounded-4 border-2 cursor-pointer transition-all {{ $moodHariIni?->mood === $mood ? 'border-primary bg-primary bg-opacity-10 shadow-sm' : 'border-light bg-light hover-bg-white' }}" style="cursor: pointer;">
                                    <input type="radio" name="mood" value="{{ $mood }}" class="d-none" @checked($moodHariIni?->mood === $mood) required onchange="this.form.querySelectorAll('.mood-label-wrapper').forEach(el => { el.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10', 'shadow-sm'); el.classList.add('border-light', 'bg-light'); }); this.closest('.mood-label-wrapper').classList.remove('border-light', 'bg-light'); this.closest('.mood-label-wrapper').classList.add('border-primary', 'bg-primary', 'bg-opacity-10', 'shadow-sm');">
                                    <div class="mood-icon mb-2 transition-transform {{ $moodHariIni?->mood === $mood ? 'scale-110' : '' }}" style="height: 60px;">
                                        <img src="{{ asset('assets/images/'.$img) }}" alt="{{ $mood }}" class="img-fluid h-100 drop-shadow-sm">
                                    </div>
                                    <span class="d-block small fw-bold {{ $moodHariIni?->mood === $mood ? 'text-primary' : 'text-muted' }}">{{ $mood }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Apa yang membuatmu merasa demikian? <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control bg-light border-0 focus-ring-primary" name="catatan" rows="3" placeholder="Tuliskan sedikit tentang harimu...">{{ $moodHariIni?->catatan }}</textarea>
                    </div>
                    
                    <div class="text-end border-top pt-3">
                        <button class="btn btn-primary px-4 shadow-sm fw-bold" type="submit">
                            <i class="fa-solid fa-heart-pulse me-2"></i> Simpan Mood Hari Ini
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Timeline -->
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Riwayat Aktivitas</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill small">Terbaru</span>
                </div>
                
                <div class="position-relative ps-2">
                    <!-- Vertical Line -->
                    <div class="position-absolute top-0 bottom-0 bg-light" style="left: 17px; width: 2px;"></div>
                    
                    @forelse ($aktivitas as $item)
                        @php
                            $icon = match($item->jenis_aktivitas) {
                                'skrining' => 'fa-clipboard-list',
                                'konsultasi' => 'fa-comments',
                                'pemantauan_mental' => 'fa-heart-pulse',
                                'membaca_artikel' => 'fa-book-open',
                                'menonton_video' => 'fa-play-circle',
                                default => 'fa-circle-dot'
                            };
                            // Menggunakan primary untuk semua jenis aktivitas sesuai instruksi
                            $color = 'primary';
                        @endphp
                        <div class="position-relative mb-4 ps-5">
                            <!-- Icon Dot -->
                            <div class="position-absolute start-0 translate-middle-x bg-white rounded-circle shadow-sm border-2 border-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; left: 17px; z-index: 2;">
                                <i class="fa-solid {{ $icon }} text-primary" style="font-size: 0.9rem;"></i>
                            </div>
                            
                            <div class="p-3 bg-light bg-opacity-50 rounded-4 border border-transparent transition-all hover-border-primary hover-bg-white">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-2">
                                    <h6 class="fw-bold mb-0 text-dark text-capitalize">{{ str_replace('_', ' ', $item->jenis_aktivitas) }}</h6>
                                    <span class="badge bg-white text-muted border fw-medium" style="font-size: 0.7rem;">
                                        <i class="fa-regular fa-calendar-alt me-1"></i> {{ optional($item->tanggal_aktivitas)->format('d M Y, H.i') }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $item->keterangan }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-wind fs-1 opacity-25 mb-3 d-block"></i>
                            <p class="mb-0">Belum ada aktivitas yang tercatat.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>

    <!-- Sidebar Content Area -->
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-4">
            
            <!-- Wellness Tips -->
            <div class="card border-0 shadow-sm p-4 text-center overflow-hidden position-relative" style="background-color: #f0fdf4;">
                <i class="fa-solid fa-leaf text-success" style="font-size: 150px; position: absolute; right: -20px; bottom: -20px; opacity: 0.05;"></i>
                <div style="position: relative; z-index: 2;">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 3.125rem; height: 3.125rem;">
                        <i class="fa-solid fa-leaf fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-success mb-3">Tips Kesehatan Mental</h5>
                    <p class="text-success opacity-75 small fw-medium mb-3" style="line-height: 1.6;">
                        Luangkan waktu 10 menit untuk bernapas dalam dan bersyukur atas 3 hal kecil yang terjadi hari ini.
                    </p>
                    <div class="d-inline-flex align-items-center gap-2 text-success fw-bold small bg-success bg-opacity-10 px-3 py-1 rounded-pill">
                        <i class="fa-solid fa-sparkles"></i> Tetap Semangat!
                    </div>
                </div>
            </div>

            <!-- Support Card -->
            <div class="card border-0 shadow-sm p-4 text-white rounded-4" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 2.8125rem; height: 2.8125rem;">
                        <i class="fa-solid fa-hand-holding-heart fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Butuh Bantuan?</h5>
                </div>
                <p class="small opacity-75 mb-4" style="line-height: 1.5;">Psikolog kami siap mendengarkan dan membantumu mengatasi berbagai keluhan.</p>
                <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-light w-100 fw-bold text-success shadow-sm rounded-pill">
                    Mulai Konsultasi
                </a>
            </div>

            <!-- Notifications -->
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-regular fa-bell text-primary me-2"></i> Pesan & Notifikasi</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse ($notifikasi as $item)
                        <div class="p-3 {{ $item->status_baca ? 'bg-light' : 'bg-primary bg-opacity-10 border-primary border-opacity-25' }} rounded-4 border transition-hover position-relative">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <strong class="text-dark small d-block pr-3">{{ $item->judul_notifikasi }}</strong>
                                @if(!$item->status_baca)
                                    <span class="bg-primary rounded-circle shadow-sm" style="width: 0.5rem; height: 0.5rem; flex-shrink: 0;"></span>
                                @endif
                            </div>
                            <p class="text-muted mb-2" style="font-size: 0.8rem; line-height: 1.5;">{{ $item->isi_notifikasi }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small" style="font-size: 0.7rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                                </span>
                                @if(!$item->status_baca)
                                    <form action="{{ route('pasien.notifikasi.baca', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0 text-primary small text-decoration-none fw-bold" style="font-size: 0.7rem;">
                                            Tandai dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted fst-italic py-3">
                            <i class="fa-regular fa-bell-slash d-block fs-3 opacity-25 mb-2"></i>
                            Tidak ada notifikasi baru untuk Anda.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .transition-all { transition: all 0.3s ease; }
    .transition-transform { transition: transform 0.3s ease; }
    .transition-hover:hover { transform: translateX(3px); }
    .hover-bg-white:hover { background-color: #fff !important; border-color: #dee2e6 !important; }
    .scale-110 { transform: scale(1.1); }
    .cursor-pointer { cursor: pointer; }
    .drop-shadow-sm { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }
    .focus-ring-primary:focus { box-shadow: 0 0 0 0.25rem rgba(0, 92, 52, 0.15) !important; outline: none; }
    .mood-label-wrapper:hover .mood-icon { transform: scale(1.1); }
    .hover-bg-white:hover { background-color: #fff !important; }
    .hover-border-primary:hover { border-color: var(--primary-green) !important; }
    .hover-border-success:hover { border-color: #198754 !important; }
    .hover-border-warning:hover { border-color: #ffc107 !important; }
    .hover-border-danger:hover { border-color: #dc3545 !important; }
</style>
@endsection
