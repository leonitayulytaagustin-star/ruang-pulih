@extends('layouts.dashboard', ['title' => 'Manajemen Edukasi'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-newspaper me-2"></i> Manajemen Edukasi</h1>
    <p>Kelola artikel dan video edukasi untuk halaman publik Ruang Pulih.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari judul konten...">
            </div>
            <select class="form-select border-0 bg-light w-auto" name="tipe_konten">
                <option value="">Semua Tipe</option>
                <option value="artikel" @selected($tipe === 'artikel')>Artikel</option>
                <option value="video" @selected($tipe === 'video')>Video</option>
            </select>
            <button class="btn btn-primary shadow-sm" type="submit">Filter</button>
        </form>
        <div class="d-flex gap-2">
            <a class="btn btn-primary shadow-sm" href="#tambah-artikel" data-bs-toggle="modal" data-bs-target="#tambah-artikel">
                <i class="fa-solid fa-plus me-1"></i> Artikel
            </a>
            <a class="btn btn-secondary border-0 bg-light text-dark shadow-sm" href="#tambah-video" data-bs-toggle="modal" data-bs-target="#tambah-video">
                <i class="fa-solid fa-video me-1"></i> Video
            </a>
        </div>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4" style="width: 25%">Judul Konten</th>
                    <th class="py-3 px-4 text-center">Tipe</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Penulis</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($kontens as $konten)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $kontens->firstItem() + $loop->index }}</td>
                    <td class="px-4 fw-bold text-dark">{{ $konten->judul_konten }}</td>
                    <td class="px-4 text-center">
                        @if($konten->tipe_konten == 'artikel')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-file-lines me-1"></i> Artikel</span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-play me-1"></i> Video</span>
                        @endif
                    </td>
                    <td class="px-4">{{ $konten->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-4">{{ $konten->penulis->nama_lengkap ?? '-' }}</td>
                    <td class="px-4 text-muted small">{{ $konten->created_at->format('d M Y') }}</td>
                    <td class="px-4 text-center">
                        @if($konten->status === 'publish')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check-circle me-1"></i> Publish</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill"><i class="fa-solid fa-clock me-1"></i> Draft</span>
                        @endif
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('admin.edukasi.show', $konten) }}" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-light text-warning rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="#edit-konten-{{ $konten->id_konten }}" data-bs-toggle="modal" data-bs-target="#edit-konten-{{ $konten->id_konten }}" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.edukasi.destroy', $konten) }}" method="POST" onsubmit="confirmDelete(event, 'Hapus konten ini secara permanen?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" type="submit" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-folder-open fs-3 text-secondary"></i>
                        </div>
                        <br>Belum ada konten edukasi.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($kontens->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $kontens->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@include('admin.edukasi.partials.form-modal', ['id' => 'tambah-artikel', 'title' => 'Tambah Artikel', 'action' => route('admin.edukasi.store'), 'method' => 'POST', 'konten' => null, 'tipeDefault' => 'artikel'])
@include('admin.edukasi.partials.form-modal', ['id' => 'tambah-video', 'title' => 'Tambah Video', 'action' => route('admin.edukasi.store'), 'method' => 'POST', 'konten' => null, 'tipeDefault' => 'video'])
@foreach ($kontens as $konten)
    @include('admin.edukasi.partials.form-modal', ['id' => 'edit-konten-'.$konten->id_konten, 'title' => 'Edit Konten', 'action' => route('admin.edukasi.update', $konten), 'method' => 'PUT', 'konten' => $konten, 'tipeDefault' => $konten->tipe_konten])
@endforeach
@endsection
