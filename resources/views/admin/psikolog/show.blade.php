@extends('layouts.dashboard', ['title' => 'Detail Psikolog'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-4" style="position: relative; z-index: 2;">
        @if ($psikolog->user->foto_profil)
            <img src="{{ $psikolog->user->foto_profil_url }}" alt="{{ $psikolog->user->nama_lengkap }}" class="rounded-circle object-fit-cover border border-light-subtle shadow" style="width: 100px; height: 100px;">
        @else
            <div class="bg-white bg-opacity-25 text-white rounded-circle d-flex justify-content-center align-items-center shadow" style="width: 100px; height: 100px;">
                <i class="fa-solid fa-user-doctor fs-1"></i>
            </div>
        @endif
        <div>
            <h1 class="mb-1 fw-bold">{{ $psikolog->user->nama_lengkap }}</h1>
            <div class="d-flex align-items-center gap-2 mt-2">
                <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-stethoscope me-1"></i> {{ $psikolog->spesialisasi ?? 'Psikolog' }}</span>
                <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-id-card me-1"></i> SIPA: {{ $psikolog->nomor_sipa }}</span>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.psikolog.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-envelope fs-3"></i>
            </div>
            <div style="overflow: hidden; text-overflow: ellipsis;">
                <small class="text-muted fw-semibold d-block mb-1">Email</small>
                <h6 class="mb-0 fw-bold text-truncate" title="{{ $psikolog->user->email }}">{{ $psikolog->user->email }}</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-phone fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Telepon</small>
                <h5 class="mb-0 fw-bold">{{ $psikolog->user->nomor_telepon ?? '-' }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-briefcase fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Pengalaman</small>
                <h5 class="mb-0 fw-bold">{{ $psikolog->pengalaman ?? 0 }} Tahun</h5>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 p-4 h-100">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-address-card text-primary me-2"></i> Tentang Psikolog</h5>
            <div class="mb-4">
                <small class="text-muted d-block mb-1">Pendidikan</small>
                <strong class="text-dark">{{ $psikolog->pendidikan ?? 'Belum diisi' }}</strong>
            </div>
            <div>
                <small class="text-muted d-block mb-2">Biografi</small>
                @if($psikolog->bio)
                    <div class="p-3 bg-light rounded-3 text-muted" style="line-height: 1.7;">
                        {{ $psikolog->bio }}
                    </div>
                @else
                    <p class="text-muted fst-italic">Belum ada biografi.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 p-4 h-100">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-regular fa-calendar-check text-primary me-2"></i> Jadwal Mendatang</h5>
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4"><i class="fa-regular fa-clock me-1"></i> Waktu</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($psikolog->jadwal as $slot)
                        <tr class="border-bottom">
                            <td class="px-4 fw-medium text-dark">{{ $slot->tanggal->format('d M Y') }}</td>
                            <td class="px-4 text-muted">{{ str_replace(':', '.', substr($slot->jam_mulai, 0, 5)) }} - {{ str_replace(':', '.', substr($slot->jam_selesai, 0, 5)) }} WIB</td>
                            <td class="px-4 text-center">
                                @if(strtolower($slot->status_jadwal) == 'tersedia')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">{{ $slot->status_jadwal }}</span>
                                @elseif(strtolower($slot->status_jadwal) == 'dipesan')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">{{ $slot->status_jadwal }}</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">{{ $slot->status_jadwal }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-calendar-xmark fs-2 opacity-50 mb-3 d-block"></i>
                                Belum ada jadwal yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
