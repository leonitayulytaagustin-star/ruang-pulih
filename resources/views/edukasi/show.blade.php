@extends('layouts.public', ['title' => $konten->judul_konten.' - Ruang Pulih'])

@section('content')
<div class="content-page">
    <article class="card card-body">
        <div class="muted">Beranda &gt; Edukasi &gt; {{ $konten->judul_konten }}</div>
        <img class="content-cover" src="{{ $konten->thumbnail_url ?? asset('assets/images/artikel13.png') }}" alt="{{ $konten->judul_konten }}">
        <h1 style="font-size:42px; line-height:1.15; margin-bottom:12px;">{{ $konten->judul_konten }}</h1>
        <p class="muted" style="margin-bottom:24px;">
            {{ $konten->kategori->nama_kategori ?? 'Edukasi' }} -
            {{ optional($konten->tanggal_publish ?? $konten->created_at)->translatedFormat('j M Y') }} -
            {{ $konten->penulis->nama_lengkap ?? 'Ruang Pulih' }}
        </p>
        <div class="content-body">{!! nl2br(e($konten->isi_artikel)) !!}</div>
    </article>

    <aside class="card card-body">
        <h2 style="margin-bottom:14px;">Artikel Terkait</h2>
        @forelse ($terkait as $item)
            <a href="{{ route('edukasi.show', $item->slug) }}" style="display:block; padding:12px 0; border-bottom:1px solid #e5e5e5;">
                <strong>{{ $item->judul_konten }}</strong>
                <div class="muted">{{ $item->kategori->nama_kategori ?? 'Edukasi' }}</div>
            </a>
        @empty
            <p class="muted">Belum ada artikel terkait.</p>
        @endforelse
    </aside>
</div>
@endsection
