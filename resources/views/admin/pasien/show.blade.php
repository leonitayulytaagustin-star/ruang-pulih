@extends('layouts.dashboard', ['title' => 'Detail Pasien'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-user-circle me-2"></i> {{ $pasien->user->nama_lengkap }}</h1>
        <div class="d-flex align-items-center gap-2 mt-2">
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-envelope me-1"></i> {{ $pasien->user->email }}</span>
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-phone me-1"></i> {{ $pasien->user->nomor_telepon ?? 'Belum diisi' }}</span>
        </div>
    </div>
    <a href="{{ route('admin.pasien.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-cake-candles fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Umur</small>
                <h4 class="mb-0 fw-bold">{{ $pasien->umur ?? '-' }} Tahun</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-venus-mars fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Jenis Kelamin</small>
                <h4 class="mb-0 fw-bold text-capitalize">{{ $pasien->user->jenis_kelamin ?? '-' }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-heart-pulse fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Status</small>
                <h4 class="mb-0 fw-bold text-capitalize text-success">{{ $pasien->status_pasien }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 p-4">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-clipboard-list text-primary me-2"></i> Riwayat Skrining</h5>
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Jenis Skrining</th>
                            <th class="py-3 px-4 text-center">Skor</th>
                            <th class="py-3 px-4">Kategori Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($hasil as $item)
                        <tr class="border-bottom">
                            <td class="px-4 text-muted">{{ $item->tanggal_skrining->format('d M Y') }}</td>
                            <td class="px-4 fw-medium">{{ $item->jenisSkrining->nama_skrining }}</td>
                            <td class="px-4 text-center fw-bold">{{ $item->total_skor }}</td>
                            <td class="px-4">
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">{{ $item->kategori_hasil }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat skrining.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 p-4 h-100">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-comments text-primary me-2"></i> Riwayat Konsultasi</h5>
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Psikolog</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($konsultasi as $item)
                        <tr class="border-bottom">
                            <td class="px-4 text-muted small">{{ optional($item->tanggal_konsultasi)->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 fw-medium">{{ $item->psikolog->user->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 text-center">
                                @if(strtolower($item->status_konsultasi) == 'selesai')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">{{ $item->status_konsultasi }}</span>
                                @elseif(strtolower($item->status_konsultasi) == 'berlangsung')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">{{ $item->status_konsultasi }}</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">{{ $item->status_konsultasi }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Belum ada riwayat konsultasi.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 p-4 h-100">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-line text-primary me-2"></i> Pemantauan Mental</h5>
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4 text-center">Skor</th>
                            <th class="py-3 px-4 text-center">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($pemantauan as $item)
                        <tr class="border-bottom">
                            <td class="px-4 text-muted small">{{ $item->tanggal_pemantauan->format('d M Y') }}</td>
                            <td class="px-4 text-center fw-bold">{{ $item->total_skor }}</td>
                            <td class="px-4 text-center">
                                @if(strtolower($item->kondisi_mental) === 'parah')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">{{ $item->kondisi_mental }}</span>
                                @elseif(strtolower($item->kondisi_mental) === 'baik')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">{{ $item->kondisi_mental }}</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill">{{ $item->kondisi_mental }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Belum ada data pemantauan.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
