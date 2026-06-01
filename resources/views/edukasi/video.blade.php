@extends('layouts.public', ['title' => $konten->judul_konten.' - Ruang Pulih'])

@section('content')
@php
    $url = $konten->url_video;
    $embed = $url;
    if (str_contains($url, 'watch?v=')) {
        $embed = strtok(str_replace('watch?v=', 'embed/', $url), '&');
    } elseif (str_contains($url, 'youtu.be/')) {
        $videoId = strtok(substr($url, strpos($url, 'youtu.be/') + 9), '?');
        $embed = 'https://www.youtube.com/embed/'.$videoId;
    }
@endphp
<article class="card card-body" style="margin-top:24px;">
    <div class="muted">Beranda &gt; Edukasi &gt; Video &gt; {{ $konten->judul_konten }}</div>
    <div style="aspect-ratio:16/9; background:#111; border-radius:12px; margin:18px 0; overflow:hidden;">
        <iframe src="{{ $embed }}" title="{{ $konten->judul_konten }}" style="border:0; width:100%; height:100%;" allowfullscreen></iframe>
    </div>
    <h1 style="font-size:42px; margin-bottom:12px;">{{ $konten->judul_konten }}</h1>
    <p class="muted">{{ $konten->kategori->nama_kategori ?? 'Video Edukasi' }} - {{ $konten->durasi_video }} - {{ optional($konten->tanggal_publish ?? $konten->created_at)->translatedFormat('j M Y') }}</p>
</article>
@endsection
