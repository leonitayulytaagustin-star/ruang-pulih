@extends('layouts.dashboard', ['title' => 'Profil Pasien'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-user-gear me-2"></i> Profil Saya</h1>
        <p class="mb-0">Perbarui data akun, email, dan informasi kontak kamu.</p>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-address-card text-primary me-2"></i> Informasi Profil</h5>
            
            <form method="POST" action="{{ route('pasien.profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')
                @include('profile.partials.photo-field')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input class="form-control bg-light border-0" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Umur</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-cake-candles text-muted"></i></span>
                            <input class="form-control bg-light border-0" type="number" min="1" max="120" name="umur" value="{{ old('umur', $pasien->umur ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-venus-mars text-muted"></i></span>
                            <select class="form-select bg-light border-0" name="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="laki-laki" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
                                <option value="perempuan" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan')>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-top text-end">
                    <button class="btn btn-primary px-4 shadow-sm fw-bold rounded-pill" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Autentikasi 2 Langkah --}}
        <div class="card border-0 shadow-sm p-4 rounded-4 mt-4">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-shield-halved text-primary me-2"></i> Autentikasi 2 Langkah</h5>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <p class="mb-1 fw-bold text-dark">Status: {!! $user->two_factor_enabled ? '<span class="text-success">Aktif</span>' : '<span class="text-muted">Nonaktif</span>' !!}</p>
                    <p class="text-muted small mb-0">Tingkatkan keamanan akunmu dengan verifikasi email tambahan saat login.</p>
                </div>
                <form action="{{ route('pasien.profile.two-factor') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn {{ $user->two_factor_enabled ? 'btn-outline-danger' : 'btn-primary' }} px-4 fw-bold rounded-pill shadow-sm">
                        <i class="fa-solid {{ $user->two_factor_enabled ? 'fa-lock-open' : 'fa-lock' }} me-2"></i>
                        {{ $user->two_factor_enabled ? 'Nonaktifkan 2FA' : 'Aktifkan 2FA' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-danger bg-opacity-10">
            <h5 class="fw-bold mb-3 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Hapus Akun</h5>
            <p class="text-danger opacity-75 mb-4 small" style="line-height: 1.6;">
                Setelah akun kamu dihapus, semua riwayat skrining, konsultasi, dan pemantauan mental akan dihapus secara permanen. Silakan masukkan password kamu untuk mengonfirmasi.
            </p>
            
            <form method="POST" action="{{ route('pasien.profile.destroy') }}" onsubmit="confirmDelete(event, 'Apakah kamu yakin ingin menghapus akun ini secara permanen?')">
                @csrf @method('DELETE')
                <div class="mb-3">
                    <input class="form-control border-0" type="password" name="password" placeholder="Password saat ini" required>
                </div>
                <button class="btn btn-danger w-100 shadow-sm fw-bold rounded-pill" type="submit"><i class="fa-solid fa-trash me-2"></i> Hapus Akun Saya</button>
            </form>
        </div>
    </div>
</div>
@endsection
