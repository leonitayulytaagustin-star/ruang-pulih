@extends('layouts.public', ['title' => 'Saran & Masukan - Ruang Pulih'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bantuan.index') }}" class="text-primary text-decoration-none">Bantuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Saran & Masukan</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="bg-primary p-4 text-white text-center">
                    <i class="fa-solid fa-message fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0">Saran & Masukan</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <p class="text-muted mb-4 text-center">Bantu kami menjadi lebih baik. Suara Anda sangat berarti bagi pengembangan layanan Ruang Pulih kedepannya.</p>

                    <form action="{{ route('bantuan.saran.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control border-0 bg-light py-3 px-4 rounded-3" name="nama" value="{{ auth()->user()->nama_lengkap ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control border-0 bg-light py-3 px-4 rounded-3" name="email" value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Pesan Saran / Masukan</label>
                                <textarea class="form-control border-0 bg-light py-3 px-4 rounded-3" name="pesan" rows="6" placeholder="Tuliskan ide, kritik, atau saran Anda di sini..." required></textarea>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-sm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Kirim Masukan
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
            title: 'Terima Kasih',
            text: "{{ session('success') }}",
            confirmButtonColor: '#005c34',
        });
    @endif
</script>
@endpush
@endsection
