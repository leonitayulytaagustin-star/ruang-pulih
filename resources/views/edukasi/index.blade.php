@extends('layouts.public', ['title' => 'Edukasi - Ruang Pulih'])

@section('content')
<section class="hero">
    <div>
        <h1>Belajar, Peduli,<br>Pulih Bersama.</h1>
        <p>Temukan informasi dan pengetahuan seputar kesehatan mental yang dapat membantu kamu menjalani hidup lebih seimbang.</p>
        <a href="#artikel" class="btn">Jelajahi Edukasi</a>
    </div>
    <img class="hero-img" src="{{ asset('assets/images/banner.png') }}" alt="Edukasi kesehatan mental">
</section>

<style>
    /* Premium UI Components */
    .search-bar { 
        align-items: center; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; 
        display: flex; height: 52px; margin: 32px 0; padding: 0 20px; transition: all 0.3s ease;
    }
    .search-bar:focus-within { border-color: #005c34; box-shadow: 0 4px 12px rgba(0, 92, 52, 0.15); }
    .search-bar input { border: 0; flex: 1; font-size: 15px; outline: 0; padding-left: 12px; color: #2d3748; }
    .search-bar i { color: #a0aec0; font-size: 18px; }

    .tabs { 
        display: flex; gap: 12px; margin-bottom: 40px; overflow-x: auto; 
        padding-bottom: 8px; scrollbar-width: none; -ms-overflow-style: none;
        -webkit-overflow-scrolling: touch;
    }
    .tabs::-webkit-scrollbar { display: none; }
    .tabs a { 
        border: 1px solid #e2e8f0; border-radius: 24px; padding: 8px 24px; font-size: 14px; 
        font-weight: 600; background: #ffffff; color: #4a5568; transition: all 0.3s ease;
        white-space: nowrap; flex-shrink: 0;
    }
    .tabs a:hover { background: #f7fafc; border-color: #cbd5e0; }
    .tabs a.active { background: #005c34; border-color: #005c34; color: #ffffff; box-shadow: 0 4px 6px rgba(0, 92, 52, 0.2); }

    .section-title { font-size: 24px; font-weight: 800; color: #1a202c; margin: 48px 0 24px; }

    /* Modernized Cards */
    .grid-3 { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
    .card { 
        background: #ffffff; border: 1px solid #edf2f7; border-radius: 20px; overflow: hidden; 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); display: flex; flex-direction: column;
        text-decoration: none; color: inherit;
    }
    .card:hover { border-color: #005c34; transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
    .card img { width: 100%; height: 190px; object-fit: cover; }
    
    .card-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .card-body h3 { font-size: 18px; font-weight: 700; color: #2d3748; margin-bottom: 12px; line-height: 1.4; }
    .card-body p.muted { font-size: 14px; color: #718096; line-height: 1.6; margin-bottom: 16px; flex-grow: 1; }
    
    .article-meta { display: flex; align-items: center; gap: 10px; font-size: 12px; color: #a0aec0; font-weight: 600; }
    .dot { width: 4px; height: 4px; background: #cbd5e0; border-radius: 50%; }
    
    .play-btn { 
        position: absolute; left: 16px; top: 16px; background: rgba(0, 92, 52, 0.9); 
        color: #ffffff; border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.05em; backdrop-filter: blur(4px);
    }

    /* Mobile Responsiveness */
    @media (min-width: 1024px) {
        .tabs { flex-wrap: wrap; overflow-x: visible; }
    }

    @media (max-width: 768px) {
        .grid-3 { grid-template-columns: 1fr; gap: 20px; }
        .tabs { gap: 8px; margin-bottom: 24px; padding-left: 4px; }
        .tabs a { padding: 8px 18px; font-size: 13px; }
        .section-title { font-size: 20px; margin-top: 32px; }
        .card img { height: 160px; }
        .card-body h3 { font-size: 16px; }
        .search-bar { height: 48px; margin: 24px 0; }
    }
</style>

<form class="search-bar" method="GET" action="{{ route('edukasi.index') }}">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input name="search" value="{{ $search }}" placeholder="Cari artikel, tips, atau video edukasi...">
    <input type="hidden" name="filter" value="{{ $filter }}">
</form>

<div class="tabs">
    <a class="{{ blank($filter) ? 'active' : '' }}" href="{{ route('edukasi.index', ['search' => $search]) }}">Semua</a>
    @foreach($categories as $cat)
        <a class="{{ $filter == $cat->id_kategori ? 'active' : '' }}" href="{{ route('edukasi.index', ['filter' => $cat->id_kategori, 'search' => $search]) }}">
            {{ $cat->nama_kategori }}
        </a>
    @endforeach
    <a class="{{ $filter === 'artikel' ? 'active' : '' }}" href="{{ route('edukasi.index', ['filter' => 'artikel', 'search' => $search]) }}">Hanya Artikel</a>
    <a class="{{ $filter === 'video' ? 'active' : '' }}" href="{{ route('edukasi.index', ['filter' => 'video', 'search' => $search]) }}">Hanya Video</a>
</div>

@if(blank($filter) || is_numeric($filter) || $filter === 'artikel')
<h2 id="artikel" class="section-title">Artikel Terbaru</h2>
<div class="grid-3">
    @forelse ($artikels as $artikel)
        <a class="card article-card" href="{{ route('edukasi.show', $artikel->slug) }}">
            <img src="{{ $artikel->thumbnail_url ?? asset('assets/no-image.png') }}" alt="{{ $artikel->judul_konten }}">
            <div class="card-body">
                <h3>{{ $artikel->judul_konten }}</h3>
                <p class="muted">{{ \Illuminate\Support\Str::limit(strip_tags($artikel->isi_artikel), 115) }}</p>
                <div class="article-meta">
                    <span>{{ optional($artikel->tanggal_publish ?? $artikel->created_at)->translatedFormat('j M Y') }}</span>
                    <span class="dot"></span>
                    <span>{{ max(3, ceil(str_word_count(strip_tags($artikel->isi_artikel ?? '')) / 180)) }} min baca</span>
                </div>
            </div>
        </a>
    @empty
        <div class="card card-body" style="grid-column:1/-1;">Belum ada artikel publish.</div>
    @endforelse
</div>
@if ($artikels->lastPage() > 1)
    <nav class="page-numbers" aria-label="Halaman artikel">
        @for ($page = 1; $page <= $artikels->lastPage(); $page++)
            @if ($page === $artikels->currentPage())
                <span class="active" aria-current="page">{{ $page }}</span>
            @else
                <a href="{{ $artikels->appends(request()->except('artikel_page'))->url($page) }}">{{ $page }}</a>
            @endif
        @endfor
    </nav>
@endif
@endif

@if ((blank($filter) || is_numeric($filter) || $filter === 'video') && $videos->isNotEmpty())
    <h2 class="section-title">Video Edukasi</h2>
    <div class="grid-3">
        @foreach ($videos as $video)
            <a class="card video-card" href="{{ route('edukasi.video', $video->slug) }}">
                <div style="position:relative;">
                    <img src="{{ $video->thumbnail_url ?? asset('assets/no-image.png') }}" alt="{{ $video->judul_konten }}">
                    <span class="play-btn"><i class="fa-solid fa-play" style="font-size:8px;margin-right:4px;"></i> Play</span>
                </div>
                <div class="card-body">
                    <h3>{{ $video->judul_konten }}</h3>
                    <p class="muted">{{ $video->kategori->nama_kategori ?? 'Video Edukasi' }} • {{ $video->durasi_video }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
