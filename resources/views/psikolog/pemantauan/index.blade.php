@extends('layouts.dashboard', ['title' => 'Pemantauan Pasien'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-chart-line me-2"></i> Pemantauan Kondisi Mental</h1>
        <p class="mb-0">Pantau ringkasan kondisi mental pasien yang pernah berkonsultasi secara berkala.</p>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-user-group fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Pasien Dipantau</small>
                <h4 class="mb-0 fw-bold">{{ $stats['dipantau'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-4 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-arrow-trend-up fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Membaik</small>
                <h4 class="mb-0 fw-bold">{{ $stats['membaik'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
            <div class="bg-danger bg-opacity-10 text-danger rounded-4 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-arrow-trend-down fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Memburuk</small>
                <h4 class="mb-0 fw-bold">{{ $stats['memburuk'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 p-4 shadow-sm h-100 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-scale-balanced fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Stabil</small>
                <h4 class="mb-0 fw-bold">{{ $stats['stabil'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-clipboard-list text-primary me-2"></i> Daftar Pantauan Pasien</h5>
    </div>
    
    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4">Nama Pasien</th>
                    <th class="py-3 px-4 text-center">Skor Terakhir</th>
                    <th class="py-3 px-4 text-center">Perubahan</th>
                    <th class="py-3 px-4 text-center">Kondisi</th>
                    <th class="py-3 px-4">Tanggal Update</th>
                    <th class="py-3 px-4 text-center" style="width: 10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($ringkasan as $item)
                <tr class="border-bottom">
                    <td class="px-4 fw-bold text-dark">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            {{ $item->pasien->user->nama_lengkap ?? '-' }}
                        </div>
                    </td>
                    <td class="px-4 text-center fw-bold fs-5">{{ $item->skor_terakhir }}</td>
                    <td class="px-4 text-center">
                        @if($item->perubahan === 'memburuk')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-arrow-down me-1"></i> Memburuk</span>
                        @elseif($item->perubahan === 'membaik')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fa-solid fa-arrow-up me-1"></i> Membaik</span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-minus me-1"></i> Stabil</span>
                        @endif
                    </td>
                    <td class="px-4 text-center text-capitalize">{{ $item->kondisi_terakhir }}</td>
                    <td class="px-4 text-muted small">{{ optional($item->tanggal_update)->format('d M Y') }}</td>
                    <td class="px-4">
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('psikolog.pemantauan.show', $item->pasien) }}" title="Detail Pemantauan">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-chart-line fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Belum ada pasien yang dipantau.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($ringkasan->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $ringkasan->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
