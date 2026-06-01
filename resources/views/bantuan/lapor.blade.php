@extends('layouts.public', ['title' => 'Laporkan Masalah - Ruang Pulih'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bantuan.index') }}" class="text-primary text-decoration-none">Bantuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporkan Masalah</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="bg-primary p-4 text-white text-center">
                    <i class="fa-solid fa-bug fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0">Laporkan Masalah</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <p class="text-muted mb-4">Menemukan kendala teknis atau konten yang tidak pantas? Informasikan kepada kami agar kami dapat segera menindaklanjutinya.</p>

                    <form action="{{ route('bantuan.lapor.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kategori Masalah</label>
                            <select class="form-select border-0 bg-light py-3 px-4 rounded-3" name="kategori" required>
                                <option value="" disabled selected>Pilih kategori...</option>
                                <option value="bug">Bug / Masalah Teknis Aplikasi</option>
                                <option value="konten">Konten Tidak Pantas</option>
                                <option value="penyalahgunaan">Penyalahgunaan Akun</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" class="form-control border-0 bg-light py-3 px-4 rounded-3" name="judul" placeholder="Contoh: Gagal memuat halaman skrining" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Masalah</label>
                            <textarea class="form-control border-0 bg-light py-3 px-4 rounded-3" name="deskripsi" rows="5" placeholder="Jelaskan secara detail masalah yang Anda temui..." required></textarea>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-sm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Laporan Diterima',
            text: "{{ session('success') }}",
            confirmButtonColor: '#005c34',
        });
    @endif
</script>
@endpush
@endsection
