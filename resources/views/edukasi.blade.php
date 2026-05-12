@extends('layouts.app')

@section('content')

<style>
    .edukasi-container{
    width: calc(100% - 148px);
    margin: 0 auto;
    padding: 16px 0 25px;
}

    .banner {
    width: 100%;
    height: 273px;
    border-radius: 12px;
    background: linear-gradient(90deg, #CFFFDD 0%, #B8EFD4 45%, #55CDA3 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-left: 95px;
    position: relative;
}

.banner-text {
    width: 48%;
    z-index: 2;
}

.banner-text h1 {
    font-size: 30px;
    line-height: 1.15;
    font-weight: 800;
    color: #005C34;
    margin-bottom: 22px;
}

.banner-text p {
    font-size: 17px;
    line-height: 1.35;
    color: #111;
    width: 580px;
    margin-bottom: 30px;
}

.banner-btn {
    width: 255px;
    height: 54px;
    background: #005C34;
    color: #fff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 28px;
    font-size: 17px;
    font-weight: 500;
}

.banner-btn span {
    font-size: 35px;
    line-height: 1;
}

.banner img {
    height: 273px;
    width: 50%;
    object-fit: contain;
    object-position: center right;
    margin-right: 120px;
}

    .search-box {
        height: 60px;
        margin-top: 8px;
        border: 1px solid #9b9b9b;
        border-radius: 11px;
        display: flex;
        align-items: center;
        padding: 0 38px;
        background: #fff;
    }

    .search-icon {
        width: 28px;
        height: 28px;
        border: 2px solid #111;
        border-radius: 50%;
        position: relative;
        flex-shrink: 0;
    }

    .search-icon::after {
        content: "";
        width: 14px;
        height: 2px;
        background: #111;
        position: absolute;
        right: -10px;
        bottom: -5px;
        transform: rotate(45deg);
        border-radius: 5px;
    }

    .search-box input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 19px;
        margin-left: 32px;
        color: #777;
    }

    .category {
        display: flex;
        gap: 32px;
        margin-top: 14px;
    }

    .category button {
        width: 165px;
        height: 41px;
        border-radius: 24px;
        border: 1px solid #999;
        background: #fff;
        font-size: 19px;
        color: #222;
    }

    .category .selected {
        background: #005C34;
        color: #fff;
        border-color: #005C34;
    }

    .title {
        margin-top: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .title h2 {
        font-size: 27px;
        font-weight: 800;
    }

    .lihat {
        color: #005C34;
        font-size: 21px;
        font-weight: 500;
        margin-right: 32px;
    }

    .card-container {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 58px;
    }

    .card {
        border: 1px solid #9d9d9d;
        border-radius: 9px;
        overflow: hidden;
        background: #fff;
    }

    .card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        display: block;
    }

    .card-content {
        padding: 8px 12px 7px;
    }

    .card-content h3 {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.22;
        margin-bottom: 5px;
    }

    .card-content p {
        color: #666;
        font-size: 16px;
        line-height: 1.25;
        margin-bottom: 14px;
    }

    .info {
        display: flex;
        align-items: center;
        gap: 24px;
        color: #666;
        font-size: 16px;
    }

    .dot {
        width: 7px;
        height: 7px;
        background: #666;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<div class="edukasi-container">

    <div class="banner">
    <div class="banner-text">
        <h1>Belajar, Peduli,<br>Pulih Bersama.</h1>

        <p>
            Temukan informasi dan pengetahuan seputar kesehatan mental
            yang dapat membantu kamu menjalani hidup lebih seimbang.
        </p>

        <a href="#artikel" class="banner-btn">
            Jelajahi Edukasi
            <span>→</span>
        </a>
    </div>

    <img src="{{ asset('assets/images/banner.png') }}" alt="Banner Edukasi">
</div>

    <div class="search-box">
        <span class="search-icon"></span>
        <input type="text" placeholder="Cari artikel, tips, atau video edukasi...">
    </div>

    <div class="category">
        <button class="selected">Semua</button>
        <button>Artikel</button>
        <button>Tips Stres</button>
        <button>Video Edukasi</button>
    </div>

    <div class="title">
        <h2>Artikel Terbaru</h2>
       
    </div>

    <div class="card-container">

        @forelse($artikels ?? [] as $artikel)
            <div class="card">
                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}">

                <div class="card-content">
                    <h3>{{ $artikel->judul }}</h3>
                    <p>{{ Str::limit($artikel->deskripsi, 95) }}</p>

                    <div class="info">
                        <span>{{ $artikel->created_at->translatedFormat('j M Y') }}</span>
                        <span class="dot"></span>
                        <span>{{ $artikel->durasi_baca ?? '5 min baca' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <img src="{{ asset('assets/images/artikel13.png') }}" alt="Artikel 1">
                <div class="card-content">
                    <h3>4 Manfaat Support System untuk Kesehatan Mental yang Perlu Diketahui</h3>
                    <p>Dukungan dari orang sekitar dapat menjadi kekuatan besar dalam proses pemulihan.</p>
                    <div class="info">
                        <span>9 Mei 2026</span>
                        <span class="dot"></span>
                        <span>6 min baca</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('assets/images/artikel12.png') }}" alt="Artikel 2">
                <div class="card-content">
                    <h3>Stres - Gejala, Penyebab, dan Pengobatan</h3>
                    <p>Kenali stres lebih dalam dan cara efektif untuk mengelolanya dengan sehat.</p>
                    <div class="info">
                        <span>5 Mei 2026</span>
                        <span class="dot"></span>
                        <span>5 min baca</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('assets/images/artikel11.png') }}" alt="Artikel 3">
                <div class="card-content">
                    <h3>7 Cara Mengatasi Overwhelmed agar Hidup Lebih Tenang</h3>
                    <p>Langkah-langkah sederhana untuk menjaga kesehatan mental saat merasa kewalahan.</p>
                    <div class="info">
                        <span>1 Mei 2026</span>
                        <span class="dot"></span>
                        <span>8 min baca</span>
                    </div>
                </div>
            </div>
        @endforelse

    </div>

</div>

@endsection