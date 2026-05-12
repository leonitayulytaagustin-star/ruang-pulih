<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pemantauan Kondisi Mental - Ruang Pulih</title>
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
    background:#F7FBF8;
}

body.dark{
    background:#121212;
    color:white;
}

.page{
    width:100%;
    height:100vh;
    padding:10px;
}

/* TOPBAR */
.topbar{
    height:60px;
    background:#4F946B;
    border-radius:8px;
    padding:0 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    display:flex;
    align-items:center;
    gap:14px;
    color:white;
}

.logo img{
    width:44px;
    height:44px;
    border-radius:50%;
    background:white;
    padding:4px;
}

.logo h1{
    font-size:28px;
}

.top-buttons{
    display:flex;
    gap:12px;
}

.top-buttons button{
    width:100px;
    height:38px;
    border:none;
    border-radius:10px;
    background:#BDEEC8;
    font-weight:700;
    cursor:pointer;
}

/* LAYOUT */
.layout{
    height:calc(100vh - 72px);
    margin-top:8px;
    display:grid;
    grid-template-columns:310px 1fr;
    gap:10px;
}

/* SIDEBAR */
.sidebar{
    background:#61D1AB;
    border-radius:10px;
    padding:14px;
    position:relative;
    overflow:hidden;
}

.profile-box{
    height:165px;
    background:rgba(255,255,255,.12);
    border-radius:14px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:#000;
    text-decoration:none;
}

.profile-icon{
    font-size:56px;
}

.profile-box h2{
    margin-top:8px;
    font-size:24px;
}

.menu{
    margin-top:12px;
}

.menu a{
    height:46px;
    border-radius:10px;
    display:flex;
    align-items:center;
    gap:12px;
    padding:0 16px;
    text-decoration:none;
    color:#000;
    margin-bottom:8px;
    font-size:14px;
}

.menu a.active{
    background:#BDEEC8;
}

.sidebar-img{
    width:210px;
    position:absolute;
    bottom:-5px;
    left:50%;
    transform:translateX(-50%);
}

/* CONTENT */
.content{
    display:grid;
    grid-template-rows:128px 1fr;
    gap:10px;
}

/* HERO */
.hero{
    background:linear-gradient(90deg,#2E8B57,#5ED3B2);
    border-radius:12px;
    padding:18px 34px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.hero h1{
    font-size:34px;
    margin-bottom:8px;
}

.hero p{
    font-size:16px;
}

.hero img{
    width:190px;
    height:110px;
    object-fit:contain;
}

/* MAIN */
.main-grid{
    display:grid;
    grid-template-columns:1fr 360px;
    gap:18px;
    padding:0 20px 0 20px;
    height:100%;
}

/* LEFT */
.left{
    display:grid;
    grid-template-rows:370px 1fr;
    gap:10px;
}

.card{
    background:white;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,.12);
}

/* QUESTION CARD */
.question-card{
    padding:16px 20px;
}

.question-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:10px;
}

.question-header h2{
    font-size:18px;
    margin-bottom:5px;
}

.question-header p{
    font-size:13px;
    color:#555;
}

.badge{
    background:#ECECEC;
    color:#0B6B3A;
    padding:8px 12px;
    border-radius:8px;
    font-size:13px;
    font-weight:700;
}

.question-row{
    height:62px;
    border-bottom:1px solid #ddd;
    display:grid;
    grid-template-columns:44px 1fr 260px;
    align-items:center;
    gap:10px;
}

.row-icon{
    width:38px;
    height:38px;
    border-radius:10px;
    background:#BDEEC8;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:20px;
}

.question-text{
    font-size:14px;
    font-weight:600;
}

.faces{
    display:flex;
    justify-content:space-between;
}

.face{
    font-size:28px;
    cursor:pointer;
    color:#aaa;
    transition:.2s;
}

.face.active{
    color:#1C8A54;
    transform:scale(1.1);
}

