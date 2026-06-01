@extends('layouts.public', ['title' => 'Keamanan Akun - Ruang Pulih'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bantuan.index') }}" class="text-primary text-decoration-none">Bantuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keamanan Akun</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="bg-primary p-4 text-white text-center">
                    <i class="fa-solid fa-shield-halved fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0">Keamanan Akun</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <p class="text-muted mb-5">Keamanan data Anda adalah prioritas kami. Gunakan panduan di bawah ini untuk memastikan akun Anda tetap terlindungi.</p>

                    <div class="accordion" id="securityAccordion">
                        <!-- Item 1 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa-solid fa-key me-3 text-primary"></i> Gunakan Password yang Kuat
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#securityAccordion">
                                <div class="accordion-body text-muted">
                                    Gunakan kombinasi minimal 8 karakter yang terdiri dari huruf besar, huruf kecil, angka, dan simbol. Hindari menggunakan informasi pribadi seperti tanggal lahir atau nama hewan peliharaan.
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fa-solid fa-envelope-circle-check me-3 text-primary"></i> Verifikasi Email
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#securityAccordion">
                                <div class="accordion-body text-muted">
                                    Pastikan email Anda sudah terverifikasi. Email yang terverifikasi memudahkan Anda memulihkan akun jika lupa kata sandi dan menerima notifikasi keamanan penting.
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fa-solid fa-user-secret me-3 text-primary"></i> Aktivitas Mencurigakan
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#securityAccordion">
                                <div class="accordion-body text-muted">
                                    Jika Anda menerima notifikasi login dari perangkat yang tidak dikenal, segera ganti kata sandi Anda dan hubungi tim bantuan melalui fitur "Laporkan Masalah".
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 bg-light rounded-4 border-start border-4 border-primary">
                        <h6 class="fw-bold text-primary mb-2">Ingin segera mengamankan akun?</h6>
                        <p class="small text-muted mb-3">Klik tombol di bawah untuk langsung mengganti kata sandi Anda saat ini.</p>
                        <a href="{{ route('password.request') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Ganti Kata Sandi Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) { background-color: var(--bs-primary-bg-subtle); color: var(--primary-green); box-shadow: none; }
    .accordion-button:focus { box-shadow: none; border-color: rgba(0,0,0,.125); }
</style>
@endsection
