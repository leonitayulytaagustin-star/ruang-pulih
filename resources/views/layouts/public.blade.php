<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ruang Pulih' }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-green: #005c34;
            --secondary-green: #00874e;
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
        body { background: #f8fbf8; color: #111; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        a { color: inherit; text-decoration: none; }
        
        .public-wrap { width: min(1820px, calc(100% - 48px)); margin: 0 auto; }
        
        /* Modern Navbar Styling */
        .public-nav { 
            height: 80px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin: 16px 0;
            padding: 0 32px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 92, 52, 0.08);
            position: sticky;
            top: 16px;
            z-index: 1000;
        }

        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { width: 48px; height: 48px; object-fit: contain; }
        .brand-title { font-size: 20px; font-weight: 800; color: #005c34; }

        .public-menu { display: flex; align-items: center; gap: 8px; }
        .public-menu a { 
            padding: 10px 20px; 
            border-radius: 12px; 
            font-size: 16px; 
            font-weight: 600; 
            color: #4a5568;
            transition: all 0.2s ease;
        }
        .public-menu a:hover { background: #f0fdf4; color: #005c34; }
        .public-menu a.active { background: #b8efd4; color: #005c34; }

        .nav-right { display: flex; align-items: center; gap: 12px; }
        .mobile-only { display: none; }
        .desktop-only { display: flex; }
        .login-link { 
            background: #005c34; 
            color: #fff; 
            padding: 10px 24px; 
            border-radius: 12px; 
            font-size: 16px; 
            font-weight: 700; 
            transition: all 0.2s;
        }
        .login-link:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 92, 52, 0.2); color: #fff; }
        .fa-inline { margin-right: 6px; }

        /* Hamburger Menu */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #005c34;
            cursor: pointer;
            padding: 8px;
        }

        @media (max-width: 1024px) {
            .public-nav { padding: 0 20px; height: 70px; }
            .menu-toggle { display: block; order: 2; }
            .desktop-only { display: none; }
            .mobile-only { display: block; }
            
            .public-menu {
                position: absolute;
                top: calc(100% + 12px);
                left: 0;
                right: 0;
                background: #fff;
                flex-direction: column;
                padding: 16px;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border: 1px solid #f0fdf4;
                gap: 8px;
                display: none;
                animation: slideDown 0.3s ease-out;
            }
            .public-menu.active { display: flex; }
            .public-menu a { width: 100%; text-align: center; }
            
            @keyframes slideDown {
                from { transform: translateY(-10px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
        }

        @media (max-width: 576px) {
            .brand-title { display: none; }
            .public-nav { padding: 0 16px; }
            .login-link { padding: 8px 16px; font-size: 14px; }
        }

        /* Existing Styles ... */
        .hero { border-radius: 14px; background: linear-gradient(90deg, #cfffe0 0%, #a9edc7 42%, #55cda3 100%); display: grid; grid-template-columns: 1fr 0.9fr; min-height: 320px; overflow: hidden; padding: 54px 64px 0; margin-bottom: 10px; }
        .hero h1 { color: #005c34; font-size: 42px; line-height: 1.15; margin-bottom: 24px; }
        .hero p { color: #111; font-size: 22px; line-height: 1.35; max-width: 720px; }
        .hero-label { color: #005c34; font-size: 17px; font-weight: 800; margin-bottom: 12px; }
        .hero .btn { margin-top: 34px; }
        .hero-img { align-self: end; justify-self: end; width: min(620px, 100%); max-height: 320px; object-fit: contain; }
        .btn { border: 0; border-radius: 10px; background: #005c34; color: #fff; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 18px; font-size: 19px; font-weight: 700; padding: 16px 28px; }
        .btn-outline { background: #fff; border: 1px solid #9a9a9a; color: #222; }
        .section-title { font-size: 32px; font-weight: 800; margin: 28px 0 18px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 42px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 22px; }
        .card { background: #fff; border: 1px solid #d7d7d7; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); overflow: hidden; }
        .card-body { padding: 18px; }
        .muted { color: #666; }
        .search-bar { align-items: center; background: #fff; border: 1px solid #999; border-radius: 12px; display: flex; height: 76px; margin: 10px 0 16px; padding: 0 36px; }
        .search-bar input { border: 0; flex: 1; font-size: 25px; outline: 0; padding-left: 20px; }
        .tabs { display: flex; gap: 38px; flex-wrap: wrap; margin: 16px 0 26px; }
        .tabs a { border: 1px solid #999; border-radius: 28px; min-width: 204px; padding: 12px 24px; text-align: center; font-size: 24px; }
        .tabs a.active { background: #005c34; border-color: #005c34; color: #fff; }
        .article-card img, .video-card img { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; }
        .article-card h3, .video-card h3 { font-size: 24px; line-height: 1.18; margin-bottom: 8px; }
        .article-meta { align-items: center; color: #666; display: flex; gap: 18px; font-size: 18px; margin-top: 16px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #666; display: inline-block; }
        .page-numbers { display: flex; justify-content: center; gap: 10px; margin: 34px 0 10px; }
        .page-numbers a, .page-numbers span { align-items: center; background: #fff; border: 1px solid #c8d7cf; border-radius: 10px; color: #005c34; display: inline-flex; font-size: 18px; font-weight: 800; height: 44px; justify-content: center; min-width: 44px; padding: 0 14px; }
        .page-numbers a:hover { background: #e8f8ef; border-color: #7dcaa4; }
        .page-numbers .active { background: #005c34; border-color: #005c34; color: #fff; box-shadow: 0 8px 18px rgba(0,92,52,.18); }
        .content-page { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 34px; margin-top: 24px; }
        .content-body { font-size: 19px; line-height: 1.7; }
        .content-body p { margin-bottom: 16px; }
        .content-cover { width: 100%; max-height: 460px; object-fit: contain; border-radius: 12px; margin: 16px 0 24px; background: #f0f0f0; }
        .footer-space { height: 40px; }
        @media (max-width: 1000px) {
            .public-wrap { width: calc(100% - 30px); }
            .public-nav { 
                padding: 12px 20px; 
                border-radius: 15px;
                top: 10px;
                height: auto;
            }
            .brand img { width: 36px; height: 36px; }
            .brand-title { font-size: 18px; }
            
            .public-menu { 
                order: 3; 
                width: 100%; 
                margin-top: 15px; 
                padding-top: 15px;
                border-top: 1px solid #f0fdf4;
                justify-content: center;
                gap: 5px;
            }
            .public-menu a { padding: 8px 10px; font-size: 13px; }
            
            .hero { grid-template-columns: 1fr; padding: 40px 30px 0; text-align: center; }
            .hero-img { justify-self: center; max-height: 240px; margin-top: 30px; }
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 18px; }
            
            .grid-2, .grid-3, .grid-4, .content-page { grid-template-columns: 1fr; gap: 24px; }
            .tabs a { min-width: auto; flex: 1; font-size: 15px; padding: 8px 15px; }
            .login-link { font-size: 14px; padding: 8px 16px; }
            
            .search-bar { height: 60px; padding: 0 20px; }
            .search-bar input { font-size: 18px; }
            .section-title { font-size: 26px; }
        }

        @media (max-width: 480px) {
            .public-menu { flex-wrap: wrap; }
            .public-menu a { flex: 1 1 40%; text-align: center; }
            .hero { padding: 30px 20px 0; }
            .hero h1 { font-size: 28px; }
            .hero p { font-size: 16px; }
            .btn { width: 100%; padding: 14px 20px; font-size: 17px; }
        }
    </style>
</head>
<body>
    <div class="public-wrap">
        <nav class="public-nav">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Ruang Pulih">
                <span class="brand-title">Ruang Pulih</span>
            </a>

            <button class="menu-toggle" id="menuToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="public-menu" id="publicMenu">
                <a class="{{ request()->routeIs('edukasi.*') ? 'active' : '' }}" href="{{ route('edukasi.index') }}"><i class="fa-solid fa-book-open fa-inline"></i>Edukasi</a>
                <a class="{{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ route('about.index') }}"><i class="fa-solid fa-circle-info fa-inline"></i>About</a>
                <a class="{{ request()->routeIs('bantuan.*') ? 'active' : '' }}" href="{{ route('bantuan.index') }}"><i class="fa-solid fa-headset fa-inline"></i>Bantuan</a>
                
                <!-- Mobile Only Login Link -->
                <div class="mobile-only mt-3 pt-3 border-top w-100 text-center">
                    @auth
                        <a class="login-link d-inline-block w-100 text-white" href="{{ route('dashboard') }}"><i class="fa-solid fa-table-columns fa-inline"></i> Dashboard</a>
                    @else
                        <a class="login-link d-inline-block w-100 text-white" href="{{ route('login') }}"><i class="fa-regular fa-circle-user fa-inline"></i> Login</a>
                    @endauth
                </div>
            </div>

            <div class="nav-right desktop-only">
                @auth
                    <a class="login-link text-white" href="{{ route('dashboard') }}"><i class="fa-solid fa-table-columns fa-inline"></i> Dashboard</a>
                @else
                    <a class="login-link" href="{{ route('login') }}"><i class="fa-regular fa-circle-user fa-inline"></i> Login</a>
                @endauth
            </div>
        </nav>

        @yield('content')
        <div class="footer-space"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            const menu = document.getElementById('publicMenu');
            const icon = this.querySelector('i');
            menu.classList.toggle('active');
            
            if (menu.classList.contains('active')) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('publicMenu');
            const toggle = document.getElementById('menuToggle');
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
                toggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
