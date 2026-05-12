<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Ruang Pulih</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html,body{
            width:100%;
            height:100%;
            overflow:hidden;
            font-family:'Inter',sans-serif;
            background:#fff;
        }

        .login-page{
            width:100vw;
            height:100vh;
            display:grid;
            grid-template-columns:45% 55%;
        }

        .left-panel{
            position:relative;
            height:100vh;
            background-image:url("{{ asset('assets/images/login.png') }}");
            background-size:cover;
            background-position:center;
            padding:42px 58px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:18px;
        }

        .brand img{
            width:86px;
            height:86px;
            border-radius:50%;
            background:#fff;
            padding:10px;
            object-fit:contain;
        }

        .brand h1{
            color:#fff;
            font-size:31px;
            font-weight:800;
        }

        .brand p{
            color:#fff;
            font-size:17px;
            margin-top:6px;
        }

        .left-title{
            margin-top:130px;
            font-size:31px;
            line-height:1.28;
            font-weight:800;
        }

        .green{
            color:#006334;
        }

        .white{
            color:#fff;
        }

        .quote-box{
            position:absolute;
            left:58px;
            bottom:28px;
            width:470px;
            background:rgba(255,255,255,0.78);
            border-radius:12px;
            padding:16px 22px;
            display:flex;
            align-items:center;
            gap:14px;
            color:#006334;
            font-size:16px;
            font-weight:700;
            line-height:1.2;
        }

        .quote-mark{
            font-size:48px;
            font-weight:800;
            line-height:1;
        }

        .right-panel{
            height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:30px 75px;
            background:#fff;
        }

        .dark-mode{
            width:170px;
            height:46px;
            border:1px solid #cfcfcf;
            border-radius:30px;
            background:#fff;
            font-size:15px;
            font-weight:800;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            cursor:pointer;
            margin-bottom:24px;
            align-self:flex-end;
        }

        .login-card{
            width:730px;
            border:1px solid #ddd;
            border-radius:12px;
            padding:28px 34px 24px;
            background:#fff;
        }

        .login-title{
            text-align:center;
            font-size:31px;
            font-weight:800;
            margin-bottom:18px;
            line-height:1.3;
        }

        .login-subtitle{
            text-align:center;
            color:#c7c7c7;
            font-size:18px;
            font-weight:700;
            margin-bottom:36px;
        }

        .form-group{
            margin-bottom:24px;
        }

        .form-group label{
            display:block;
            font-size:22px;
            font-weight:800;
            margin-bottom:10px;
        }

        .input-box{
            height:57px;
            border:1px solid #ddd;
            border-radius:12px;
            display:flex;
            align-items:center;
            padding:0 22px;
        }

        .input-icon{
            font-size:25px;
            margin-right:22px;
        }

        .input-box input{
            flex:1;
            border:none;
            outline:none;
            font-size:20px;
            background:transparent;
        }

        .input-box input::placeholder{
            color:#c5c5c5;
        }

        .eye-icon{
            font-size:24px;
            cursor:pointer;
            margin-left:12px;
            user-select:none;
        }

        .form-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:24px;
        }

        .remember{
            display:flex;
            align-items:center;
            gap:15px;
            font-size:20px;
        }

        .remember input{
            width:34px;
            height:34px;
        }

        .forgot{
            color:#2B7A57;
            font-size:18px;
            text-decoration:none;
        }

        .login-submit{
            width:100%;
            height:64px;
            border:none;
            border-radius:8px;
            background:#55CDA3;
            font-size:22px;
            font-weight:800;
            cursor:pointer;
        }

        .divider{
            display:flex;
            align-items:center;
            gap:28px;
            margin:18px 0 28px;
            color:#c6c6c6;
            font-size:18px;
        }

        .divider::before,
        .divider::after{
            content:"";
            flex:1;
            height:1px;
            background:#d7d7d7;
        }

        .google-btn{
            width:100%;
            height:54px;
            border:1px solid #ddd;
            border-radius:9px;
            background:#fff;
            font-size:22px;
            font-weight:800;
            display:flex;
            justify-content:center;
            align-items:center;
            gap:16px;
            color:#111;
            text-decoration:none;
        }

        .google-logo{
            font-size:30px;
            font-weight:800;
            font-family:Arial,sans-serif;
        }

        .g-blue{ color:#4285F4; }
        .g-red{ color:#DB4437; }
        .g-yellow{ color:#F4B400; }
        .g-green{ color:#0F9D58; }

        .register-link{
            text-align:center;
            margin-top:22px;
            color:#999;
            font-size:15px;
        }

        .register-link a{
            color:#006334;
            font-weight:800;
            text-decoration:none;
            margin-left:8px;
        }

        body.dark .right-panel,
        body.dark .login-card,
        body.dark .dark-mode,
        body.dark .google-btn{
            background:#1b1b1b;
            color:#fff;
        }

        body.dark .input-box,
        body.dark .login-card,
        body.dark .dark-mode,
        body.dark .google-btn{
            border-color:#444;
        }

        body.dark input{
            color:#fff;
        }

        body.dark .forgot,
        body.dark .register-link a{
            color:#55CDA3;
        }

    </style>

</head>

<body>

<div class="login-page">

    <div class="left-panel">

        <div class="brand">

            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">

            <div>
                <h1>Ruang Pulih</h1>
                <p>Tempat aman untuk kesehatan mentalmu</p>
            </div>

        </div>

        <div class="left-title">
            <span class="green">Kamu tidak sendiri.</span><br>
            <span class="white">
                Mari mulai perjalanan<br>
                pemulihan bersama.
            </span>
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

        <button type="button" class="dark-mode" onclick="toggleDarkMode()">
            🌙 Mode Gelap
        </button>

        <div class="login-card">

            <h2 class="login-title">
                Selamat Datang Kembali 👋
            </h2>

            <p class="login-subtitle">
                Silahkan Login untuk Melanjutkan Perjalananmu di Ruang Pulih
            </p>

            <form action="/login" method="POST">

                @csrf

                <div class="form-group">

                    <label>Email</label>

                    <div class="input-box">

                        <span class="input-icon">✉</span>

                        <input
                            type="email"
                            name="email"
                            placeholder="Masukkan email"
                            required
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <div class="input-box">

                        <span class="input-icon">▣</span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >

                        <span class="eye-icon" onclick="togglePassword()">
                            👁
                        </span>

                    </div>

                </div>

                <div class="form-row">

                    <label class="remember">
                        <input type="checkbox">
                        Remember me
                    </label>

                    <a href="#" class="forgot">
                        Lupa password?
                    </a>

                </div>

                <button type="submit" class="login-submit">
                    ↪ Login
                </button>

                <div class="divider">
                    atau login dengan
                </div>

                <a href="#" class="google-btn">

                    <span class="google-logo">
                        <span class="g-blue">G</span><span class="g-red">o</span><span class="g-yellow">o</span><span class="g-blue">g</span><span class="g-green">l</span><span class="g-red">e</span>
                    </span>

                </a>

                <div class="register-link">
    Belum punya akun?
    <a href="{{ route('register') }}">Daftar sekarang &gt;</a>
</div>

            </form>

        </div>

    </div>

</div>

<script>

function togglePassword(){

    const password =
        document.getElementById('password');

    if(password.type === 'password'){
        password.type = 'text';
    }else{
        password.type = 'password';
    }
}

function toggleDarkMode(){
    document.body.classList.toggle('dark');
}

</script>

</body>
</html>