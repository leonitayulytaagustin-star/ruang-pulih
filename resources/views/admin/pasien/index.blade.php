@extends('layouts.dashboard', ['title' => 'Manajemen Pasien'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-users me-2"></i> Manajemen Pasien</h1>
    <p>Pantau data pasien, riwayat skrining, konsultasi, dan pemantauan kondisi mental.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari nama pasien...">
            </div>
            <select class="form-select border-0 bg-light w-auto" name="jenis_kelamin">
                <option value="">Semua Jenis Kelamin</option>
                <option value="laki-laki" @selected($gender === 'laki-laki')>Laki-laki</option>
                <option value="perempuan" @selected($gender === 'perempuan')>Perempuan</option>
            </select>
            <button class="btn btn-primary shadow-sm" type="submit">Filter</button>
        </form>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Nama Pasien</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Tanggal Daftar</th>
                    <th class="py-3 px-4">Telepon</th>
                    <th class="py-3 px-4 text-center">Jenis Kelamin</th>
                    <th class="py-3 px-4 text-center" style="width: 10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pasiens as $pasien)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $pasiens->firstItem() + $loop->index }}</td>
                    <td class="px-4 fw-bold text-dark">{{ $pasien->user->nama_lengkap }}</td>
                    <td class="px-4 text-muted">{{ $pasien->user->email }}</td>
                    <td class="px-4 text-muted small">{{ optional($pasien->tanggal_daftar)->format('d M Y') ?? '-' }}</td>
                    <td class="px-4">{{ $pasien->user->nomor_telepon ?? '-' }}</td>
                    <td class="px-4 text-center">
                        @if($pasien->user->jenis_kelamin == 'laki-laki')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-mars me-1"></i> Laki-laki</span>
                        @elseif($pasien->user->jenis_kelamin == 'perempuan')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-venus me-1"></i> Perempuan</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="px-4">
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('admin.pasien.show', $pasien) }}" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-users-slash fs-3 text-secondary"></i>
                        </div>
                        <br>Data pasien belum tersedia.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($pasiens->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $pasiens->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
