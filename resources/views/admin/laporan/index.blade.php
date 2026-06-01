@extends('layouts.dashboard', ['title' => 'Manajemen Laporan Masalah'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-bug me-2"></i> Laporan Masalah</h1>
    <p>Pantau dan kelola kendala teknis atau laporan pengguna yang masuk.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari judul/pelapor...">
            </div>
            <select class="form-select border-0 bg-light w-auto" name="status">
                <option value="">Semua Status</option>
                <option value="pending" @selected($status === 'pending')>Pending</option>
                <option value="diproses" @selected($status === 'diproses')>Diproses</option>
                <option value="selesai" @selected($status === 'selesai')>Selesai</option>
            </select>
            <button class="btn btn-primary shadow-sm" type="submit">Filter</button>
        </form>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Judul / Kategori</th>
                    <th class="py-3 px-4">Pelapor</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($laporans as $laporan)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $laporans->firstItem() + $loop->index }}</td>
                    <td class="px-4">
                        <div class="fw-bold text-dark mb-1">{{ $laporan->judul }}</div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary small px-2 py-1 rounded-pill text-capitalize">{{ $laporan->kategori }}</span>
                    </td>
                    <td class="px-4">
                        <div class="text-dark fw-medium">{{ $laporan->user->nama_lengkap ?? 'Anonim' }}</div>
                        <div class="text-muted small">{{ $laporan->user->email ?? '-' }}</div>
                    </td>
                    <td class="px-4 text-muted small">{{ $laporan->created_at->format('d M Y, H.i') }}</td>
                    <td class="px-4 text-center">
                        @php
                            $status_class = match($laporan->status_laporan) {
                                'pending' => 'bg-danger',
                                'diproses' => 'bg-warning',
                                'selesai' => 'bg-success',
                            };
                        @endphp
                        <span class="badge {{ $status_class }} bg-opacity-10 {{ str_replace('bg-', 'text-', $status_class) }} px-3 py-2 rounded-pill text-capitalize">
                            {{ $laporan->status_laporan }}
                        </span>
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" data-bs-toggle="modal" data-bs-target="#view-laporan-{{ $laporan->id_laporan }}" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST" onsubmit="confirmDelete(event, 'Hapus laporan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" type="submit" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
            @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada laporan masalah.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $laporans->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modals Detail & Update Status -->
@foreach ($laporans as $laporan)
    <div class="modal fade" id="view-laporan-{{ $laporan->id_laporan }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Judul Laporan</label>
                        <div class="text-dark fw-bold fs-5">{{ $laporan->judul }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Kategori</label>
                        <div class="text-dark text-capitalize">{{ $laporan->kategori }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Deskripsi Masalah</label>
                        <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-wrap;">{{ $laporan->deskripsi }}</div>
                    </div>
                    
                    <form action="{{ route('admin.laporan.status', $laporan) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="mb-0">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-2">Update Status Penanganan</label>
                            <div class="d-flex gap-2">
                                <select class="form-select border-0 bg-light" name="status_laporan">
                                    <option value="pending" @selected($laporan->status_laporan === 'pending')>Pending</option>
                                    <option value="diproses" @selected($laporan->status_laporan === 'diproses')>Diproses</option>
                                    <option value="selesai" @selected($laporan->status_laporan === 'selesai')>Selesai</option>
                                </select>
                                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
