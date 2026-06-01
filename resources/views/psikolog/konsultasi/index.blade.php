@extends('layouts.dashboard', ['title' => 'Konsultasi Psikolog'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-comments me-2"></i> Konsultasi Online</h1>
        <p class="mb-0">Kelola permintaan konsultasi dan sesi chat pasien.</p>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 shadow-sm d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-inbox fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Permintaan Baru</small>
                <h4 class="mb-0 fw-bold">{{ $stats['baru'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 shadow-sm d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-circle-check fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Selesai Hari Ini</small>
                <h4 class="mb-0 fw-bold">{{ $stats['selesai_hari_ini'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 shadow-sm d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-list-check fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Total Sesi</small>
                <h4 class="mb-0 fw-bold">{{ $stats['semua'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-clipboard-list text-primary me-2"></i> Daftar Permintaan Konsultasi</h5>
    </div>
    
    <div class="row g-4">
        @forelse ($konsultasi as $item)
            <div class="col-md-6 col-xl-4">
                <div class="card border border-light-subtle h-100 p-4 rounded-4 shadow-sm transition-hover">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $item->pasien->user->nama_lengkap ?? '-' }}</h6>
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ optional($item->tanggal_konsultasi)->format('d M Y') }} • {{ str_replace(':', '.', substr($item->waktu_mulai, 0, 5)) }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 d-flex gap-2 flex-wrap">
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-triangle-exclamation me-1 opacity-50"></i> Urgensi: {{ ucfirst($item->pendaftaran->tingkat_urgensi ?? 'Rendah') }}</span>
                        @if ($item->status_konsultasi === 'permintaan_baru')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Permintaan Baru</span>
                        @elseif (in_array($item->status_konsultasi, ['disetujui', 'terjadwal']))
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Terjadwal</span>
                        @elseif (in_array($item->status_konsultasi, ['berlangsung', 'follow_up']))
                            <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Berlangsung</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 text-capitalize">{{ str_replace('_', ' ', $item->status_konsultasi) }}</span>
                        @endif
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 text-muted small" style="line-height: 1.5; min-height: 80px;">
                        <strong class="d-block mb-1 text-dark">Keluhan:</strong>
                        {{ \Illuminate\Support\Str::limit($item->pendaftaran->keluhan ?? '-', 100) }}
                    </div>
                    
                    <div class="d-flex gap-2 mt-auto pt-3 border-top">
                        @if ($item->status_konsultasi === 'permintaan_baru')
                            <form action="{{ route('psikolog.konsultasi.approve', $item) }}" method="POST" class="flex-grow-1">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary w-100 shadow-sm fw-semibold" type="submit"><i class="fa-solid fa-check me-1"></i> Setuju</button>
                            </form>
                            <form action="{{ route('psikolog.konsultasi.reject', $item) }}" method="POST" class="flex-grow-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="catatan_psikolog" value="Jadwal belum dapat diterima.">
                                <button class="btn btn-danger w-100 shadow-sm fw-semibold" type="submit" onclick="confirmDelete(event, 'Tolak permintaan ini?')"><i class="fa-solid fa-xmark me-1"></i> Tolak</button>
                            </form>
                        @endif
                        @if (in_array($item->status_konsultasi, ['disetujui','terjadwal'], true))
                            <form action="{{ route('psikolog.konsultasi.start', $item) }}" method="POST" class="w-100">
                                @csrf @method('PATCH')
                                <button class="btn btn-success w-100 shadow-sm fw-semibold" type="submit"><i class="fa-solid fa-play me-1"></i> Mulai Sesi</button>
                            </form>
                        @endif
                        @if (in_array($item->status_konsultasi, ['berlangsung','follow_up'], true))
                            <a class="btn btn-warning w-100 shadow-sm fw-bold text-dark" href="{{ route('psikolog.konsultasi.chat', $item) }}">
                                <i class="fa-solid fa-comments me-1"></i> Buka Chat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 text-muted bg-light rounded-4 border">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-inbox fs-1 text-secondary opacity-50"></i>
                    </div>
                    <h5 class="fw-bold">Belum Ada Permintaan</h5>
                    <p class="mb-0">Belum ada permintaan konsultasi saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    @if ($konsultasi->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $konsultasi->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>
@endsection
