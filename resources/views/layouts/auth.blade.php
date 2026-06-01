<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - Ruang Pulih</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

        * { margin:0; padding:0; box-sizing:border-box; }
        html,body { width:100%; height:100%; font-family:'Inter',sans-serif; background:#fff; color:#1a202c; }
        .auth-container { width: 100vw; height: 100vh; display: grid; grid-template-columns: 45% 55%; overflow: hidden; }

        /* Left Panel */
        .left-panel {
            position: relative; height: 100vh; padding: 48px 64px;
            background: url("{{ asset('assets/images/login.png') }}") no-repeat center center;
            background-size: cover;
            display: flex; flex-direction: column;
        }
        .left-panel::before {
            content: "";
            position: absolute; inset: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        .left-panel > * { position: relative; z-index: 2; }

        .brand { display:flex; align-items:center; gap:20px; }
        .brand img { width:80px; height:80px; border-radius:50%; background:#fff; padding:8px; object-fit:contain; }
        .brand h1 { color:#fff; font-size:28px; font-weight:800; }
        .brand p { color:#e2e8f0; font-size:15px; margin-top:4px; }

        .left-content { margin-top: 140px; }
        .left-content h2 { color: #fff; font-size: 40px; font-weight: 800; line-height: 1.2; margin-bottom: 24px; }
        .quote-box {
            position: absolute; left: 64px; bottom: 48px; width: 450px; background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px); border-radius: 20px; padding: 24px; color: #fff; font-weight: 500;
        }

        /* Right Panel */
        .right-panel {
            height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 40px; background: #fff; overflow-y: auto;
        }
        .auth-card { width: 100%; max-width: 500px; }
        .auth-title { font-size: 32px; font-weight: 800; margin-bottom: 12px; }
        .auth-subtitle { color: #718096; margin-bottom: 32px; font-weight: 500; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
        .input-box {
            height: 52px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center;
            padding: 0 16px; transition: all 0.3s;
        }
        .input-box:focus-within { border-color: #005c34; box-shadow: 0 0 0 3px rgba(0,92,52,0.1); }
        .input-box i { color: #a0aec0; margin-right: 12px; }
        .input-box input { flex:1; border:none; outline:none; font-size: 15px; background: transparent; }
        .eye-icon { cursor:pointer; color: #a0aec0; }

        .btn-submit {
            width:100%; height:52px; background:#005c34; color:#fff; border:none; border-radius:12px;
            font-size:16px; font-weight:700; cursor:pointer; transition: all 0.3s; margin-top: 12px;
        }
        .btn-submit:hover { background:#004a29; }

        .divider { display:flex; align-items:center; gap:16px; margin: 24px 0; color: #a0aec0; font-size: 14px; }
        .divider::before, .divider::after { content:""; flex:1; height:1px; background:#e2e8f0; }

        .google-btn {
            width:100%; height:52px; border:1px solid #e2e8f0; border-radius:12px; background:#fff;
            display:flex; justify-content:center; align-items:center; gap:12px; font-weight:600; text-decoration:none; color:#2d3748;
        }

        .auth-footer { text-align:center; margin-top: 24px; font-size: 14px; color: #718096; }
        .auth-footer a { color: #005c34; font-weight: 700; text-decoration: none; }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .auth-container { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 30px 20px; }
            .auth-title { font-size: 28px; }
            .auth-card { max-width: 100%; }
        }

        @media (max-width: 576px) {
            .auth-title { font-size: 24px; }
            .auth-subtitle { font-size: 14px; margin-bottom: 24px; }
            .input-box { height: 48px; }
            .btn-submit { height: 48px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="left-panel">
            <div class="brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                <div>
                    <h1>Ruang Pulih</h1>
                    <p>Tempat aman untuk kesehatan mentalmu</p>
                </div>
            </div>
            <div class="left-content">
                <h2>Mari mulai perjalanan<br>pemulihan bersama.</h2>
            </div>
            <div class="quote-box">
                <i class="fa-solid fa-quote-left" style="font-size: 24px; margin-bottom: 12px;"></i>
                <p>Kesehatan mental adalah pondasi untuk menjalani hidup yang lebih bermakna.</p>
            </div>
        </div>
        <div class="right-panel">
            <div class="auth-card">
                @yield('form')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>