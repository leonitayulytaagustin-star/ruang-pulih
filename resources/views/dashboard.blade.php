<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Ruang Pulih</title>

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
    font-family:Arial,sans-serif;
    background:#F5FBF7;
}

body.dark{
    background:#111;
    color:white;
}

.dashboard{
    width:100%;
    height:100vh;
    padding:14px;
}

.topbar{
    width:100%;
    height:70px;
    background:#4E946D;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 24px;
}

.logo-area{
    display:flex;
    align-items:center;
    gap:15px;
}

.logo-area img{
    width:48px;
    height:48px;
    border-radius:50%;
    background:white;
    padding:4px;
}

.logo-area h1{
    color:white;
    font-size:30px;
    font-weight:800;
}

.top-menu{
    display:flex;
    gap:14px;
}

.top-menu button{
    width:110px;
    height:40px;
    border:none;
    border-radius:10px;
    background:#CFFFDD;
    cursor:pointer;
    font-weight:700;
}

.content{
    width:100%;
    height:calc(100vh - 90px);
    margin-top:12px;
    display:grid;
    grid-template-columns:310px 1fr;
    gap:15px;
}

.sidebar{
    width:100%;
    height:100%;
    background:#58D0A7;
    border-radius:12px;
    position:relative;
    padding:22px 18px;
    overflow:hidden;
}

.profile-box{
    width:100%;
    height:160px;
    border-radius:18px;
    background:rgba(255,255,255,0.12);
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:black;
}

.profile-icon{
    font-size:70px;
}

.profile-box h2{
    font-size:28px;
    margin-top:8px;
}

.menu{
    margin-top:28px;
}

.menu a{
    width:100%;
    height:54px;
    display:flex;
    align-items:center;
    gap:14px;
    padding:0 16px;
    text-decoration:none;
    color:black;
    border-radius:12px;
    margin-bottom:14px;
    font-size:16px;
}

.menu a.active{
    background:#CFFFDD;
}

.sidebar-image{
    position:absolute;
    bottom:0;
    left:50%;
    transform:translateX(-50%);
    width:230px;
    max-width:90%;
    object-fit:contain;
}

.main{
    width:100%;
    height:100%;
    display:grid;
    grid-template-columns:1fr 360px;
    grid-template-rows:145px 235px 1fr;
    gap:12px 18px;
}

