@extends('layouts.dashboard', ['title' => 'Manajemen Saran & Masukan'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-message me-2"></i> Saran & Masukan</h1>
    <p>Lihat aspirasi dan ide dari pengguna untuk pengembangan Ruang Pulih.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari pesan/pengirim...">
            </div>
            <button class="btn btn-primary shadow-sm" type="submit">Cari</button>
        </form>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Pengirim</th>
                    <th class="py-3 px-4" style="width: 40%">Pesan</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-center" style="width: 10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($sarans as $saran)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $sarans->firstItem() + $loop->index }}</td>
                    <td class="px-4">
                        <div class="d-flex flex-column align-items-start gap-1">
                            <div class="fw-bold text-dark">{{ $saran->nama ?? ($saran->user->nama_lengkap ?? 'Anonim') }}</div>
                            <div class="text-muted small">{{ $saran->email ?? ($saran->user->email ?? '-') }}</div>
                            @if($saran->id_user)
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mt-1" style="font-size: 0.7rem; padding: 0.35rem 0.6rem;">User Terdaftar</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 text-dark" style="line-height: 1.5;">
                        {{ \Illuminate\Support\Str::limit($saran->pesan, 150) }}
                        @if(strlen($saran->pesan) > 150)
                            <button class="btn btn-link p-0 text-primary small fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#view-saran-{{ $saran->id_saran }}">Baca Selengkapnya</button>
                        @endif
                    </td>
                    <td class="px-4 text-muted small">{{ $saran->created_at->format('d M Y, H.i') }}</td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" data-bs-toggle="modal" data-bs-target="#view-saran-{{ $saran->id_saran }}" title="Lihat">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.saran.destroy', $saran) }}" method="POST" onsubmit="confirmDelete(event, 'Hapus saran ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" type="submit" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
            @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada saran atau masukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $sarans->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal View Saran -->
@foreach ($sarans as $saran)
    <div class="modal fade" id="view-saran-{{ $saran->id_saran }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Isi Saran / Masukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Dari</label>
                        <div class="text-dark fw-bold">{{ $saran->nama ?? ($saran->user->nama_lengkap ?? 'Anonim') }}</div>
                        <div class="text-muted small">{{ $saran->email ?? ($saran->user->email ?? '-') }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Pesan</label>
                        <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $saran->pesan }}</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary border-0 bg-light text-dark px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
