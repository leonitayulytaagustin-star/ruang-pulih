@extends('layouts.dashboard', ['title' => 'Manajemen Psikolog'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-user-doctor me-2"></i> Manajemen Psikolog</h1>
    <p>Kelola data psikolog, spesialisasi, SIPA, dan jadwal default konsultasi.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari nama atau SIPA...">
            </div>
            <select class="form-select border-0 bg-light w-auto" name="spesialisasi">
                <option value="">Semua Spesialisasi</option>
                @foreach ($spesialisasiList as $item)
                    <option value="{{ $item }}" @selected($spesialisasi === $item)>{{ $item }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary shadow-sm" type="submit">Filter</button>
        </form>
        <div class="d-flex gap-2">
            <a class="btn btn-primary shadow-sm" href="#tambah-psikolog" data-bs-toggle="modal" data-bs-target="#tambah-psikolog">
                <i class="fa-solid fa-plus me-1"></i> Tambah Psikolog
            </a>
        </div>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Nama</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Spesialisasi</th>
                    <th class="py-3 px-4">Telepon</th>
                    <th class="py-3 px-4 text-center">SIPA</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($psikologs as $psikolog)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $psikologs->firstItem() + $loop->index }}</td>
                    <td class="px-4 fw-bold text-dark">
                        <div class="d-flex align-items-center gap-2">
                            @if ($psikolog->user->foto_profil)
                                <img src="{{ $psikolog->user->foto_profil_url }}" alt="{{ $psikolog->user->nama_lengkap }}" class="rounded-circle object-fit-cover border border-light-subtle shadow-sm" style="width: 35px; height: 35px;">
                            @else
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                            @endif
                            {{ $psikolog->user->nama_lengkap }}
                        </div>
                    </td>
                    <td class="px-4 text-muted">{{ $psikolog->user->email }}</td>
                    <td class="px-4">
                        @if($psikolog->spesialisasi)
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $psikolog->spesialisasi }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="px-4 text-muted small">{{ $psikolog->user->nomor_telepon ?? '-' }}</td>
                    <td class="px-4 text-center">
                        <code class="bg-light px-2 py-1 rounded text-dark">{{ $psikolog->nomor_sipa }}</code>
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('admin.psikolog.show', $psikolog) }}" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-light text-warning rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="#edit-psikolog-{{ $psikolog->id_psikolog }}" data-bs-toggle="modal" data-bs-target="#edit-psikolog-{{ $psikolog->id_psikolog }}" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.psikolog.destroy', $psikolog) }}" method="POST" onsubmit="confirmDelete(event, 'Nonaktifkan psikolog ini secara permanen?')">
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
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-user-doctor fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Belum ada data psikolog.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($psikologs->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $psikologs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@include('admin.psikolog.partials.form-modal', ['id' => 'tambah-psikolog', 'title' => 'Tambah Psikolog', 'action' => route('admin.psikolog.store'), 'method' => 'POST', 'psikolog' => null])

@foreach ($psikologs as $psikolog)
    @include('admin.psikolog.partials.form-modal', ['id' => 'edit-psikolog-'.$psikolog->id_psikolog, 'title' => 'Edit Psikolog', 'action' => route('admin.psikolog.update', $psikolog), 'method' => 'PUT', 'psikolog' => $psikolog])
@endforeach
@endsection
