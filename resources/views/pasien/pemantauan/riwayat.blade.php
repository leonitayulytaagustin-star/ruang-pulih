@extends('layouts.dashboard', ['title' => 'Riwayat Pemantauan Kondisi Mental'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Pemantauan</h1>
        <p class="mb-0 opacity-75">Lihat kembali catatan kondisi kesehatan mental harian Anda.</p>
    </div>
    <a href="{{ route('pasien.pemantauan.index') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Form
    </a>
</section>

<div class="card border-0 shadow-sm p-4 rounded-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-list text-primary me-2"></i> Daftar Catatan Harian</h5>
    </div>
    
    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-center">Kondisi</th>
                    <th class="py-3 px-4 text-center">Skor</th>
                    <th class="py-3 px-4">Catatan / Keterangan</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($riwayats as $item)
                <tr class="border-bottom">
                    <td class="px-4">
                        <strong class="d-block text-dark">{{ $item->tanggal_pemantauan->translatedFormat('d F Y') }}</strong>
                        <small class="text-muted">{{ $item->created_at->format('H.i') }} WIB</small>
                    </td>
                    <td class="px-4 text-center">
                        @php
                            $badgeColor = match($item->kondisi_mental) {
                                'baik' => 'success',
                                'sedang' => 'warning',
                                'parah' => 'danger',
                                default => 'secondary'
                            };
                            $moodIcon = match($item->kondisi_mental) {
                                'baik' => 'fa-face-smile',
                                'sedang' => 'fa-face-meh',
                                'parah' => 'fa-face-frown',
                                default => 'fa-face-meh-blank'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} px-3 py-2 rounded-pill text-capitalize fw-bold">
                            <i class="fa-solid {{ $moodIcon }} me-1"></i> {{ $item->kondisi_mental }}
                        </span>
                    </td>
                    <td class="px-4 text-center">
                        <span class="badge bg-light text-dark border px-3 py-1 rounded-pill fw-bold">{{ $item->total_skor }}</span>
                    </td>
                    <td class="px-4">
                        <div class="text-muted small" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $item->keterangan ?? '-' }}
                        </div>
                    </td>
                    <td class="px-4 text-center">
                        <a class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3" href="{{ route('pasien.pemantauan.hasil', $item) }}">
                            <i class="fa-solid fa-eye me-1"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-folder-open fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Anda belum memiliki riwayat pemantauan.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($riwayats->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $riwayats->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
