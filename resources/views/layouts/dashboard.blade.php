<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Ruang Pulih' }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-green: #005c34;
            --secondary-green: #00874e;
            --sidebar-bg: var(--primary-green);
            --sidebar-width: 280px;
            --header-height: 80px;
            --bg-color: #f8fafb;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --radius-xl: 24px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
            /* Bootstrap 5 Primary Overrides */
            --bs-primary: #005c34;
            --bs-primary-rgb: 0, 92, 52;
            --bs-primary-bg-subtle: rgba(0, 92, 52, 0.1);
            --bs-primary-border-subtle: rgba(0, 92, 52, 0.25);
            --bs-primary-text-emphasis: #004a29;
            --bs-link-color: #005c34;
            --bs-link-hover-color: #004a29;
        }

        /* Comprehensive Bootstrap Primary Overrides */
        .text-primary { color: var(--primary-green) !important; }
        .bg-primary { 
            background-color: var(--primary-green) !important; 
            color: #fff !important;
        }
        .btn-primary { 
            background-color: var(--primary-green) !important; 
            border-color: var(--primary-green) !important;
            color: #fff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--secondary-green) !important;
            border-color: var(--secondary-green) !important;
            color: #fff !important;
        }
        .btn-outline-primary {
            color: var(--primary-green) !important;
            border-color: var(--primary-green) !important;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
            background-color: var(--primary-green) !important;
            border-color: var(--primary-green) !important;
            color: #fff !important;
        }
        .border-primary { border-color: var(--primary-green) !important; }
        .badge.bg-primary { background-color: var(--primary-green) !important; }
        .link-primary { color: var(--primary-green) !important; }
        .link-primary:hover { color: var(--secondary-green) !important; }
        .list-group-item-primary { background-color: var(--bs-primary-bg-subtle) !important; color: var(--bs-primary-text-emphasis) !important; }
        .alert-primary { background-color: var(--bs-primary-bg-subtle) !important; border-color: var(--bs-primary-border-subtle) !important; color: var(--bs-primary-text-emphasis) !important; }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            background: var(--bg-color); 
            color: var(--text-main); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        a { color: inherit; text-decoration: none; transition: var(--transition); }
        button, input, select, textarea { font: inherit; outline: none; }

        /* Layout Structure */
        .dashboard-shell { 
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        /* Sidebar Container (Desktop) */
        .sidebar-container {
            width: var(--sidebar-width);
            flex-shrink: 0;
            transition: var(--transition);
            position: sticky;
            top: 20px;
            height: calc(100vh - 40px);
            z-index: 50;
        }

        /* Main Wrapper */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            gap: 20px;
            position: relative;
        }

        .content-area { 
            padding: 0;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            flex: 1;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 1024px) {
            .dashboard-shell { padding: 15px; }
            .sidebar-container {
                position: fixed;
                left: -320px;
                top: 0;
                bottom: 0;
                margin: 0;
                z-index: 1100;
                width: 300px;
            }
            .sidebar-container.open {
                left: 0;
            }
            .main-wrapper { 
                margin-left: 0;
            }
            .glass-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                margin: 0;
                border-radius: 0;
                background: rgba(255, 255, 255, 0.9);
                width: 100%;
            }
        }

        /* Responsive UI Improvements */
        @media (max-width: 576px) {
            .hero-panel { padding: 30px 20px; }
            .hero-panel h1 { font-size: 26px; }
            .hero-panel p { font-size: 14px; }
            .card { padding: 20px 15px; }
            .btn { width: 100%; padding: 14px 20px; }
        }

        /* --- MODERN UI COMPONENTS --- */

        /* Hero Panel Premium */
        .hero-panel { 
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); 
            border-radius: var(--radius-xl); 
            box-shadow: 0 20px 40px rgba(0, 92, 52, 0.15); 
            color: #fff; 
            margin-bottom: 20px; 
            padding: 40px; 
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .hero-panel h1 { font-size: 32px; font-weight: 800; margin-bottom: 10px; letter-spacing: -1px; }
        .hero-panel p { font-size: 16px; opacity: 0.9; font-weight: 500; }
        .hero-panel::before {
            content: '';
            position: absolute;
            top: -20%; right: -10%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Cards Modern */
        .card { 
            background: #fff; 
            border: 1px solid rgba(241, 245, 249, 1); 
            border-radius: var(--radius-xl); 
            box-shadow: var(--card-shadow); 
            padding: 24px; 
            transition: var(--transition);
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); }

        .grid { display: grid; gap: 20px; }
        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        /* Buttons Premium */
        .btn { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            gap: 10px; 
            padding: 12px 24px; 
            border-radius: var(--radius-lg); 
            font-weight: 700; 
            font-size: 14px; 
            cursor: pointer; 
            transition: var(--transition);
            border: none;
        }
        .btn-primary { 
            background: var(--primary-green); 
            color: #fff; 
            box-shadow: 0 8px 16px rgba(0, 92, 52, 0.15); 
        }
        .btn-primary:hover { 
            background: var(--secondary-green); 
            transform: translateY(-2px); 
            box-shadow: 0 12px 24px rgba(0, 92, 52, 0.2); 
        }
        .btn-secondary { background: #f1f5f9; color: var(--text-main); }
        .btn-secondary:hover { background: #e2e8f0; }

        /* Tables & Inputs */
        .table-container { border-radius: var(--radius-lg); overflow: hidden; background: #fff; border: 1px solid #f1f5f9; }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: var(--radius-lg);
            transition: var(--transition);
        }
        .form-control:focus { background: #fff; border-color: var(--primary-green); }

        /* Alerts */
        .alert { 
            padding: 16px 24px; 
            border-radius: var(--radius-lg); 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 12px;
            font-weight: 600;
            animation: fadeInDown 0.4s ease-out;
        }
        @keyframes fadeInDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .hero-panel { padding: 30px; }
        }
    </style>
</head>
<body>
@php
    $user = auth()->user();
    $role = $user?->role ?? 'pasien';
    $menus = [
        'admin' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'section' => 'Menu Utama', 'icon' => 'fa-chart-pie'],
            ['label' => 'Edukasi', 'route' => 'admin.edukasi.index', 'match' => 'admin.edukasi.*', 'section' => 'Management Konten', 'icon' => 'fa-newspaper'],
            ['label' => 'Pasien', 'route' => 'admin.pasien.index', 'match' => 'admin.pasien.*', 'section' => 'Management User', 'icon' => 'fa-users'],
            ['label' => 'Psikolog', 'route' => 'admin.psikolog.index', 'match' => 'admin.psikolog.*', 'section' => null, 'icon' => 'fa-user-doctor'],
            ['label' => 'Admin', 'route' => 'admin.admin.index', 'match' => 'admin.admin.*', 'section' => null, 'icon' => 'fa-user-shield'],
            ['label' => 'Skrining', 'route' => 'admin.skrining.index', 'match' => 'admin.skrining.*', 'section' => 'Layanan', 'icon' => 'fa-clipboard-question'],
            ['label' => 'Laporan', 'route' => 'admin.laporan.index', 'match' => 'admin.laporan.*', 'section' => 'Support', 'icon' => 'fa-bug'],
            ['label' => 'Kritik & Saran', 'route' => 'admin.saran.index', 'match' => 'admin.saran.*', 'section' => null, 'icon' => 'fa-message'],
            ['label' => 'Profil Saya', 'route' => 'admin.profile.edit', 'match' => 'admin.profile.*', 'section' => 'Pengaturan', 'icon' => 'fa-user-gear'],
        ],
        'psikolog' => [
            ['label' => 'Dashboard', 'route' => 'psikolog.dashboard', 'match' => 'psikolog.dashboard', 'section' => 'Menu Utama', 'icon' => 'fa-chart-pie'],
            ['label' => 'Konsultasi Online', 'route' => 'psikolog.konsultasi.index', 'match' => 'psikolog.konsultasi.*', 'section' => 'Layanan', 'icon' => 'fa-comments'],
            ['label' => 'Pemantauan Mental', 'route' => 'psikolog.pemantauan.index', 'match' => 'psikolog.pemantauan.*', 'section' => null, 'icon' => 'fa-chart-line'],
            ['label' => 'Profil Saya', 'route' => 'psikolog.profile.edit', 'match' => 'psikolog.profile.*', 'section' => 'Pengaturan', 'icon' => 'fa-user-gear'],
        ],
        'pasien' => [
            ['label' => 'Dashboard', 'route' => 'pasien.dashboard', 'match' => 'pasien.dashboard', 'section' => 'Menu Utama', 'icon' => 'fa-chart-pie'],
            ['label' => 'Skrining Kesehatan', 'route' => 'pasien.skrining.index', 'match' => 'pasien.skrining.*', 'section' => 'Layanan', 'icon' => 'fa-clipboard-list'],
            ['label' => 'Konsultasi Online', 'route' => 'pasien.konsultasi.index', 'match' => 'pasien.konsultasi.*', 'section' => null, 'icon' => 'fa-comment-dots'],
            ['label' => 'Pemantauan Mental', 'route' => 'pasien.pemantauan.index', 'match' => 'pasien.pemantauan.*', 'section' => null, 'icon' => 'fa-chart-simple'],
            ['label' => 'Profil Saya', 'route' => 'pasien.profile.edit', 'match' => 'pasien.profile.*', 'section' => 'Pengaturan', 'icon' => 'fa-user-gear'],
        ],
    ];
@endphp

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="dashboard-shell">
    <div class="sidebar-container" id="sidebarContainer">
        @include('partials.sidebar')
    </div>

    <div class="main-wrapper">
        @include('partials.header')

        <main class="content-area">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check fa-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebarContainer = document.getElementById('sidebarContainer');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
        sidebarContainer.classList.toggle('open');
        sidebarOverlay.classList.toggle('active');
    }

    sidebarOverlay.addEventListener('click', toggleSidebar);

    function confirmDelete(event, message) {
        event.preventDefault();
        const element = event.currentTarget;
        
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                if (element.tagName === 'FORM') {
                    element.submit();
                } else if (element.tagName === 'A') {
                    window.location.href = element.href;
                } else if (element.tagName === 'BUTTON' && element.form) {
                    element.form.submit();
                }
            }
        });
    }
</script>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
