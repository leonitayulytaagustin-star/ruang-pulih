@extends('layouts.dashboard', ['title' => 'Konsultasi Online'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-comments me-2"></i> Konsultasi Online</h1>
        <p class="mb-0 opacity-75">Lengkapi data keluhan, lalu pilih psikolog dan jadwal konsultasi yang sesuai dengan kebutuhanmu.</p>
    </div>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        <form class="card border-0 shadow-sm p-4 rounded-4" method="POST" action="{{ route('pasien.konsultasi.store') }}">
            @csrf
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-file-medical text-primary me-2"></i> Form Data Konsultasi</h5>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                        <input class="form-control bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark">Umur</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-cake-candles text-muted"></i></span>
                        <input class="form-control bg-light border-0" type="number" min="1" max="120" name="umur" value="{{ old('umur', $pasien->umur) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-venus-mars text-muted"></i></span>
                        <select class="form-select bg-light border-0" name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="laki-laki" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
                            <option value="perempuan" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'perempuan')>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                        <input class="form-control bg-light border-0" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-dark">Tingkat Urgensi</label>
                    <select class="form-select bg-light border-0" name="tingkat_urgensi">
                        <option value="rendah">Rendah - Hanya butuh teman cerita / keluhan ringan</option>
                        <option value="sedang">Sedang - Mengganggu aktivitas sehari-hari</option>
                        <option value="tinggi">Tinggi - Butuh penanganan segera / mengancam keselamatan</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-dark">Keluhan / Alasan Konsultasi</label>
                    <textarea class="form-control bg-light border-0" name="keluhan" rows="4" placeholder="Ceritakan sedikit tentang apa yang sedang kamu rasakan saat ini..." required>{{ old('keluhan') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check p-3 bg-light rounded-3 border">
                        <input class="form-check-input ms-1 me-2" type="checkbox" name="persetujuan_syarat" value="1" id="syarat" required>
                        <label class="form-check-label text-muted small" for="syarat">
                            Saya menyetujui syarat dan ketentuan serta kebijakan privasi yang berlaku di Ruang Pulih. Informasi yang saya berikan adalah benar.
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-top text-end">
                <button class="btn btn-primary px-4 shadow-sm fw-bold rounded-pill" type="submit">Lanjut Pilih Psikolog <i class="fa-solid fa-arrow-right ms-2"></i></button>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Riwayat Terbaru</h5>
                <a href="{{ route('pasien.konsultasi.riwayat') }}" class="btn btn-sm btn-light text-primary fw-bold rounded-pill">Lihat Semua</a>
            </div>
            
            <div class="d-flex flex-column gap-3">
                @forelse ($konsultasi as $item)
                    <div class="p-3 bg-light rounded-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="text-dark d-block text-truncate pe-2">{{ $item->psikolog->user->nama_lengkap ?? '-' }}</strong>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small flex-shrink-0 text-capitalize">{{ str_replace('_', ' ', $item->status_konsultasi) }}</span>
                        </div>
                        <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ optional($item->tanggal_konsultasi)->format('d M Y') }}</small>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-folder-open fs-2 opacity-25 mb-3 d-block"></i>
                        <small class="fst-italic">Belum ada riwayat konsultasi.</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
