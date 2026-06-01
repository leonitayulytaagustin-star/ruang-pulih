@extends('layouts.public', ['title' => 'Pusat Bantuan - Ruang Pulih'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bantuan.index') }}" class="text-primary text-decoration-none">Bantuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pusat Bantuan</li>
                </ol>
            </nav>

            <div class="text-center mb-5">
                <h1 class="fw-bold text-dark">Pusat Bantuan</h1>
                <p class="text-muted">Temukan jawaban atas pertanyaan umum seputar penggunaan Ruang Pulih.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="list-group border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                        <a href="#faq-umum" class="list-group-item list-group-item-action border-0 py-3 px-4 active">
                            <i class="fa-solid fa-info-circle me-2"></i> FAQ Umum
                        </a>
                        <a href="#faq-skrining" class="list-group-item list-group-item-action border-0 py-3 px-4">
                            <i class="fa-solid fa-clipboard-list me-2"></i> Skrining
                        </a>
                        <a href="#faq-konsultasi" class="list-group-item list-group-item-action border-0 py-3 px-4">
                            <i class="fa-solid fa-comment-dots me-2"></i> Konsultasi
                        </a>
                        <a href="#faq-akun" class="list-group-item list-group-item-action border-0 py-3 px-4">
                            <i class="fa-solid fa-user-gear me-2"></i> Akun & Profil
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- FAQ Umum -->
                    <div id="faq-umum" class="mb-5">
                        <h4 class="fw-bold mb-4">FAQ Umum</h4>
                        <div class="accordion" id="accordionUmum">
                            <div class="accordion-item border-0 shadow-sm rounded-4 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                        Apa itu Ruang Pulih?
                                    </button>
                                </h2>
                                <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#accordionUmum">
                                    <div class="accordion-body text-muted">
                                        Ruang Pulih adalah platform digital kesehatan mental yang menyediakan layanan skrining mandiri, pemantauan kondisi harian, dan konsultasi online bersama psikolog profesional.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0 shadow-sm rounded-4 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                        Apakah data saya aman?
                                    </button>
                                </h2>
                                <div id="q2" class="accordion-collapse collapse" data-bs-parent="#accordionUmum">
                                    <div class="accordion-body text-muted">
                                        Ya, privasi dan kerahasiaan data Anda adalah prioritas utama kami. Semua data skrining dan sesi konsultasi bersifat rahasia.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Skrining -->
                    <div id="faq-skrining" class="mb-5">
                        <h4 class="fw-bold mb-4">Skrining Kesehatan</h4>
                        <div class="accordion" id="accordionSkrining">
                            <div class="accordion-item border-0 shadow-sm rounded-4 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#s1">
                                        Berapa kali saya bisa melakukan skrining?
                                    </button>
                                </h2>
                                <div id="s1" class="accordion-collapse collapse" data-bs-parent="#accordionSkrining">
                                    <div class="accordion-body text-muted">
                                        Anda dapat melakukan satu kali tes per jenis skrining setiap harinya untuk mendapatkan hasil yang akurat sesuai kondisi terkini.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Konsultasi -->
                    <div id="faq-konsultasi" class="mb-5">
                        <h4 class="fw-bold mb-4">Konsultasi Online</h4>
                        <div class="accordion" id="accordionKonsultasi">
                            <div class="accordion-item border-0 shadow-sm rounded-4 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#k1">
                                        Bagaimana cara membuat janji konsultasi?
                                    </button>
                                </h2>
                                <div id="k1" class="accordion-collapse collapse" data-bs-parent="#accordionKonsultasi">
                                    <div class="accordion-body text-muted">
                                        Masuk ke menu Konsultasi, pilih psikolog yang tersedia, pilih jadwal yang Anda inginkan, dan tunggu konfirmasi dari pihak psikolog.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item.active { background-color: var(--primary-green); border-color: var(--primary-green); }
    .accordion-button:not(.collapsed) { background-color: var(--bs-primary-bg-subtle); color: var(--primary-green); box-shadow: none; }
</style>
@endsection