.action-row{
    margin-top:12px;
    display:flex;
    justify-content:space-between;
}

.prev-btn{
    width:140px;
    height:40px;
    border-radius:6px;
    border:1px solid #999;
    background:white;
    font-weight:700;
    cursor:pointer;
}

.submit-btn{
    width:140px;
    height:40px;
    border:none;
    border-radius:6px;
    background:#2E8B57;
    color:white;
    font-weight:700;
    cursor:pointer;
}

/* HISTORY */
.history-card{
    padding:16px 20px;
}

.history-card h2{
    font-size:18px;
}

.history-card p{
    margin-top:4px;
    font-size:13px;
    color:#555;
}

.history-row{
    height:58px;
    border-bottom:1px solid #ddd;
    display:grid;
    grid-template-columns:130px 1fr 110px;
    align-items:center;
}

.history-faces{
    display:flex;
    gap:38px;
    font-size:24px;
    color:#999;
}

.detail-btn{
    height:36px;
    border-radius:6px;
    border:1px solid #aaa;
    background:white;
    font-weight:700;
    color:#2E8B57;
    cursor:pointer;
}

/* RIGHT */
.right{
    display:grid;
    grid-template-rows:240px 1fr;
    gap:12px;
}

.recommend-card{
    padding:16px 20px;
}

.recommend-card h3{
    margin-bottom:12px;
}

.recommend-item{
    display:grid;
    grid-template-columns:40px 1fr;
    gap:10px;
    align-items:center;
    margin-bottom:14px;
    font-size:13px;
    color:#555;
}

.rec-icon{
    width:34px;
    height:34px;
    border-radius:6px;
    background:#EEF9F1;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:20px;
}

.note-card{
    padding:16px 20px;
}

.note-card h3{
    margin-bottom:4px;
}

.note-card p{
    font-size:13px;
    color:#555;
    margin-bottom:10px;
}

.note-card textarea{
    width:100%;
    height:215px;
    resize:none;
    border:1px solid #bbb;
    border-radius:4px;
    padding:12px;
    outline:none;
}

/* DARK MODE */
body.dark .card{
    background:#1F1F1F;
    color:white;
}

body.dark .question-header p,
body.dark .history-card p,
body.dark .recommend-item,
body.dark .note-card p{
    color:#ccc;
}

body.dark .prev-btn,
body.dark .detail-btn,
body.dark textarea{
    background:#111;
    color:white;
    border-color:#444;
}

body.dark .menu a{
    color:white;
}

body.dark .menu a.active,
body.dark .top-buttons button{
    background:#A5E4B7;
    color:black;
}
</style>
</head>

<body>

