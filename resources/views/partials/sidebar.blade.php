<style>
    .floating-sidebar {
        background: var(--sidebar-bg);
        height: calc(100vh - 40px);
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        padding: 20px;
        color: #fff;
        box-shadow: 10px 0 30px rgba(0, 92, 52, 0.1);
        position: relative;
        overflow: hidden;
        z-index: 1000;
    }

    /* Decorative Circle */
    .floating-sidebar::before {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .sidebar-brand {
        padding: 10px 15px 30px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .brand-logo-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    .brand-text {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .sidebar-profile {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
    }
    .profile-avatar-circle {
        width: 44px;
        height: 44px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 20px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .profile-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-meta {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .profile-name-text {
        font-weight: 700;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .profile-role-tag {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        opacity: 0.7;
        letter-spacing: 0.5px;
    }

    .sidebar-navigation {
        flex: 1;
        overflow-y: auto;
        padding-right: 5px;
    }
    .sidebar-navigation::-webkit-scrollbar { width: 4px; }
    .sidebar-navigation::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

    .nav-section-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 25px 0 12px 15px;
        opacity: 0.6;
        color: #b2f5ea;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 18px;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 4px;
        transition: var(--transition);
    }
    .sidebar-link i { font-size: 18px; width: 20px; text-align: center; }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background: #fff;
        color: var(--primary-green);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .sidebar-link.active i { color: var(--primary-green); }

    @media (max-width: 1024px) {
        .floating-sidebar {
            height: 100vh;
            border-radius: 0;
        }
    }
</style>

<div class="floating-sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Ruang Pulih" class="brand-logo-img">
        <span class="brand-text">Ruang Pulih</span>
    </div>

    <div class="sidebar-profile">
        <div class="profile-avatar-circle">
            @if($user?->foto_profil_url)
                <img src="{{ $user->foto_profil_url }}" alt="Foto profil {{ $user->nama_lengkap }}">
            @else
                <i class="fa-solid fa-user-circle"></i>
            @endif
        </div>
        <div class="profile-meta">
            <span class="profile-name-text">{{ $user?->nama_lengkap ?? 'Pengguna' }}</span>
            <span class="profile-role-tag">{{ ucfirst($role) }}</span>
        </div>
    </div>

    <nav class="sidebar-navigation">
        @php $printedSection = null; @endphp
        @foreach ($menus[$role] ?? $menus['pasien'] as $menu)
            @if ($menu['section'] && $printedSection !== $menu['section'])
                <div class="nav-section-label">{{ $menu['section'] }}</div>
                @php $printedSection = $menu['section']; @endphp
            @endif
            <a href="{{ route($menu['route']) }}" class="sidebar-link {{ request()->routeIs($menu['match']) ? 'active' : '' }}">
                <i class="fa-solid {{ $menu['icon'] }}"></i>
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
