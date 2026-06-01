@extends('layouts.dashboard', ['title' => 'Detail Pemantauan Pasien'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-user-circle me-2"></i> {{ $pasien->user->nama_lengkap }}</h1>
        <div class="d-flex align-items-center gap-2 mt-2">
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill">Skor Terakhir: <strong>{{ $ringkasan->skor_terakhir ?? 0 }}</strong></span>
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill text-capitalize">{{ $ringkasan->kondisi_terakhir ?? 'Belum ada ringkasan' }}</span>
        </div>
    </div>
    <a href="{{ route('psikolog.pemantauan.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 h-100">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-chart-line text-primary me-2"></i> Grafik Perkembangan</h5>
            @if ($pemantauan->isNotEmpty())
                @php
                    $chartItems = $pemantauan->values();
                    $chartWidth = 920;
                    $chartHeight = 320;
                    $paddingLeft = 44;
                    $paddingRight = 24;
                    $paddingTop = 24;
                    $paddingBottom = 70;
                    $plotWidth = $chartWidth - $paddingLeft - $paddingRight;
                    $plotHeight = $chartHeight - $paddingTop - $paddingBottom;
                    $maxScore = max(10, (int) ceil($chartItems->max('total_skor') / 5) * 5);
                    $points = $chartItems->map(function ($item, $index) use ($chartItems, $chartWidth, $paddingLeft, $paddingTop, $plotWidth, $plotHeight, $maxScore) {
                        $x = $chartItems->count() > 1
                            ? $paddingLeft + (($plotWidth / ($chartItems->count() - 1)) * $index)
                            : $chartWidth / 2;
                        $y = $paddingTop + (($maxScore - $item->total_skor) / $maxScore * $plotHeight);

                        return [
                            'x' => round($x, 2),
                            'y' => round($y, 2),
                            'score' => $item->total_skor,
                            'date' => $item->tanggal_pemantauan->format('d M'),
                        ];
                    });
                    $polyline = $points->map(fn ($point) => "{$point['x']},{$point['y']}")->implode(' ');
                    $areaLine = "{$paddingLeft}," . ($paddingTop + $plotHeight) . " {$polyline} " . ($chartWidth - $paddingRight) . "," . ($paddingTop + $plotHeight);
                    $gridLines = collect(range(0, 4))->map(function ($step) use ($paddingTop, $plotHeight, $maxScore) {
                        $ratio = $step / 4;

                        return [
                            'y' => round($paddingTop + ($plotHeight * $ratio), 2),
                            'label' => round($maxScore - ($maxScore * $ratio)),
                        ];
                    });
                @endphp

                <div class="line-chart mt-4">
                    <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" role="img" aria-label="Grafik perkembangan skor pemantauan pasien">
                        <defs>
                            <linearGradient id="monitoringLineFill" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="var(--primary-green)" stop-opacity="0.22" />
                                <stop offset="100%" stop-color="var(--primary-green)" stop-opacity="0" />
                            </linearGradient>
                        </defs>

                        @foreach ($gridLines as $gridLine)
                            <line class="line-chart-grid" x1="{{ $paddingLeft }}" y1="{{ $gridLine['y'] }}" x2="{{ $chartWidth - $paddingRight }}" y2="{{ $gridLine['y'] }}" />
                            <text class="line-chart-axis" x="{{ $paddingLeft - 12 }}" y="{{ $gridLine['y'] + 4 }}" text-anchor="end">{{ $gridLine['label'] }}</text>
                        @endforeach

                        <polyline class="line-chart-area" points="{{ $areaLine }}" />
                        <polyline class="line-chart-stroke" points="{{ $polyline }}" />

                        @foreach ($points as $point)
                            <g class="line-chart-point">
                                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="6">
                                    <title>{{ $point['date'] }} - Skor: {{ $point['score'] }}</title>
                                </circle>
                                <text class="line-chart-score" x="{{ $point['x'] }}" y="{{ $point['y'] - 14 }}" text-anchor="middle">{{ $point['score'] }}</text>
                                <text class="line-chart-date" x="{{ $point['x'] }}" y="{{ $chartHeight - 28 }}" text-anchor="middle" transform="rotate(-35 {{ $point['x'] }} {{ $chartHeight - 28 }})">{{ $point['date'] }}</text>
                            </g>
                        @endforeach
                    </svg>
                </div>
            @else
                <div class="line-chart-empty d-flex align-items-center justify-content-center flex-column text-muted mt-4">
                    <i class="fa-solid fa-chart-line fs-1 opacity-25 mb-3"></i>
                    <p class="mb-0 fst-italic">Belum ada pemantauan.</p>
                </div>
            @endif
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 h-100">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-clipboard-list text-primary me-2"></i> Riwayat Skrining</h5>
            <div class="d-flex flex-column gap-3">
                @forelse ($skrining as $item)
                    <div class="p-3 bg-light rounded-4 border">
                        <strong class="d-block text-dark mb-1">{{ $item->jenisSkrining->nama_skrining }}</strong>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $item->tanggal_skrining->format('d M Y') }}</small>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Skor: {{ $item->total_skor }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-file-excel fs-3 opacity-25 mb-2 d-block"></i>
                        <small class="fst-italic">Belum ada skrining.</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .line-chart,
    .line-chart-empty {
        min-height: 300px;
    }

    .line-chart svg {
        display: block;
        width: 100%;
        height: 320px;
        overflow: visible;
    }

    .line-chart-grid {
        stroke: #e9ecef;
        stroke-width: 1;
    }

    .line-chart-axis,
    .line-chart-date {
        fill: #6c757d;
        font-size: 22px;
    }

    .line-chart-score {
        fill: var(--primary-green);
        font-size: 22px;
        font-weight: 700;
    }

    .line-chart-area {
        fill: url(#monitoringLineFill);
        stroke: none;
    }

    .line-chart-stroke {
        fill: none;
        stroke: var(--primary-green);
        stroke-width: 5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .line-chart-point circle {
        fill: #fff;
        stroke: var(--primary-green);
        stroke-width: 5;
        transition: transform 0.2s ease, fill 0.2s ease;
        transform-box: fill-box;
        transform-origin: center;
    }

    .line-chart-point:hover circle {
        fill: var(--primary-green);
        transform: scale(1.2);
    }
</style>
@endsection