.welcome{
    grid-column:1/3;
    border-radius:18px;
    background:linear-gradient(90deg,#2E8B57,#5DD5B1);
    padding:18px 34px;
    color:white;
}

.welcome p{
    font-size:20px;
    font-weight:700;
}

.welcome h1{
    font-size:42px;
    margin:8px 0;
}

.welcome span{
    font-size:22px;
}

.card{
    background:white;
    border-radius:18px;
    box-shadow:0 2px 8px rgba(0,0,0,0.15);
}

body.dark .card{
    background:#1F1F1F;
    color:white;
}

.mood-card{
    padding:18px 24px;
}

.mood-card h2{
    font-size:22px;
}

.mood-card p{
    margin-top:5px;
    font-size:15px;
}

.mood-list{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:38px;
    margin-top:18px;
}

.mood-item{
    text-align:center;
    cursor:pointer;
    transition:.2s;
}

.mood-item img{
    width:58px;
    height:58px;
    object-fit:contain;
    transition:.2s;
}

.mood-item span{
    display:block;
    margin-top:8px;
    font-size:13px;
    text-align:center;
}

.mood-item.selected img{
    transform:scale(1.15);
}

.mood-item.selected span{
    color:#2E8B57;
    font-weight:800;
}

.mood-result{
    margin-top:12px;
    text-align:center;
    font-size:16px;
    font-weight:700;
    color:#2E8B57;
}

.notif{
    padding:24px;
    display:flex;
    justify-content:space-between;
}

.notif img{
    width:68px;
}

.notif h2{
    font-size:25px;
    margin:14px 0 8px;
}

.notif p{
    color:#555;
    font-size:17px;
    font-weight:600;
}

.arrow{
    font-size:38px;
}

.activity{
    padding:18px 26px;
}

.activity h2{
    font-size:25px;
}

.activity p{
    margin-top:6px;
    font-size:15px;
}

.riwayat-table{
    width:100%;
    margin-top:18px;
    border-collapse:collapse;
}

.riwayat-table th{
    background:#CFFFDD;
    padding:12px;
    text-align:left;
    font-size:14px;
}

.riwayat-table td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.empty{
    text-align:center;
    color:#888;
    padding:25px 0;
}

.right{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.caption{
    width:100%;
    height:160px;
    overflow:hidden;
    border-radius:18px;
}

.caption img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.tips{
    width:100%;
    height:68px;
    background:#ECECEC;
    border-radius:14px;
    display:flex;
    align-items:center;
    gap:14px;
    padding:0 18px;
}

.tips-icon{
    width:48px;
    height:48px;
    border-radius:50%;
    background:#CFFFDD;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
}

.tips h3{
    font-size:18px;
}

.tips p{
    font-size:12px;
}

body.dark .topbar{background:#21573F}
body.dark .sidebar{background:#25785B}
body.dark .menu a.active{background:#73D8B3}
body.dark .tips{background:#2A2A2A}
body.dark .riwayat-table th{
    background:#2E8B57;
}
</style>
</head>

<body>

<div class="dashboard">

    <div class="topbar">
        <div class="logo-area">
            <img src="{{ asset('assets/images/logo.png') }}">
            <h1>Ruang Pulih</h1>
        </div>

        <div class="top-menu">
            <button>About</button>
            <button>Setting</button>
            <button onclick="toggleDarkMode()">🌙 Mode</button>
        </div>
    </div>

    <div class="content">

        <div class="sidebar">

            <a href="#" class="profile-box">
                <div class="profile-icon">👤</div>
                <h2>Profil</h2>
            </a>

            <div class="menu">
                <a href="#" class="active">🏠 Home</a>
                <a href="{{ route('skrining.index') }}">🧾 Skrining Kesehatan Mental</a>
                <a href="{{ route('konsultasi.index') }}">💬 Konsultasi Online</a>
                <a href="{{ route('pemantauan.index') }}">📊 Pemantauan Kondisi Mental</a>
            </div>

            <img src="{{ asset('assets/images/sidebar.png') }}" class="sidebar-image">

        </div>

        <div class="main">

            <div class="welcome">
                <p>Halo, {{ Auth::user()->name ?? 'Nama Pengguna' }} 👋</p>
                <h1>Bagaimana Perasaanmu Hari Ini?</h1>
                <span>Yuk, jaga kesehatan mentalmu setiap hari.</span>
            </div>

            <div class="card mood-card">

                <h2>Bagaimana mood kamu hari ini?</h2>
                <p>Pilih mood yang paling kamu rasakan saat ini.</p>

                <div class="mood-list">

                    <div class="mood-item" onclick="pilihMood(this, 'Sangat Baik')">
                        <img src="{{ asset('assets/images/sangatbaik.png') }}">
                        <span>Sangat Baik</span>
                    </div>

                    <div class="mood-item" onclick="pilihMood(this, 'Baik')">
                        <img src="{{ asset('assets/images/baik.png') }}">
                        <span>Baik</span>
                    </div>

                    <div class="mood-item" onclick="pilihMood(this, 'Biasa Saja')">
                        <img src="{{ asset('assets/images/biasasaja.png') }}">
                        <span>Biasa Saja</span>
                    </div>

                    <div class="mood-item" onclick="pilihMood(this, 'Tidak Baik')">
                        <img src="{{ asset('assets/images/tidakbaik.png') }}">
                        <span>Tidak Baik</span>
                    </div>

                    <div class="mood-item" onclick="pilihMood(this, 'Sangat Buruk')">
                        <img src="{{ asset('assets/images/sangatburuk.png') }}">
                        <span>Sangat Buruk</span>
                    </div>

                </div>

                <div class="mood-result" id="moodResult">
                    Pilih mood kamu hari ini
                </div>

            </div>

            <div class="card notif">

                <div>
                    <img src="{{ asset('assets/images/lonceng.png') }}">

                    <h2>Notifikasi</h2>

                    <p>
                        Kelola preferensi notifikasi dan pengingat Anda.
                    </p>
                </div>

                <div class="arrow">›</div>

            </div>

            <div class="card activity">

                <h2>Riwayat Aktivitas Singkat</h2>

                <p>Aktivitas yang telah kamu lakukan hari ini</p>

                <table class="riwayat-table">

                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td colspan="3" class="empty">
                                Belum ada aktivitas hari ini
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="right">

                <div class="card caption">
                    <img src="{{ asset('assets/images/caption.png') }}">
                </div>

                <div class="tips">

                    <div class="tips-icon">💡</div>

                    <div>
                        <h3>Tips Hari Ini</h3>

                        <p>
                            Luangkan waktu 10 menit hari ini untuk bernapas dalam dan bersyukur atas hal kecil.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark');
}

function pilihMood(element, mood) {

    document.querySelectorAll('.mood-item').forEach(item => {
        item.classList.remove('selected');
    });

    element.classList.add('selected');

    document.getElementById('moodResult').innerText =
        'Mood kamu hari ini: ' + mood;
}
</script>

</body>
</html>