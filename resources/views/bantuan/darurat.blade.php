@extends('layouts.public', ['title' => 'Bantuan Darurat - Ruang Pulih'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bantuan.index') }}" class="text-primary text-decoration-none">Bantuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bantuan Darurat</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="bg-primary p-4 text-white text-center">
                    <i class="fa-solid fa-phone-volume fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0">Bantuan Darurat</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-primary border-0 rounded-4 mb-4">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-triangle-exclamation fs-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Penting!</h5>
                                <p class="mb-0">Jika Anda atau seseorang yang Anda kenal sedang dalam bahaya atau memikirkan untuk menyakiti diri sendiri, harap segera hubungi layanan bantuan di bawah ini.</p>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-4">Kontak Layanan Darurat (Indonesia)</h4>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between p-4 bg-light rounded-4 border">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-phone text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Layanan Darurat Nasional</h6>
                                    <span class="text-muted small">Polisi, Ambulans, Damkar</span>
                                </div>
                            </div>
                            <a href="tel:112" class="btn btn-primary rounded-pill px-4 fw-bold">112</a>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-4 bg-light rounded-4 border">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-heart-pulse text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Halo Kemenkes</h6>
                                    <span class="text-muted small">Layanan Informasi Kesehatan Nasional</span>
                                </div>
                            </div>
                            <a href="tel:1500567" class="btn btn-primary rounded-pill px-4 fw-bold">1500-567</a>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-4 bg-light rounded-4 border">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-user-doctor text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">SEJIWA</h6>
                                    <span class="text-muted small">Layanan Psikologi untuk Sehat Jiwa</span>
                                </div>
                            </div>
                            <a href="tel:119" class="btn btn-primary rounded-pill px-4 fw-bold">119 (Ext 8)</a>
                        </div>
                    </div>

                    <div class="mt-5 p-4 border rounded-4 text-center bg-light bg-opacity-50">
                        <h5 class="fw-bold mb-3">Kapan Harus Menghubungi?</h5>
                        <p class="text-muted mb-0 mx-auto" style="max-width: 600px;">
                            Jangan ragu untuk menghubungi layanan di atas jika Anda merasa tidak aman, mengalami krisis emosional yang hebat, atau membutuhkan bantuan medis segera. Kesehatan dan nyawa Anda adalah yang utama.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