<div class="page">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}">
            <h1>Ruang Pulih</h1>
        </div>

        <div class="top-buttons">
            <button>About</button>
            <button>Setting</button>
            <button onclick="toggleDarkMode()">🌙 Mode</button>
        </div>

    </div>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <a href="#" class="profile-box">
                <div class="profile-icon">👤</div>
                <h2>Profil</h2>
            </a>

            <div class="menu">
                <a href="{{ url('/dashboard') }}">🏠 Home</a>

                <a href="{{ route('skrining.index') }}">
                    🧾 Skrining Kesehatan Mental
                </a>

                <a href="{{ route('konsultasi.index') }}">
                    💬 Konsultasi Online
                </a>

                <a href="{{ route('pemantauan.index') }}" class="active">
                    📊 Pemantauan Kondisi Mental
                </a>
            </div>

            <img src="{{ asset('assets/images/sidebar.png') }}" class="sidebar-img">

        </aside>

        <!-- CONTENT -->
        <main class="content">

            <!-- HERO -->
            <section class="hero">

                <div>
                    <h1>Pemantauan Kondisi Mental</h1>
                    <p>Pantau perasaan dan kondisi emosimu setiap hari.</p>
                </div>

                <img src="{{ asset('assets/images/pkm.png') }}">

            </section>

            <!-- MAIN -->
            <section class="main-grid">

                <!-- LEFT -->
                <div class="left">

                    <div class="card question-card">

                        <div class="question-header">

                            <div>
                                <h2>Jawab beberapa pertanyaan berikut</h2>
                                <p>Berikan penilaian yang paling sesuai dengan kondisimu hari ini.</p>
                            </div>

                            <div class="badge">2 dari 2</div>

                        </div>

                        <!-- QUESTION -->
                        <div class="question-row">
                            <div class="row-icon">🌧️</div>
                            <div class="question-text">Apakah kamu merasa sedih hari ini?</div>

                            <div class="faces">
                                <span class="face">😊</span>
                                <span class="face">🙂</span>
                                <span class="face">😐</span>
                                <span class="face">☹️</span>
                                <span class="face active">😟</span>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="row-icon">😟</div>
                            <div class="question-text">Apakah kamu merasa cemas atau khawatir?</div>

                            <div class="faces">
                                <span class="face">😊</span>
                                <span class="face">🙂</span>
                                <span class="face">😐</span>
                                <span class="face active">☹️</span>
                                <span class="face">😟</span>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="row-icon">😰</div>
                            <div class="question-text">Apakah kamu merasa tidak berharga atau putus asa?</div>

                            <div class="faces">
                                <span class="face">😊</span>
                                <span class="face">🙂</span>
                                <span class="face active">😐</span>
                                <span class="face">☹️</span>
                                <span class="face">😟</span>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="row-icon">🧠</div>
                            <div class="question-text">Apakah kamu pernah mendengar suara yang orang lain tidak dengar?</div>

                            <div class="faces">
                                <span class="face active">😊</span>
                                <span class="face">🙂</span>
                                <span class="face">😐</span>
                                <span class="face">☹️</span>
                                <span class="face">😟</span>
                            </div>
                        </div>

                        <div class="action-row">
                            <button class="prev-btn">&lt; Sebelumnya</button>

                            <button class="submit-btn">
                                Kirim
                            </button>
                        </div>

                    </div>

                    <!-- HISTORY -->
                    <div class="card history-card">

                        <h2>Riwayat Pemantauan Kondisi Mental</h2>
                        <p>Berikan penilaian yang paling sesuai dengan kondisimu hari ini.</p>

                        <div class="history-row">
                            <strong>7 Mei 2026</strong>

                            <div class="history-faces">
                                ☺ ☺ 😐 ☹ 😟
                            </div>

                            <button class="detail-btn">Lihat Detail</button>
                        </div>

                        <div class="history-row">
                            <strong>6 Mei 2026</strong>

                            <div class="history-faces">
                                ☺ ☺ 😐 ☹ 😟
                            </div>

                            <button class="detail-btn">Lihat Detail</button>
                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="right">

                    <div class="card recommend-card">

                        <h3>Rekomendasi Hari Ini</h3>

                        <div class="recommend-item">
                            <div class="rec-icon">🌿</div>
                            <div>Luangkan waktu 10 menit untuk meditasi atau tarik napas dalam</div>
                        </div>

                        <div class="recommend-item">
                            <div class="rec-icon">🎵</div>
                            <div>Coba dengarkan musik yang menenangkan</div>
                        </div>

                        <div class="recommend-item">
                            <div class="rec-icon">🥤</div>
                            <div>Jangan lupa minum air putih yang cukup</div>
                        </div>

                        <div class="recommend-item">
                            <div class="rec-icon">🫂</div>
                            <div>Jangan ragu untuk berbicara dengan orang terdekat</div>
                        </div>

                    </div>

                    <div class="card note-card">

                        <h3>Catatan Harian</h3>

                        <p>Ada hal yang ingin kamu ceritakan hari ini?</p>

                        <textarea placeholder="Tulis di sini..."></textarea>

                    </div>

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