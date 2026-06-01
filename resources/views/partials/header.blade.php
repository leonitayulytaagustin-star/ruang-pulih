<style>
    .glass-header {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        height: var(--header-height);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        border-radius: var(--radius-xl);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        z-index: 100;
        position: sticky;
        top: 20px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .mobile-menu-btn {
        display: none;
        width: 44px;
        height: 44px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        color: var(--text-main);
        font-size: 18px;
        cursor: pointer;
        transition: var(--transition);
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .mobile-menu-btn:hover {
        background: var(--light-green);
        color: var(--primary-green);
        border-color: var(--primary-green);
    }

    .header-page-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-action-btn {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: var(--text-muted);
        background: rgba(255, 255, 255, 0.5);
        transition: var(--transition);
        position: relative;
    }
    .header-action-btn:hover {
        background: #fff;
        color: var(--primary-green);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .btn-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border: 2px solid #fff;
        border-radius: 50%;
    }

    .header-logout-btn {
        background: #fff;
        color: #ef4444;
        border: 1.5px solid #fee2e2;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }
    .header-logout-btn:hover {
        background: #fef2f2;
        border-color: #fca5a5;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.08);
    }

    @media (max-width: 1024px) {
        .mobile-menu-btn { display: flex; }
        .header-page-title { display: none; }
        .glass-header { padding: 0 15px; }
    }
</style>

<header class="glass-header">
    <div class="header-left">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <h1 class="header-page-title">{{ $title ?? 'Dashboard' }}</h1>
    </div>

    <div class="header-right">
        {{-- Logout --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="button" class="header-logout-btn" onclick="confirmLogout()">
                <i class="fa-solid fa-power-off"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</header>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Anda akan mengakhiri sesi saat ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#005c34',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>