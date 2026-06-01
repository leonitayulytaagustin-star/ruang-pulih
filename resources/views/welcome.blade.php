<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Pulih</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f6fcf8;
        }

        .home-page {
            align-items: center;
            background-image: url("{{ asset('assets/images/background.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
            padding: 40px 24px;
            text-align: center;
            width: 100%;
            overflow-y: auto;
        }

        .home-title {
            color: #005c34;
            font-size: clamp(32px, 5vw, 72px);
            font-weight: 800;
            line-height: 1.2;
            margin-top: 0;
            text-shadow: 0 2px 4px rgba(255,255,255,0.5);
        }

        .home-subtitle {
            color: #005c34;
            font-size: clamp(18px, 2.5vw, 36px);
            line-height: 1.4;
            margin-top: 20px;
            max-width: 760px;
        }

        .home-logo {
            background: #fff;
            border-radius: 50%;
            height: clamp(150px, 20vw, 310px);
            margin-top: 30px;
            object-fit: contain;
            width: clamp(150px, 20vw, 310px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .start-button {
            align-items: center;
            background: #005c34;
            border-radius: 50px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            color: #fff;
            display: inline-flex;
            font-size: clamp(18px, 2vw, 24px);
            font-weight: 800;
            gap: 14px;
            justify-content: center;
            margin-top: 40px;
            min-width: min(320px, 100%);
            padding: 16px 40px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .start-button:hover {
            background: #00874e;
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 576px) {
            .home-page {
                padding: 30px 20px;
            }
            .home-title {
                font-size: 32px;
            }
            .home-subtitle {
                font-size: 18px;
            }
            .start-button {
                width: 100%;
                padding: 14px 28px;
            }
        }
    </style>
</head>
<body>
    <main class="home-page">
        <h1 class="home-title">
            Selamat Datang di<br>
            Ruang Pulih <i class="fa-solid fa-leaf" aria-hidden="true"></i>
        </h1>

        <p class="home-subtitle">
            Ruang aman untuk memahami dan menjaga<br>
            kesehatan mentalmu.
        </p>

        <img class="home-logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo Ruang Pulih">

        <a class="start-button" href="{{ route('edukasi.index') }}">
            Mulai Sekarang <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </main>
</body>
</html>
