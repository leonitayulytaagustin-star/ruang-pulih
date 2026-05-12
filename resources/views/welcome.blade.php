<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Pulih</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f5f1df;
            overflow:hidden;
        }

        .container{
            width:100%;
            height:100vh;
            background-image:url('{{ asset('assets/images/background.png') }}');
            background-size:cover;
            background-position:center;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .content{
            text-align:center;
             
        }

        h1{
            color:#2d8b57;
            font-size:60px;
            margin-bottom:15px;
            font-weight:bold;
        }

        p{
            color:#5a5a5a;
            font-size:22px;
            margin-bottom:30px;
        }

        .logo{
            width:320px;
            margin-bottom:30px;
        }

        .btn{
            display:inline-block;
            padding:15px 45px;
            background:#2d8b57;
            color:white;
            text-decoration:none;
            border-radius:40px;
            font-size:22px;
            transition:0.3s;
        }

        .btn:hover{
            background:#246d46;
        }

    </style>

</head>
<body>

    <div class="container">

        <div class="content">

            <h1>
                Selamat Datang di <br>
                Ruang Pulih 🌿
            </h1>

            <p>
                "Ruang aman untuk memahami dan menjaga <br>
                kesehatan mentalmu"
            </p>

            <img 
                src="{{ asset('assets/images/logo.png') }}" 
                class="logo"
            >

            <br>

           <a href="/edukasi" class="btn">
                Mulai Sekarang →
            </a>

        </div>

    </div>

</body>
</html>