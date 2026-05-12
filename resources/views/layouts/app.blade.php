<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Pulih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f5f5f5;
        }

        .navbar{
            width: calc(100% - 148px);
            height: 78px;
            background:white;
            margin: 24px auto 0;
            border:1px solid #dcdcdc;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 24px;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .logo img{
            width:42px;
        }

        .logo-text h2{
            font-size:24px;
            color:#111;
        }

        .logo-text p{
            font-size:12px;
            color:#666;
        }

        .menu{
            display:flex;
            gap:50px;
        }

        .menu a{
            text-decoration:none;
            color:#111;
            font-size:18px;
        }

        .menu .active{
            background:#B8EFD4;
            padding:8px 18px;
            border-radius:8px;
        }

        .auth-buttons{
            display:flex;
            gap:16px;
        }

        .auth-buttons a{
            text-decoration:none;
            border:1px solid #005C34;
            padding:10px 22px;
            border-radius:12px;
            color:#005C34;
            font-weight:600;
        }

    </style>

</head>
<body>

    <div class="navbar">

        <div class="logo">

            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">

            <div class="logo-text">
                <h2>Ruang Pulih</h2>
                <p>Tempat aman untuk kesehatan mentalmu</p>
            </div>

        </div>

        <div class="menu">
            <a href="#" class="active">Edukasi</a>
            <a href="#">Tentang</a>
            <a href="#">Bantuan</a>
        </div>

        <div class="auth-buttons">

            <a href="/login">
    Login / Daftar
            </a>

        </div>

    </div>

    @yield('content')

</body>
</html>