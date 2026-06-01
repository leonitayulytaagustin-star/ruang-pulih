@extends('layouts.dashboard', ['title' => 'Riwayat Konsultasi'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Konsultasi</h1>
        <p class="mb-0 opacity-75">Daftar seluruh riwayat pengajuan konsultasi online Anda.</p>
    </div>
    <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Form
    </a>
</section>

<div class="card border-0 shadow-sm p-4 rounded-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-list text-primary me-2"></i> Daftar Riwayat Konsultasi</h5>
    </div>
    
    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4">Tanggal & Waktu</th>
                    <th class="py-3 px-4">Psikolog</th>
                    <th class="py-3 px-4">Keluhan Utama</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($konsultasi as $item)
                <tr class="border-bottom">
                    <td class="px-4">
                        <strong class="d-block text-dark">{{ optional($item->tanggal_konsultasi)->format('d M Y') ?? 'Belum ditentukan' }}</strong>
                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ str_replace(':', '.', substr($item->waktu_mulai, 0, 5)) }} - {{ str_replace(':', '.', substr($item->waktu_selesai, 0, 5)) }}</small>
                    </td>
                    <td class="px-4 fw-bold text-primary">
                        <div class="d-flex align-items-center gap-2">
                            @if ($item->psikolog->user->foto_profil)
                                <img src="{{ $item->psikolog->user->foto_profil_url }}" alt="{{ $item->psikolog->user->nama_lengkap }}" class="rounded-circle object-fit-cover border border-light-subtle shadow-sm" style="width: 30px; height: 30px;">
                            @else
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                            @endif
                            {{ $item->psikolog->user->nama_lengkap ?? '-' }}
                        </div>
                    </td>
                    <td class="px-4 text-muted small">
                        {{ \Illuminate\Support\Str::limit($item->pendaftaran->keluhan ?? '-', 40) }}
                    </td>
                    <td class="px-4 text-center">
                        @if ($item->status_konsultasi === 'permintaan_baru')
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">Menunggu Persetujuan</span>
                        @elseif (in_array($item->status_konsultasi, ['disetujui', 'terjadwal']))
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Terjadwal</span>
                        @elseif (in_array($item->status_konsultasi, ['berlangsung', 'follow_up']))
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill">Berlangsung</span>
                        @elseif ($item->status_konsultasi === 'selesai')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Selesai</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill text-capitalize">{{ str_replace('_', ' ', $item->status_konsultasi) }}</span>
                        @endif
                    </td>
                    <td class="px-4 text-center">
                        <a class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3 shadow-sm border" href="{{ route('pasien.konsultasi.menunggu', $item) }}">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-folder-open fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Anda belum memiliki riwayat konsultasi.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($konsultasi->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $konsultasi->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
