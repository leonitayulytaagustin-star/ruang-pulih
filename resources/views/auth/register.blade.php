<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Ruang Pulih</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            background: #fff;
        }

        .register-page {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: 45% 55%;
        }

        .left-panel {
            position: relative;
            height: 100vh;
            background-image: url("{{ asset('assets/images/login.png') }}");
            background-size: cover;
            background-position: center;
            padding: 38px 52px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .brand img {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: #fff;
            padding: 9px;
            object-fit: contain;
        }

        .brand h1 {
            color: #fff;
            font-size: 30px;
            font-weight: 800;
        }

        .brand p {
            color: #fff;
            font-size: 16px;
            margin-top: 6px;
        }

        .left-title {
            margin-top: 120px;
            font-size: 30px;
            line-height: 1.3;
            font-weight: 800;
        }

        .green {
            color: #006334;
        }

        .white {
            color: #fff;
        }

        .quote-box {
            position: absolute;
            left: 55px;
            bottom: 28px;
            width: 455px;
            background: rgba(255,255,255,0.78);
            border-radius: 12px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #006334;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.25;
        }

        .quote-mark {
            font-size: 44px;
            font-weight: 800;
            line-height: 1;
        }

        .right-panel {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px 70px 0;
            background: #fff;
        }

        .mode-btn {
            width: 150px;
            height: 42px;
            border: 1px solid #cfcfcf;
            border-radius: 30px;
            background: #fff;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            margin-bottom: 12px;
            align-self: flex-end;
        }

        .register-card {
            width: 730px;
            border: 1px solid #ddd;
            border-radius: 14px;
            padding: 17px 34px 12px;
            background: #fff;
        }

        .register-title {
            text-align: center;
            font-size: 31px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .register-subtitle {
            text-align: center;
            color: #c7c7c7;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .form-group {
            margin-bottom: 7px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .input-box {
            height: 48px;
            border: 1px solid #ddd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            padding: 0 18px;
        }

        .input-icon {
            font-size: 21px;
            margin-right: 18px;
        }

        .input-box input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 18px;
            background: transparent;
        }

        .input-box input::placeholder {
            color: #c5c5c5;
        }

        .eye-icon {
            font-size: 20px;
            cursor: pointer;
            color: #111;
            user-select: none;
        }

        .terms {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 10px 0 12px;
            font-size: 16px;
        }

        .terms input {
            width: 24px;
            height: 24px;
        }

        .terms a {
            color: #006334;
            text-decoration: none;
            font-weight: 600;
        }

        .register-btn {
            width: 100%;
            height: 58px;
            border: none;
            border-radius: 9px;
            background: #55CDA3;
            font-size: 21px;
            font-weight: 800;
            cursor: pointer;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 24px;
            margin: 12px 0 14px;
            color: #c6c6c6;
            font-size: 18px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #d7d7d7;
        }

        .google-btn {
            width: 100%;
            height: 52px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            font-size: 22px;
            font-weight: 800;
            text-decoration: none;
            color: #111;
        }

        .google-logo {
            font-size: 28px;
            font-weight: 800;
            font-family: Arial, sans-serif;
        }

        .g-blue { color: #4285F4; }
        .g-red { color: #DB4437; }
        .g-yellow { color: #F4B400; }
        .g-green { color: #0F9D58; }

        .login-link {
            text-align: center;
            margin-top: 11px;
            color: #999;
            font-size: 15px;
        }

        .login-link a {
            color: #006334;
            font-weight: 800;
            text-decoration: none;
            margin-left: 7px;
        }

        body.dark .right-panel,
        body.dark .register-card,
        body.dark .mode-btn,
        body.dark .google-btn {
            background: #1b1b1b;
            color: #fff;
        }

        body.dark .register-card,
        body.dark .input-box,
        body.dark .mode-btn,
        body.dark .google-btn {
            border-color: #444;
        }

        body.dark input {
            color: #fff;
        }

        body.dark .eye-icon,
        body.dark .input-icon {
            color: #fff;
        }

        body.dark .login-link a,
        body.dark .terms a {
            color: #55CDA3;
        }
    </style>
</head>

<body>

<div class="register-page">

    <div class="left-panel">
        <div class="brand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Ruang Pulih">

            <div>
                <h1>Ruang Pulih</h1>
                <p>Tempat aman untuk kesehatan mentalmu</p>
            </div>
        </div>

        <div class="left-title">
            <span class="green">Kamu tidak sendiri.</span><br>
            <span class="white">Mari mulai perjalanan<br>pemulihan bersama.</span>
        </div>

        <div class="quote-box">
            <div class="quote-mark">“</div>
            <div>
                Kesehatan mental adalah pondasi untuk menjalani<br>
                hidup yang lebih bermakna.
            </div>
        </div>
    </div>

    <div class="right-panel">

        <button type="button" class="mode-btn" onclick="toggleDarkMode()">
            🌙 Mode Gelap
        </button>

        <div class="register-card">
            <h2 class="register-title">Selamat Datang 👋</h2>

            <p class="register-subtitle">
                Mulai perjalanan pemulihanmu bersama Ruang Pulih
            </p>

            <form action="#" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-box">
                        <span class="input-icon">♙</span>
                        <input type="text" name="name" placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-box">
                        <span class="input-icon">✉</span>
                        <input type="email" name="email" placeholder="Masukkan email">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-box">
                        <span class="input-icon">▢</span>
                        <input type="password" id="password" name="password" placeholder="Buat password">
                        <span class="eye-icon" onclick="togglePassword()">⊙</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-box">
                        <span class="input-icon">▢</span>
                        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Konfirmasi password">
                        <span class="eye-icon" onclick="toggleConfirmPassword()">⊙</span>
                    </div>
                </div>

                <div class="terms">
                    <input type="checkbox">
                    <span>
                        Saya menyetujui
                        <a href="#">Syarat & Ketentuan</a>
                        dan
                        <a href="#">Kebijakan Privasi</a>
                    </span>
                </div>

                <button type="submit" class="register-btn">
                    ↪ Daftar sekarang
                </button>

                <div class="divider">
                    atau daftar dengan
                </div>

                <a href="https://accounts.google.com/" class="google-btn">
                    <span class="google-logo">
                        <span class="g-blue">G</span><span class="g-red">o</span><span class="g-yellow">o</span><span class="g-blue">g</span><span class="g-green">l</span><span class="g-red">e</span>
                    </span>
                </a>

                <div class="login-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Masuk di sini &gt;</a>
                </div>
            </form>
        </div>

    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function toggleConfirmPassword() {
        const input = document.getElementById('confirmPassword');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function toggleDarkMode() {
        document.body.classList.toggle('dark');
    }
</script>

</body>
</html>