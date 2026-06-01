@extends('layouts.dashboard', ['title' => 'Status Konsultasi'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-circle-info me-2"></i> Status Konsultasi</h1>
        <p class="mb-0 opacity-75">Detail permintaan konsultasi Anda dengan Psikolog <strong>{{ $konsultasi->psikolog->user->nama_lengkap }}</strong>.</p>
    </div>
    <a href="{{ route('pasien.konsultasi.riwayat') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
</section>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-regular fa-calendar-check text-primary me-2"></i> Jadwal & Status</h5>
            
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center text-center">
                        <i class="fa-regular fa-calendar fs-2 text-primary opacity-50 mb-2"></i>
                        <span class="text-muted small fw-semibold d-block mb-1">Tanggal</span>
                        <strong class="text-dark">{{ optional($konsultasi->tanggal_konsultasi)->format('d F Y') ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center text-center">
                        <i class="fa-regular fa-clock fs-2 text-primary opacity-50 mb-2"></i>
                        <span class="text-muted small fw-semibold d-block mb-1">Waktu</span>
                        <strong class="text-dark">{{ str_replace(':', '.', substr($konsultasi->waktu_mulai, 0, 5)) }} - {{ str_replace(':', '.', substr($konsultasi->waktu_selesai, 0, 5)) }} WIB</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4 border h-100 d-flex flex-column align-items-center justify-content-center text-center">
                        <i class="fa-solid fa-flag fs-2 text-primary opacity-50 mb-2"></i>
                        <span class="text-muted small fw-semibold d-block mb-2">Status Saat Ini</span>
                        @if ($konsultasi->status_konsultasi === 'permintaan_baru')
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill shadow-sm">Menunggu Persetujuan</span>
                        @elseif (in_array($konsultasi->status_konsultasi, ['disetujui', 'terjadwal']))
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill shadow-sm">Terjadwal</span>
                        @elseif (in_array($konsultasi->status_konsultasi, ['berlangsung', 'follow_up']))
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill shadow-sm">Sedang Berlangsung</span>
                        @elseif ($konsultasi->status_konsultasi === 'selesai')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill shadow-sm">Selesai</span>
                        @elseif ($konsultasi->status_konsultasi === 'dibatalkan')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill shadow-sm">Dibatalkan</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill shadow-sm text-capitalize">{{ str_replace('_', ' ', $konsultasi->status_konsultasi) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-center pt-3 border-top">
                @if (in_array($konsultasi->status_konsultasi, ['disetujui', 'terjadwal', 'berlangsung', 'follow_up'], true))
                    <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success mb-4 text-start rounded-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> Psikolog telah menyetujui jadwal Anda. Silakan mulai sesi konsultasi melalui ruang chat.
                    </div>
                    <a class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-sm" href="{{ route('pasien.konsultasi.chat', $konsultasi) }}">
                        <i class="fa-solid fa-comments me-2"></i> Masuk Ruang Chat
                    </a>
                @elseif ($konsultasi->status_konsultasi === 'permintaan_baru')
                    <div class="alert alert-warning bg-warning bg-opacity-10 border-0 text-warning mb-0 text-start rounded-4" role="alert">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i> Jadwal Anda sedang ditinjau. Mohon tunggu psikolog menyetujui permintaan konsultasi Anda. Notifikasi akan masuk setelah jadwal dikonfirmasi.
                    </div>
                @elseif ($konsultasi->status_konsultasi === 'selesai')
                    <div class="alert alert-primary bg-primary bg-opacity-10 border-0 text-primary mb-0 text-start rounded-4" role="alert">
                        <i class="fa-solid fa-clipboard-check me-2"></i> Sesi konsultasi ini telah selesai. Terima kasih telah menggunakan layanan Ruang Pulih.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
