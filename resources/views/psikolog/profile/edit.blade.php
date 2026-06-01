@extends('layouts.dashboard', ['title' => 'Profil Psikolog'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-user-doctor me-2"></i> Profil Saya</h1>
        <p class="mb-0">Perbarui data diri, keahlian profesional, dan informasi kontak Anda.</p>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('psikolog.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PATCH')
            
            <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-camera text-primary me-2"></i> Foto Profil</h5>
                @include('profile.partials.photo-field')
            </div>

            <!-- Personal Information -->
            <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-address-card text-primary me-2"></i> Informasi Pribadi</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input class="form-control bg-light border-0" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-venus-mars text-muted"></i></span>
                            <select class="form-select bg-light border-0" name="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="laki-laki" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
                                <option value="perempuan" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan')>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-user-doctor text-primary me-2"></i> Detail Profesional</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Spesialisasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-stethoscope text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="spesialisasi" value="{{ old('spesialisasi', $psikolog?->spesialisasi) }}" placeholder="Contoh: Psikolog Klinis Dewasa">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor SIPA</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="nomor_sipa" value="{{ old('nomor_sipa', $psikolog?->nomor_sipa) }}" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-graduation-cap text-muted"></i></span>
                            <input class="form-control bg-light border-0" name="pendidikan" value="{{ old('pendidikan', $psikolog?->pendidikan) }}" placeholder="Contoh: S2 Magister Psikologi Profesi">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-briefcase text-muted"></i></span>
                            <input class="form-control bg-light border-0" type="number" name="pengalaman" min="0" value="{{ old('pengalaman', $psikolog?->pengalaman) }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Biografi / Tentang Saya</label>
                        <textarea class="form-control bg-light border-0" name="bio" rows="5" placeholder="Tuliskan perkenalan singkat tentang diri Anda...">{{ old('bio', $psikolog?->bio) }}</textarea>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-top text-end">
                    <button class="btn btn-primary px-4 shadow-sm fw-bold rounded-pill" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan Profil</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-4">
            <!-- Account Status -->
            <div class="card border-0 shadow-sm p-4 rounded-4 text-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-user-check fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Status Akun</h5>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold text-capitalize">
                    {{ $user->status_akun ?? 'Aktif' }}
                </span>
                <p class="text-muted small mt-3 mb-0">Akun Anda diverifikasi sebagai tenaga profesional psikolog Ruang Pulih.</p>
            </div>

            <!-- Autentikasi 2 Langkah -->
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-primary bg-opacity-10">
                <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-shield-halved me-2"></i> Keamanan Akun</h5>
                <p class="text-dark opacity-75 mb-3 small" style="line-height: 1.6;">
                    Status: {!! $user->two_factor_enabled ? '<span class="fw-bold text-success">Aktif</span>' : '<span class="fw-bold text-muted">Nonaktif</span>' !!}
                </p>
                <form action="{{ route('psikolog.profile.two-factor') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn {{ $user->two_factor_enabled ? 'btn-outline-danger' : 'btn-primary' }} w-100 fw-bold rounded-pill shadow-sm">
                        {{ $user->two_factor_enabled ? 'Nonaktifkan 2FA' : 'Aktifkan 2FA' }}
                    </button>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-danger bg-opacity-10">
                <h5 class="fw-bold mb-3 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Hapus Akun</h5>
                <p class="text-danger opacity-75 mb-4 small" style="line-height: 1.6;">
                    Menghapus akun akan menghilangkan semua data profesional dan riwayat konsultasi Anda secara permanen.
                </p>
                
                <form method="POST" action="{{ route('psikolog.profile.destroy') }}" onsubmit="confirmDelete(event, 'Apakah Anda yakin ingin menghapus akun profesional ini?')">
                    @csrf @method('DELETE')
                    <div class="mb-3">
                        <input class="form-control border-0" type="password" name="password" placeholder="Password untuk konfirmasi" required>
                    </div>
                    <button class="btn btn-danger w-100 shadow-sm fw-bold rounded-pill" type="submit"><i class="fa-solid fa-trash me-2"></i> Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
