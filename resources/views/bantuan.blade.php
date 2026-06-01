@extends('layouts.public', ['title' => 'Bantuan - Ruang Pulih'])

@section('content')
<style>
    .help-wrapper { margin: 64px 0; }
    .help-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 32px; }
    
    .help-card { 
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 28px; padding: 48px; 
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); 
        display: flex; flex-direction: column; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); 
    }
    .help-card:hover { transform: translateY(-10px); box-shadow: 0 25px 30px -10px rgba(0,0,0,0.08); border-color: #005c3444; }
    
    .icon-box { 
        width: 72px; height: 72px; background: var(--bs-primary-bg-subtle); 
        border-radius: 24px; color: var(--primary-green); display: flex; align-items: center; justify-content: center; 
        font-size: 32px; margin-bottom: 32px;
    }
    .card-title { font-size: 24px; font-weight: 800; color: #1a202c; margin-bottom: 20px; }
    .card-text { font-size: 16px; color: #4a5568; line-height: 1.75; margin-bottom: 28px; flex-grow: 1; }
    
    .list-item { padding: 8px 0; color: #4a5568; font-size: 15px; font-weight: 500; }
    .list-item i { color: #005c34; margin-right: 12px; font-size: 14px; }
    
    .btn-arrow { 
        margin-top: 32px; background: #f8fafc; color: #005c34; border-radius: 16px; 
        width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; 
        transition: all 0.4s ease; align-self: flex-end; text-decoration: none; font-size: 20px;
    }
    .btn-arrow:hover { background: #005c34; color: #ffffff; transform: scale(1.05); }
</style>

<section class="hero">
    <div>
        <h1>Bantuan untukmu</h1>
        <p>Kami siap membantumu kapan pun kamu membutuhkan bantuan. Pilih jenis bantuan yang sesuai dengan kebutuhanmu.</p>
    </div>
    <img class="hero-img" src="{{ asset('assets/images/banner.png') }}" alt="Bantuan Ruang Pulih">
</section>

<div class="help-wrapper">
    <div class="help-grid">
        @php
            $help_items = [
                ['fa-phone-volume', 'Bantuan Darurat', 'Bantuan cepat untuk kondisi emosional darurat atau dukungan segera.', ['Kontak layanan darurat'], route('bantuan.darurat')],
                ['fa-shield-halved', 'Keamanan Akun', 'Membantu menjaga keamanan akun agar tetap aman.', ['Ganti kata sandi', 'Verifikasi akun'], route('bantuan.keamanan')],
                ['fa-key', 'Reset Kata Sandi', 'Bantuan untuk memulihkan akses akun jika lupa kata sandi.', ['Lupa password', 'Reset melalui email'], route('password.request')],
                ['fa-circle-question', 'Pusat Bantuan', 'Kumpulan informasi untuk menggunakan aplikasi dengan mudah.', ['FAQ', 'Informasi akun'], route('bantuan.pusat-bantuan')],
                ['fa-bug', 'Laporkan Masalah', 'Laporkan kendala atau aktivitas yang tidak sesuai di dalam aplikasi.', ['Laporkan bug aplikasi', 'Penyalahgunaan akun'], route('bantuan.lapor')],
                ['fa-message', 'Saran & Masukan', 'Berikan masukan untuk meningkatkan kualitas aplikasi.', ['Kritik & saran', 'Penilaian layanan'], route('bantuan.saran')],
            ];
        @endphp

        @foreach ($help_items as [$icon, $judul, $teks, $items, $link])
            <div class="help-card">
                <div class="icon-box"><i class="fa-solid {{ $icon }}"></i></div>
                <h3 class="card-title">{{ $judul }}</h3>
                <p class="card-text">{{ $teks }}</p>
                <div style="border-top: 2px solid #f1f5f9; padding-top: 24px;">
                    @foreach ($items as $item)
                        <div class="list-item"><i class="fa-solid fa-check"></i>{{ $item }}</div>
                    @endforeach
                </div>
                <a href="{{ $link }}" class="btn-arrow"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endforeach
    </div>
</div>
@endsection
