@extends('layouts.dashboard', ['title' => 'Dashboard Admin'])

@section('content')
<div class="admin-dashboard-wrapper">
    <!-- Premium Header Section -->
    <header class="dashboard-banner mb-5">
        <div class="banner-content">
            <span class="welcome-tag">Sistem Manajemen</span>
            <h1>Halo, Administrator!</h1>
            <p>Ruang Pulih sedang berjalan optimal hari ini. Berikut adalah ringkasan performa platform Anda.</p>
            <div class="banner-actions mt-4">
                <a href="{{ route('admin.edukasi.index') }}#tambah-artikel" class="btn-glass">
                    <i class="fa-solid fa-plus"></i>
                    <span>Konten Baru</span>
                </a>
                <a href="{{ route('admin.skrining.index') }}" class="btn-glass">
                    <i class="fa-solid fa-gear"></i>
                    <span>Konfigurasi Skrining</span>
                </a>
            </div>
        </div>
        <div class="banner-visual">
            <div class="glass-widget">
                <span class="widget-label">Total Pengguna</span>
                <span class="widget-value">{{ $stats['pasien'] + $stats['psikolog'] }}</span>
                <div class="widget-trend">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>+12.5% Bulan ini</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="grid grid-4 mb-5" style="gap: 30px;">
        @php
            $stat_items = [
                ['label' => 'Artikel Edukasi', 'value' => $stats['artikel'], 'icon' => 'fa-newspaper', 'color' => 'primary-green', 'trend' => '+5'],
                ['label' => 'Video Edukasi', 'value' => $stats['video'], 'icon' => 'fa-circle-play', 'color' => 'purple', 'trend' => '+2'],
                ['label' => 'Total Pasien', 'value' => $stats['pasien'], 'icon' => 'fa-users', 'color' => 'emerald', 'trend' => '+18'],
                ['label' => 'Sesi Konsultasi', 'value' => $stats['konsultasi'], 'icon' => 'fa-comments', 'color' => 'amber', 'trend' => '+12'],
            ];
        @endphp

        @foreach($stat_items as $item)
            <div class="premium-stat-card {{ $item['color'] }}">
                <div class="card-icon">
                    <i class="fa-solid {{ $item['icon'] }}"></i>
                </div>
                <div class="card-data">
                    <span class="data-label">{{ $item['label'] }}</span>
                    <span class="data-value">{{ $item['value'] }}</span>
                </div>
                <div class="card-chart-mini">
                    <span class="trend-tag">{{ $item['trend'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Section -->
    <div class="dashboard-main-grid">
        <div class="content-left">
            <!-- Latest Articles -->
            <div class="card premium-card mb-4">
                <div class="card-header-flex">
                    <div class="header-info">
                        <h2>Artikel Terbaru</h2>
                        <p>5 Konten edukasi teks yang baru dipublish.</p>
                    </div>
                    <a href="{{ route('admin.edukasi.index') }}" class="btn-link">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="premium-table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Judul Konten</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($artikels as $item)
                                <tr>
                                    <td>
                                        <div class="content-cell">
                                            <div class="content-img">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </div>
                                            <span class="content-title">{{ $item->judul_konten }}</span>
                                        </div>
                                    </td>
                                    <td><span class="tag-simple">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td><span class="text-date">{{ $item->created_at->format('d M Y') }}</span></td>
                                    <td>
                                        <span class="status-pill {{ $item->status === 'publish' ? 'published' : 'draft' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.edukasi.show', $item) }}" class="btn-icon-action">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-5">Belum ada data artikel.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Latest Videos -->
            <div class="card premium-card">
                <div class="card-header-flex">
                    <div class="header-info">
                        <h2>Video Edukasi Terbaru</h2>
                        <p>5 Konten edukasi video yang baru ditambahkan.</p>
                    </div>
                    <a href="{{ route('admin.edukasi.index') }}" class="btn-link">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="premium-table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Judul Video</th>
                                <th>Durasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($videos as $item)
                                <tr>
                                    <td>
                                        <div class="content-cell">
                                            <div class="content-img video">
                                                <i class="fa-solid fa-play"></i>
                                            </div>
                                            <span class="content-title">{{ $item->judul_konten }}</span>
                                        </div>
                                    </td>
                                    <td><span class="text-duration">{{ $item->durasi_video ?? '-' }}</span></td>
                                    <td><span class="text-date">{{ $item->created_at->format('d M Y') }}</span></td>
                                    <td>
                                        <span class="status-pill {{ $item->status === 'publish' ? 'published' : 'draft' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.edukasi.show', $item) }}" class="btn-icon-action">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-5">Belum ada data video.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="content-right">
            <!-- Quick Actions Grid -->
            <div class="card premium-card mb-4">
                <h3 class="side-card-title">Aksi Cepat</h3>
                <div class="action-grid-premium">
                    <a href="{{ route('admin.edukasi.index') }}" class="quick-btn">
                        <i class="fa-solid fa-pen-nib"></i>
                        <span>Kelola Edukasi</span>
                    </a>
                    <a href="{{ route('admin.pasien.index') }}" class="quick-btn">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Data Pasien</span>
                    </a>
                    <a href="{{ route('admin.psikolog.index') }}" class="quick-btn">
                        <i class="fa-solid fa-stethoscope"></i>
                        <span>Psikolog</span>
                    </a>
                    <a href="{{ route('admin.admin.index') }}" class="quick-btn">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Tim Admin</span>
                    </a>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="card premium-card">
                <h3 class="side-card-title">Aktivitas Terbaru</h3>
                <div class="modern-timeline">
                    <div class="timeline-entry">
                        <div class="entry-marker primary-green"></div>
                        <div class="entry-content">
                            <h6>Konten Baru</h6>
                            <p>Administrator mempublish artikel baru.</p>
                            <span class="entry-time">10 Menit lalu</span>
                        </div>
                    </div>
                    <div class="timeline-entry">
                        <div class="entry-marker green"></div>
                        <div class="entry-content">
                            <h6>Pasien Baru</h6>
                            <p>5 Pengguna baru telah mendaftar.</p>
                            <span class="entry-time">2 Jam lalu</span>
                        </div>
                    </div>
                    <div class="timeline-entry">
                        <div class="entry-marker amber"></div>
                        <div class="entry-content">
                            <h6>Sesi Konsultasi</h6>
                            <p>Dr. Sarah menyelesaikan sesi chat.</p>
                            <span class="entry-time">5 Jam lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- Admin Dashboard Specific Styles --- */
    .admin-dashboard-wrapper {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Dashboard Banner */
    .dashboard-banner {
        background: linear-gradient(135deg, var(--primary-green), #064e3b);
        border-radius: 32px;
        padding: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 20px 40px rgba(0, 92, 52, 0.15);
    }
.dashboard-banner::after {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 30vw; height: 30vw;
        max-width: 500px; max-height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
}

    .banner-content { flex: 1; position: relative; z-index: 2; }
    .welcome-tag {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        backdrop-filter: blur(5px);
    }
    .banner-content h1 { font-size: 38px; font-weight: 800; margin-bottom: 10px; letter-spacing: -1px; }
    .banner-content p { font-size: 16px; opacity: 0.85; max-width: 500px; line-height: 1.6; }

    .btn-glass {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 12px 24px;
        border-radius: 14px;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        backdrop-filter: blur(10px);
        transition: var(--transition);
        margin-right: 10px;
    }
    .btn-glass:hover {
        background: #fff;
        color: var(--primary-green);
        transform: translateY(-2px);
    }

    /* Glass Widget */
    .banner-visual { position: relative; z-index: 2; }
    .glass-widget {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 25px;
        border-radius: 24px;
        min-width: 220px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .widget-label { font-size: 12px; font-weight: 700; opacity: 0.7; text-transform: uppercase; margin-bottom: 5px; }
    .widget-value { font-size: 36px; font-weight: 800; margin-bottom: 10px; }
    .widget-trend {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        padding: 4px 10px;
        border-radius: 8px;
        width: fit-content;
    }

    /* Premium Stat Cards */
    .premium-stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .premium-stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }

    .card-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    /* Color Variations */
    .primary-green .card-icon { background: #f0fdf4; color: var(--primary-green); }
    .purple .card-icon { background: #f5f3ff; color: #8b5cf6; }
    .emerald .card-icon { background: #f0fdf4; color: #10b981; }
    .amber .card-icon { background: #fffbeb; color: #f59e0b; }

    .card-data { display: flex; flex-direction: column; flex: 1; }
    .data-label { font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 2px; }
    .data-value { font-size: 24px; font-weight: 800; color: var(--text-main); }

    .trend-tag {
        font-size: 11px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 80px;
        background: #f1f5f9;
        color: var(--text-main);
    }

    /* Layout Grid */
    .dashboard-main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .premium-card {
        padding: 30px;
        border-radius: 24px;
    }
    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .header-info h2 { font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; }
    .header-info p { font-size: 14px; color: var(--text-muted); }

    .btn-link {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-green);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-link:hover { gap: 10px; }

    /* Modern Table */
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #f1f5f9;
    }
    .modern-table td { padding: 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

    .content-cell { display: flex; align-items: center; gap: 12px; }
.content-img {
        width: 2.25rem; height: 2.25rem;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8; font-size: 1rem;
}
    .content-img.video { background: #fff1f2; color: #f43f5e; }
    .content-title { font-weight: 700; font-size: 14px; color: var(--text-main); display: block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    @media (max-width: 768px) {
        .content-title { white-space: normal; line-height: 1.3; max-width: 100%; }
    }

    .tag-simple { font-size: 12px; font-weight: 600; color: var(--text-muted); background: #f8fafc; padding: 4px 10px; border-radius: 6px; }
    .text-date, .text-duration { font-size: 13px; color: var(--text-muted); }

    .status-pill {
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }
    .status-pill.published { background: #dcfce7; color: #166534; }
    .status-pill.draft { background: #f1f5f9; color: #475569; }

.btn-icon-action {
        width: 2rem; height: 2rem;
        border-radius: 8px;
        background: #f8fafc;
        display: inline-flex;
        align-items: center; justify-content: center;
        color: #94a3b8;
        transition: var(--transition);
}
    .btn-icon-action:hover { background: var(--primary-green); color: #fff; }

    /* Side Components */
    .side-card-title { font-size: 18px; font-weight: 800; margin-bottom: 20px; }

    .action-grid-premium {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .quick-btn {
        background: #f8fafc;
        padding: 20px 15px;
        border-radius: 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-align: center;
        border: 1px solid #f1f5f9;
        transition: var(--transition);
    }
    .quick-btn i { font-size: 20px; color: var(--primary-green); }
    .quick-btn span { font-size: 12px; font-weight: 700; color: var(--text-main); }
    .quick-btn:hover { background: #fff; border-color: var(--primary-green); transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.05); }

    /* Modern Timeline */
    .modern-timeline { display: flex; flex-direction: column; gap: 24px; position: relative; padding-left: 15px; }
    .modern-timeline::before {
        content: '';
        position: absolute;
        left: 4px; top: 5px; bottom: 5px;
        width: 2px;
        background: #f1f5f9;
    }
    .timeline-entry { position: relative; display: flex; gap: 15px; }
.entry-marker {
    width: 0.625rem; height: 0.625rem;
    border-radius: 50%;
    background: #cbd5e1;
    margin-top: 6px;
    position: relative; z-index: 2;
    box-shadow: 0 0 0 4px #fff;
}
.entry-marker.primary-green { background: var(--primary-green); }
.entry-marker.green { background: #10b981; }
.entry-marker.amber { background: #f59e0b; }
    .entry-content h6 { font-size: 14px; font-weight: 800; margin-bottom: 2px; }
    .entry-content p { font-size: 13px; color: var(--text-muted); line-height: 1.4; margin-bottom: 4px; }
    .entry-time { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

    @media (max-width: 1280px) {
        .dashboard-main-grid { grid-template-columns: 1fr; }
        .dashboard-banner { padding: 40px; }
    }
    @media (max-width: 992px) {
        .dashboard-banner { flex-direction: column; text-align: center; gap: 30px; padding: 30px 20px; border-radius: 24px; }
        .banner-content p { margin: 0 auto 20px; font-size: 14px; }
        .banner-actions { justify-content: center; display: flex; flex-direction: column; gap: 10px; width: 100%; }
        .btn-glass { margin-right: 0; width: 100%; justify-content: center; }
        .banner-visual { width: 100%; }
        .glass-widget { min-width: unset; width: 100%; padding: 20px; }
        .grid-4 { grid-template-columns: repeat(2, 1fr) !important; gap: 15px !important; }
        .premium-stat-card { padding: 20px; gap: 12px; }
    }
    @media (max-width: 768px) {
        .modern-table thead th:nth-child(2),
        .modern-table thead th:nth-child(3),
        .modern-table tbody td:nth-child(2),
        .modern-table tbody td:nth-child(3) {
            display: none;
        }
        .content-title { max-width: 180px; }
    }
    @media (max-width: 576px) {
        .grid-4 { grid-template-columns: 1fr !important; }
        .banner-content h1 { font-size: 28px; }
        .premium-table-wrapper { overflow-x: visible; }
        .modern-table { min-width: 100%; }
        .modern-table td { padding: 12px 8px; }
        .premium-card { padding: 20px 15px; }
        .card-header-flex { flex-direction: column; gap: 10px; align-items: flex-start; }
        .action-grid-premium { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .quick-btn { padding: 15px 10px; border-radius: 14px; }
        .quick-btn i { font-size: 18px; }
        .quick-btn span { font-size: 11px; }
        .premium-stat-card { flex-direction: row; text-align: left; }
        
        .content-title { max-width: 140px; font-size: 13px; }
        .status-pill { padding: 2px 8px; font-size: 10px; }
        
        .header-info h2 { font-size: 18px; }
        .header-info p { font-size: 12px; }
        
        .modern-timeline { gap: 18px; }
        .entry-content h6 { font-size: 13px; }
        .entry-content p { font-size: 12px; }
    }
    @media (max-width: 400px) {
        .action-grid-premium { grid-template-columns: 1fr; }
        .dashboard-banner { padding: 25px 15px; }
        .banner-content h1 { font-size: 24px; }
        .card-icon { width: 44px; height: 44px; font-size: 18px; }
        .data-value { font-size: 20px; }
        .content-title { max-width: 120px; }
    }
</style>
@endsection

