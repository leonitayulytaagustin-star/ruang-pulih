@extends('layouts.dashboard', ['title' => 'Detail Edukasi'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2">{{ $edukasi->judul_konten }}</h1>
        <div class="d-flex align-items-center gap-2 mt-2">
            @if($edukasi->tipe_konten == 'artikel')
                <span class="badge bg-primary bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-file-lines me-1"></i> Artikel</span>
            @else
                <span class="badge bg-warning bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-play me-1"></i> Video</span>
            @endif
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-tag me-1"></i> {{ $edukasi->kategori->nama_kategori ?? '-' }}</span>
            @if($edukasi->status === 'publish')
                <span class="badge bg-success bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-check-circle me-1"></i> Publish</span>
            @else
                <span class="badge bg-secondary bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-clock me-1"></i> Draft</span>
            @endif
        </div>
    </div>
    <a href="{{ route('admin.edukasi.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 p-4">
            @if ($edukasi->thumbnail_url)
                <img src="{{ $edukasi->thumbnail_url }}" alt="{{ $edukasi->judul_konten }}" class="w-100 rounded-4 shadow-sm mb-4" style="max-height: 450px; object-fit: cover;">
            @else
                <div class="w-100 rounded-4 shadow-sm mb-4 bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fa-solid fa-image fa-4x text-muted opacity-50"></i>
                </div>
            @endif
            
            <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom text-muted">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <small class="d-block lh-1">Penulis</small>
                        <strong class="text-dark">{{ $edukasi->penulis->nama_lengkap ?? '-' }}</strong>
                    </div>
                </div>
                <div class="ms-4 d-flex align-items-center gap-2">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <small class="d-block lh-1">Tanggal Publish</small>
                        <strong class="text-dark">{{ optional($edukasi->tanggal_publish)->format('d M Y H.i') ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            @if ($edukasi->tipe_konten === 'artikel')
                <div class="article-content" style="line-height: 1.8; font-size: 1.05rem; color: #334155;">
                    {!! nl2br(e($edukasi->isi_artikel)) !!}
                </div>
            @else
                <div class="video-details p-4 bg-light rounded-4 border-start border-4 border-warning">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-play text-warning me-2"></i> Detail Video</h5>
                    <div class="mb-3">
                        <strong class="d-block text-muted mb-1">URL Video</strong>
                        <a href="{{ $edukasi->url_video }}" target="_blank" class="text-primary text-decoration-none fw-medium">
                            {{ $edukasi->url_video }} <i class="fa-solid fa-external-link-alt ms-1 small"></i>
                        </a>
                    </div>
                    <div>
                        <strong class="d-block text-muted mb-1">Durasi</strong>
                        <span class="badge bg-dark px-3 py-2"><i class="fa-solid fa-stopwatch me-1"></i> {{ $edukasi->durasi_video ?? 'Tidak diketahui' }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 p-4">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fa-solid fa-info-circle text-primary me-2"></i> Informasi Tambahan</h5>
            
            <ul class="list-unstyled mb-0">
                <li class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Kategori</span>
                    <strong class="text-dark">{{ $edukasi->kategori->nama_kategori ?? '-' }}</strong>
                </li>
                <li class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Dibuat Pada</span>
                    <strong class="text-dark">{{ $edukasi->created_at->format('d M Y') }}</strong>
                </li>
                <li class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Terakhir Diupdate</span>
                    <strong class="text-dark">{{ $edukasi->updated_at->format('d M Y') }}</strong>
                </li>
                <li class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                    <span class="text-muted">ID Konten</span>
                    <code class="bg-light px-2 py-1 rounded text-dark">#{{ $edukasi->id_konten }}</code>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
