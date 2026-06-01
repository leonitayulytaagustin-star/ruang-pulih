@extends('layouts.dashboard', ['title' => 'Dashboard Psikolog'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <p class="mb-1 fw-medium opacity-75">Halo, {{ $psikolog->user->nama_lengkap }}</p>
        <h1 class="mb-2 fw-bold">Selamat Datang Kembali</h1>
        <p class="mb-0 opacity-75">Siap untuk membantu pasien hari ini? Pantau jadwal dan kondisi mental pasien Anda di sini.</p>
    </div>
    <div class="bg-white bg-opacity-10 p-3 rounded-4 backdrop-blur shadow-sm text-center" style="position: relative; z-index: 2; min-width: 150px; backdrop-filter: blur(10px);">
        <div class="d-flex align-items-center justify-content-center gap-3">
            <i class="fa-solid fa-calendar-check fs-1 opacity-75"></i>
            <div class="text-start">
                <span class="d-block small fw-bold text-uppercase opacity-75">Sesi Hari Ini</span>
                <span class="fs-4 fw-bolder">{{ $stats['hari_ini'] }} Sesi</span>
            </div>
        </div>
    </div>
</section>

<div class="row g-3 g-md-4 mb-4">
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card border-0 p-3 p-md-4 shadow-sm h-100 d-flex flex-column flex-md-row align-items-center text-center text-md-start gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem;">Konsultasi Hari Ini</small>
                <h4 class="mb-0 fw-bold">{{ $stats['hari_ini'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card border-0 p-3 p-md-4 shadow-sm h-100 d-flex flex-column flex-md-row align-items-center text-center text-md-start gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-4 d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem;">Pasien Aktif</small>
                <h4 class="mb-0 fw-bold">{{ $stats['pasien'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card border-0 p-3 p-md-4 shadow-sm h-100 d-flex flex-column flex-md-row align-items-center text-center text-md-start gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem;">Chat Aktif</small>
                <h4 class="mb-0 fw-bold">{{ $stats['chat_aktif'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card border-0 p-3 p-md-4 shadow-sm h-100 d-flex flex-column flex-md-row align-items-center text-center text-md-start gap-3">
            <div class="bg-danger bg-opacity-10 text-danger rounded-4 d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem;">Risiko Tinggi</small>
                <h4 class="mb-0 fw-bold">{{ $stats['risiko_tinggi'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Content Area -->
    <div class="col-lg-8">
        <div class="d-flex flex-column gap-4">
            
            <!-- Jadwal Hari Ini -->
            <div class="card border-0 shadow-sm p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4 gap-2">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-calendar-check text-primary me-2"></i> Jadwal Konsultasi Hari Ini</h5>
                    <a href="{{ route('psikolog.konsultasi.index') }}" class="btn btn-sm btn-light fw-semibold text-primary px-3 py-2">Lihat Semua</a>
                </div>
                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-borderless align-middle mb-0" style="min-width: 600px;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="py-3 px-4">Waktu</th>
                                <th class="py-3 px-4">Pasien</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalHariIni as $item)
                                <tr class="border-bottom">
                                    <td class="px-4 fw-bold text-success">
                                        <i class="fa-regular fa-clock me-1"></i> {{ str_replace(':', '.', substr($item->waktu_mulai, 0, 5)) }}
                                    </td>
                                    <td class="px-4 fw-medium text-dark">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                            {{ $item->pasien->user->nama_lengkap ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 text-muted small text-capitalize">{{ $item->jenis_konsultasi }}</td>
                                    <td class="px-4 text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill text-capitalize">{{ $item->status_konsultasi }}</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <a href="{{ route('psikolog.konsultasi.chat', $item) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                                            <i class="fa-solid fa-comments me-1"></i> Chat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-regular fa-calendar-xmark fs-2 d-block mb-3 opacity-25"></i>
                                        Tidak ada jadwal konsultasi untuk hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Pasien -->
            <div class="card border-0 shadow-sm p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4 gap-2">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-chart-line text-primary me-2"></i> Ringkasan Kondisi Pasien</h5>
                    <a href="{{ route('psikolog.pemantauan.index') }}" class="btn btn-sm btn-light fw-semibold text-primary px-3 py-2">Lihat Pemantauan</a>
                </div>
                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-borderless align-middle mb-0" style="min-width: 600px;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="py-3 px-4">Pasien</th>
                                <th class="py-3 px-4">Kondisi Terakhir</th>
                                <th class="py-3 px-4 text-center">Skor</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ringkasan as $item)
                                <tr class="border-bottom">
                                    <td class="px-4 fw-bold text-dark">{{ $item->pasien->user->nama_lengkap ?? '-' }}</td>
                                    <td class="px-4 text-muted text-capitalize">{{ $item->kondisi_terakhir }}</td>
                                    <td class="px-4 text-center fw-bold fs-5">{{ $item->skor_terakhir }}</td>
                                    <td class="px-4 text-center">
                                        <span class="badge {{ $item->perubahan === 'memburuk' ? 'bg-danger text-danger' : 'bg-success text-success' }} bg-opacity-10 px-3 py-1 rounded-pill text-capitalize">
                                            <i class="fa-solid {{ $item->perubahan === 'memburuk' ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>
                                            {{ $item->perubahan }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        Belum ada ringkasan pemantauan pasien.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Sidebar Content Area -->
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-4">
            
            <!-- Pasien Perlu Perhatian -->
            <div class="card border-0 shadow-sm p-4 border-start border-danger border-5">
                <h5 class="fw-bold mb-4 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Perlu Perhatian Segera</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse ($perhatian as $item)
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4 border">
                            <div>
                                <strong class="d-block text-dark mb-1 small">{{ $item->pasien->user->nama_lengkap ?? '-' }}</strong>
                                <span class="text-muted small" style="font-size: 0.75rem;">Skor skrining meningkat</span>
                            </div>
                            <span class="badge {{ $item->prioritas === 'tinggi' ? 'bg-danger' : 'bg-warning' }} rounded-pill text-capitalize px-3 py-2" style="font-size: 0.7rem;">
                                {{ $item->prioritas }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-muted fst-italic py-3">
                            Tidak ada pasien dengan prioritas tinggi saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Notifikasi -->
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fa-regular fa-bell text-primary me-2"></i> Notifikasi Terbaru</h5>
                <div class="d-flex flex-column gap-4">
                    @forelse ($notifikasi as $item)
                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            <div>
                                <strong class="d-block text-dark mb-1 small">{{ $item->judul_notifikasi }}</strong>
                                <p class="text-muted small mb-1" style="line-height: 1.4; font-size: 0.8rem;">{{ $item->isi_notifikasi }}</p>
                                <span class="text-secondary opacity-75" style="font-size: 0.65rem; font-weight: 600;">BARU SAJA</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted fst-italic py-3">
                            Belum ada notifikasi baru.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
