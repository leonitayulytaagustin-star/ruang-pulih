@extends('layouts.dashboard', ['title' => 'Riwayat Skrining'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Skrining</h1>
        <p class="mb-0 opacity-75">Daftar hasil tes kesehatan mental yang telah Anda lakukan.</p>
    </div>
    <a href="{{ route('pasien.skrining.index') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Form
    </a>
</section>

<div class="card border-0 shadow-sm p-4 rounded-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-list text-primary me-2"></i> Daftar Hasil Tes</h5>
    </div>
    
    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4">Tanggal Tes</th>
                    <th class="py-3 px-4">Jenis Skrining</th>
                    <th class="py-3 px-4 text-center">Skor</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4 text-center" style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($riwayats as $item)
                <tr class="border-bottom">
                    <td class="px-4">
                        <strong class="d-block text-dark">{{ $item->tanggal_skrining->translatedFormat('d F Y') }}</strong>
                        <small class="text-muted">{{ $item->created_at->format('H.i') }} WIB</small>
                    </td>
                    <td class="px-4 fw-bold text-primary">
                        {{ $item->jenisSkrining->nama_skrining }}
                    </td>
                    <td class="px-4 text-center">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">{{ $item->total_skor }}</span>
                    </td>
                    <td class="px-4">
                        @php
                            $badgeColor = match($item->kategori_hasil) {
                                'ringan' => 'success',
                                'sedang' => 'warning',
                                'berat', 'tinggi' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} px-3 py-1 rounded-pill text-capitalize fw-bold">
                            {{ $item->kategori_hasil }}
                        </span>
                    </td>
                    <td class="px-4 text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3" href="{{ route('pasien.skrining.hasil', $item) }}">
                                <i class="fa-solid fa-eye me-1"></i> Detail
                            </a>
                            <a class="btn btn-sm btn-primary fw-bold rounded-pill px-3" href="{{ route('pasien.skrining.hasil.download', $item) }}">
                                <i class="fa-solid fa-file-pdf me-1"></i> PDF
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-folder-open fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Anda belum memiliki riwayat skrining.
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
