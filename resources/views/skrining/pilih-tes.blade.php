<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pilih Tes Skrining - Ruang Pulih</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
    background:#fff;
}

body.dark{
    background:#111;
    color:#fff;
}

.page{
    width:100%;
    height:100vh;
    padding:10px;
}

.topbar{
    height:64px;
    background:#2E7D50;
    border-radius:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 22px;
}

.logo{
    display:flex;
    align-items:center;
    gap:14px;
    color:#fff;
}

.logo img{
    width:46px;
    height:46px;
    border-radius:50%;
    background:#fff;
    padding:5px;
}

.logo h1{
    font-size:30px;
}

.top-buttons{
    display:flex;
    gap:14px;
}

.top-buttons button{
    width:110px;
    height:38px;
    border:none;
    border-radius:10px;
    background:#B8EFC7;
    font-weight:bold;
    cursor:pointer;
}

.layout{
    height:calc(100vh - 78px);
    margin-top:10px;
    display:grid;
    grid-template-columns:310px 1fr;
    gap:10px;
}

.sidebar{
    background:#73D7B3;
    border-radius:10px;
    padding:14px;
    position:relative;
    overflow:hidden;
}

.profile-box{
    height:170px;
    background:rgba(255,255,255,.12);
    border-radius:14px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

.profile-box .icon{
    font-size:58px;
}

.profile-box h2{
    margin-top:8px;
    font-size:28px;
}

.menu{
    margin-top:18px;
}

.menu a{
    width:100%;
    height:52px;
    border-radius:10px;
    display:flex;
    align-items:center;
    gap:14px;
    padding:0 18px;
    text-decoration:none;
    color:#000;
    font-size:14px;
    margin-bottom:10px;
}

.menu a.active{
    background:#B8EFC7;
}

.sidebar-image{
    position:absolute;
    bottom:22px;
    left:50%;
    transform:translateX(-50%);
    width:215px;
}

.content{
    height:100%;
    display:grid;
    grid-template-rows:125px 1fr;
    gap:12px;
}

.hero{
    background:linear-gradient(90deg,#2E8B57,#58D0A7);
    border-radius:12px;
    padding:20px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.hero h1{
    font-size:34px;
    margin-bottom:10px;
}

.hero p{
    font-size:16px;
    line-height:1.5;
}

.hero img{
    width:180px;
    height:105px;
    object-fit:contain;
    margin-right:36px;
}

.test-grid{
    height:100%;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    grid-template-rows:repeat(2,1fr);
    gap:18px 58px;
    padding:10px 20px 0;
    overflow:hidden;
}

.test-card{
    width:100%;
}

.image-box{
    width:100%;
    height:94px;
    background:#b8b8b8;
    border-radius:8px;
    overflow:hidden;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

.image-box img{
    max-width:78%;
    max-height:82px;
    object-fit:contain;
    display:block;
}

.number{
    position:absolute;
    top:8px;
    left:10px;
    width:34px;
    height:34px;
    border-radius:50%;
    background:#B8EFC7;
    display:flex;
    justify-content:center;
    align-items:center;
    font-weight:bold;
    z-index:2;
}

.test-card h2{
    font-size:16px;
    margin-top:8px;
    margin-bottom:4px;
}

.test-card p{
    font-size:12px;
    line-height:1.3;
    margin-bottom:8px;
}

.start-btn{
    width:120px;
    height:34px;
    background:#2E7D50;
    border-radius:10px;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:18px;
    text-decoration:none;
    font-size:15px;
}

.start-btn span{
    font-size:26px;
    line-height:1;
}

body.dark .topbar{
    background:#1F5C3E;
}

body.dark .sidebar{
    background:#22684F;
}

body.dark .menu a{
    color:#fff;
}

body.dark .menu a.active,
body.dark .top-buttons button{
    background:#84D9B6;
    color:#000;
}

body.dark .test-card{
    color:#fff;
}

body.dark .image-box{
    background:#333;
}

body.dark .start-btn{
    background:#4CAF7A;
}
</style>
</head>

<body>

<div class="page">

    <div class="topbar">

        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}">
            <h1>Ruang Pulih</h1>
        </div>

        <div class="top-buttons">
            <button>About</button>
            <button>Setting</button>
            <button type="button" onclick="toggleDarkMode()">🌙 Mode</button>
        </div>

    </div>

    <div class="layout">

        <aside class="sidebar">

            <div class="profile-box">
                <div class="icon">👤</div>
                <h2>Profil</h2>
            </div>

            <div class="menu">
                <a href="{{ url('/dashboard') }}">🏠 Home</a>
                <a href="{{ route('skrining.index') }}" class="active">🧾 Skrining Kesehatan Mental</a>
                <a href="#">💬 Konsultasi Online</a>
                <a href="#">📊 Pemantauan Kondisi Mental</a>
            </div>

            <img src="{{ asset('assets/images/sidebar.png') }}" class="sidebar-image">

        </aside>

        <main class="content">

            <section class="hero">
                <div>
                    <h1>Pilih Tes Skrining Kesehatan Mental</h1>
                    <p>
                        Pilih salah satu tes di bawah ini untuk memulai skrining
                        kesehatan mental Anda.
                    </p>
                </div>

                <img src="{{ asset('assets/images/otak.png') }}">
            </section>

            <section class="test-grid">

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">1</div>
                        <img src="{{ asset('assets/images/enxiety.png') }}">
                    </div>

                    <h2>Gangguan Kecemasan (Anxiety)</h2>
                    <p>Tes untuk mengetahui tingkat kecemasan yang Anda alami</p>

                   <a href="{{ route('skrining.anxiety') }}" class="start-btn">
    Mulai Tes
    <span>→</span>
</a>
                </div>

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">2</div>
                        <img src="{{ asset('assets/images/depresi.png') }}">
                    </div>

                    <h2>Depresi</h2>
                    <p>Tes untuk mengetahui tingkat depresi yang Anda alami</p>

                    <a href="#" class="start-btn">
                        Mulai Tes <span>→</span>
                    </a>
                </div>

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">3</div>
                        <img src="{{ asset('assets/images/skizofrenia.png') }}">
                    </div>

                    <h2>Skizofrenia</h2>
                    <p>Tes untuk mengetahui kemungkinan gejala skizofrenia</p>

                    <a href="#" class="start-btn">
                        Mulai Tes <span>→</span>
                    </a>
                </div>

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">4</div>
                        <img src="{{ asset('assets/images/bipolar.png') }}">
                    </div>

                    <h2>Gangguan Mood (Bipolar)</h2>
                    <p>Tes untuk mengetahui adanya gejala gangguan mood atau bipolar</p>

                    <a href="{{ route('skrining.anxiety') }}" class="start-btn">
                        Mulai Tes <span>→</span>
                    </a>
                </div>

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">5</div>
                        <img src="{{ asset('assets/images/bpd.png') }}">
                    </div>

                    <h2>Borderline Personality Disorders (BPD)</h2>
                    <p>Tes untuk mengetahui kemungkinan gejala BPD</p>

                    <a href="#" class="start-btn">
                        Mulai Tes <span>→</span>
                    </a>
                </div>

                <div class="test-card">
                    <div class="image-box">
                        <div class="number">6</div>
                        <img src="{{ asset('assets/images/ptsd.png') }}">
                    </div>

                    <h2>Post-Traumatic Stress Disorders (PTSD)</h2>
                    <p>Tes untuk mengetahui kemungkinan gejala PTSD</p>

                    <a href="#" class="start-btn">
                        Mulai Tes <span>→</span>
                    </a>
                </div>

            </section>

        </main>

    </div>

</div>

<script>
function toggleDarkMode(){
    document.body.classList.toggle('dark');
}
</script>

</body>
</html>