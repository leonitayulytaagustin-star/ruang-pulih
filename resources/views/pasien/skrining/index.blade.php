@extends('layouts.dashboard', ['title' => 'Daftar Skrining'])

@section('content')
<section class="hero-panel d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-clipboard-question me-2"></i> Skrining Kesehatan Mental</h1>
        <p class="mb-3 opacity-75">Lengkapi identitas dan riwayat kesehatan sebelum memilih tes skrining.</p>
        <a href="{{ route('pasien.skrining.riwayat') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-sm fw-bold rounded-pill px-4">
            <i class="fa-solid fa-clock-rotate-left me-2"></i> Lihat Riwayat Skrining
        </a>
    </div>
    <div class="bg-white bg-opacity-10 p-3 rounded-4 backdrop-blur shadow-sm d-flex flex-row align-items-center gap-3" style="position: relative; z-index: 2; width: 100%; max-width: 350px; backdrop-filter: blur(10px);">
        <i class="fa-solid fa-circle-info fs-3 opacity-75"></i>
        <p class="mb-0 fst-italic fw-medium" style="line-height: 1.4; font-size: 0.9rem;">Informasi ini membantu psikolog memahami kondisimu dengan lebih baik.</p>
    </div>
</section>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <form class="card border-0 shadow-sm rounded-4 overflow-hidden" method="POST" action="{{ route('pasien.skrining.store') }}">
            @csrf
            
            <div class="p-4 border-bottom bg-light">
                <h5 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-address-card me-2"></i> Identitas Diri</h5>
            </div>
            
            <div class="p-4">
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
                            <input class="form-control bg-light border-0" type="number" name="umur" value="{{ old('umur', $pasien->umur) }}" min="1" max="120" required>
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
                </div>
            </div>

            <div class="p-4 border-bottom border-top bg-light">
                <h5 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-notes-medical me-2"></i> Riwayat Kesehatan</h5>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Pernah mengalami gangguan mental?</label>
                        <select class="form-select bg-light border-0 focus-ring-primary" name="pernah_gangguan_mental" required>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jenis gangguan <span class="text-muted fw-normal">(opsional)</span></label>
                        <input class="form-control bg-light border-0 focus-ring-primary" name="jenis_gangguan" placeholder="Contoh: depresi, kecemasan">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Sedang konsumsi obat?</label>
                        <select class="form-select bg-light border-0 focus-ring-primary" name="sedang_konsumsi_obat" required>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama obat dan dosis <span class="text-muted fw-normal">(opsional)</span></label>
                        <input class="form-control bg-light border-0 focus-ring-primary" name="nama_obat_dosis" placeholder="Sebutkan nama obat dan dosis">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">Riwayat penyakit fisik <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea class="form-control bg-light border-0 focus-ring-primary" name="riwayat_penyakit_fisik" rows="2" placeholder="Contoh: hipertensi, diabetes, asma"></textarea>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">Catatan tambahan <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea class="form-control bg-light border-0 focus-ring-primary" name="catatan_tambahan" rows="3" placeholder="Tuliskan hal lain yang menurut Anda penting untuk diketahui psikolog"></textarea>
                    </div>
                </div>
                
                <div class="mt-5 pt-3 border-top text-end">
                    <button class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill" type="submit" id="btnSubmit">
                        Selanjutnya: Pilih Skrining <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi seluruh data identitas dan riwayat kesehatan yang wajib diisi.',
                    confirmButtonColor: '#005c34',
                });
            }
        });
    });
</script>
@endpush

<style>
    .focus-ring-primary:focus { box-shadow: 0 0 0 0.25rem rgba(0, 92, 52, 0.15) !important; outline: none; }
</style>
@endsection
