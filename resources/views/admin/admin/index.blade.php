@extends('layouts.dashboard', ['title' => 'Manajemen Admin'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-user-shield me-2"></i> Manajemen Admin</h1>
    <p>Kelola akun administrator Ruang Pulih.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari nama admin...">
            </div>
            <button class="btn btn-primary shadow-sm" type="submit">Cari</button>
        </form>
        <div class="d-flex gap-2">
            <a class="btn btn-primary shadow-sm" href="#tambah-admin" data-bs-toggle="modal" data-bs-target="#tambah-admin">
                <i class="fa-solid fa-plus me-1"></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Nama Admin</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4 text-center">Jenis Kelamin</th>
                    <th class="py-3 px-4">Telepon</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($admins as $admin)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $admins->firstItem() + $loop->index }}</td>
                    <td class="px-4 fw-bold text-dark">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            {{ $admin->user->nama_lengkap }}
                            @if($admin->id_user === auth()->id())
                                <span class="badge bg-success bg-opacity-10 text-success ms-2 rounded-pill" style="font-size: 0.7rem;">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 text-muted">{{ $admin->user->email }}</td>
                    <td class="px-4 text-center">
                        @if($admin->user->jenis_kelamin == 'laki-laki')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-mars me-1"></i> Laki-laki</span>
                        @elseif($admin->user->jenis_kelamin == 'perempuan')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-venus me-1"></i> Perempuan</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="px-4 text-muted small">{{ $admin->user->nomor_telepon ?? '-' }}</td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('admin.admin.show', $admin) }}" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-light text-warning rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="#edit-admin-{{ $admin->id_admin }}" data-bs-toggle="modal" data-bs-target="#edit-admin-{{ $admin->id_admin }}" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @if ($admin->id_user !== auth()->id())
                                <form action="{{ route('admin.admin.destroy', $admin) }}" method="POST" onsubmit="confirmDelete(event, 'Nonaktifkan admin ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" type="submit" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <div style="width: 35px; height: 35px;"></div>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-user-shield fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Belum ada data admin.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($admins->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $admins->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@include('admin.admin.partials.form-modal', ['id' => 'tambah-admin', 'title' => 'Tambah Admin', 'action' => route('admin.admin.store'), 'method' => 'POST', 'admin' => null])
@foreach ($admins as $admin)
    @include('admin.admin.partials.form-modal', ['id' => 'edit-admin-'.$admin->id_admin, 'title' => 'Edit Admin', 'action' => route('admin.admin.update', $admin), 'method' => 'PUT', 'admin' => $admin])
@endforeach
@endsection
