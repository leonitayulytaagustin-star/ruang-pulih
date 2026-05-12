<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Skrining Kesehatan Mental - Ruang Pulih</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    background:#fff;
}

.page{
    width:100%;
    height:100vh;
    padding:10px;
}

/* ================= TOPBAR ================= */

.topbar{
    height:60px;
    background:#2E7D50;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 24px;
}

.logo{
    display:flex;
    align-items:center;
    gap:14px;
    color:white;
}

.logo img{
    width:46px;
    height:46px;
    border-radius:50%;
    background:white;
    padding:5px;
}

.logo h1{
    font-size:28px;
}

.top-btn{
    display:flex;
    gap:14px;
}

.top-btn button{
    width:110px;
    height:36px;
    border:none;
    border-radius:8px;
    background:#B8EFC7;
    font-weight:700;
    cursor:pointer;
}

/* ================= LAYOUT ================= */

.layout{
    height:calc(100vh - 74px);
    display:grid;
    grid-template-columns:305px 1fr;
    gap:12px;
    margin-top:10px;
}

/* ================= SIDEBAR ================= */

.sidebar{
    background:#76D7B6;
    border-radius:10px;
    padding:18px 16px;
    position:relative;
    overflow:hidden;
}

.profile{
    height:145px;
    background:rgba(255,255,255,.12);
    border-radius:14px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:#000;
}

.profile-icon{
    font-size:54px;
}

.profile h2{
    font-size:26px;
    margin-top:6px;
}

.menu{
    margin-top:18px;
}

.menu a{
    height:46px;
    display:flex;
    align-items:center;
    gap:12px;
    padding:0 14px;
    border-radius:10px;
    text-decoration:none;
    color:#000;
    font-size:14px;
    margin-bottom:8px;
}

.menu a.active{
    background:#B8EFC7;
}

.sidebar-img{
    position:absolute;
    bottom:15px;
    left:50%;
    transform:translateX(-50%);
    width:240px;
}

/* ================= CONTENT ================= */

.content{
    height:100%;
    display:grid;
    grid-template-columns:1fr 300px;
    grid-template-rows:130px 1fr;
    gap:10px;
}

/* ================= HERO ================= */

.hero{
    grid-column:1/3;
    background:linear-gradient(90deg,#2E8B57,#58D0A7);
    border-radius:10px;
    color:white;
    padding:18px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.hero h1{
    font-size:36px;
    margin-bottom:6px;
}

.hero p{
    font-size:18px;
    line-height:1.2;
}

.hero img{
    width:200px;
    height:120px;
    object-fit:contain;
    margin-right:40px;
}

/* ================= FORM ================= */

.form-area{
    padding:0 10px;
}

.section-title{
    display:flex;
    align-items:center;
    gap:12px;
    font-size:22px;
    font-weight:800;
    margin-bottom:8px;
}

.round-icon{
    width:30px;
    height:30px;
    border-radius:50%;
    background:#B8EFC7;
    display:flex;
    align-items:center;
    justify-content:center;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px 16px;
}

.form-group label{
    font-size:13px;
    font-weight:800;
    display:block;
    margin-bottom:5px;
}

.input-box,
select,
textarea{
    width:100%;
    height:38px;
    border:1px solid #cfcfcf;
    border-radius:7px;
    padding:0 14px;
    font-size:13px;
    outline:none;
}

.umur-wrap{
    display:flex;
}

.umur-wrap input{
    flex:1;
    border-radius:7px 0 0 7px;
}

.umur-wrap span{
    width:82px;
    height:38px;
    background:#c8bebe;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:0 7px 7px 0;
    font-weight:700;
}

.health{
    margin-top:6px;
}

.health-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px 16px;
}

.radio-group{
    display:flex;
    gap:12px;
    margin-top:5px;
}

.radio-group label{
    display:flex;
    align-items:center;
    gap:6px;
    font-size:14px;
    font-weight:400;
}

.radio-group input{
    width:17px;
    height:17px;
}

textarea{
    height:60px;
    padding-top:10px;
    resize:none;
}

.full{
    grid-column:1/3;
}

/* ================= BUTTON ================= */

.submit-area{
    text-align:center;
    margin-top:4px;
}

.submit-btn{
    width:190px;
    height:38px;
    background:#2E7D50;
    color:white;
    border:none;
    border-radius:8px;
    font-size:15px;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
}

.submit-note{
    color:#aaa;
    margin-top:5px;
    font-size:12px;
}

/* ================= RIGHT CARD ================= */

.side-card{
    background:#76D7B6;
    border-radius:10px;
    padding:22px 24px;
    height:315px;
}

.side-card h2{
    text-align:center;
    margin-bottom:18px;
    font-size:22px;
}

.side-card p{
    font-size:14px;
    font-weight:700;
    line-height:1.2;
    margin-bottom:12px;
}

.side-card hr{
    border:none;
    border-top:1px solid #2E7D50;
    margin:10px 0;
}

.info-row{
    display:flex;
    align-items:center;
    gap:12px;
    margin:13px 0;
    font-size:14px;
}

/* ================= HELP CARD ================= */

.help-card{
    background:#2E7D50;
    color:white;
    border-radius:7px;
    padding:20px 24px;
    margin-top:14px;
    height:135px;
}

.help-card h2{
    font-size:22px;
    margin-bottom:10px;
}

.help-card p{
    font-size:14px;
    margin-bottom:12px;
}

.help-card button{
    width:145px;
    height:34px;
    border:none;
    border-radius:7px;
    background:#B8EFC7;
    cursor:pointer;
}

/* ================= DARK MODE ================= */

body.dark{
    background:#111;
    color:white;
}

body.dark .topbar,
body.dark .help-card{
    background:#21573F;
}

body.dark .sidebar,
body.dark .side-card{
    background:#25785B;
}

body.dark .menu a.active,
body.dark .top-btn button,
body.dark .help-card button{
    background:#73D8B3;
}

body.dark input,
body.dark select,
body.dark textarea{
    background:#1f1f1f;
    color:white;
    border-color:#444;
}

body.dark .umur-wrap span{
    background:#444;
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

        <div class="top-btn">
            <button>About</button>
            <button>Setting</button>
            <button type="button" onclick="toggleDarkMode()">🌙 Mode</button>
        </div>

    </div>

    <!-- LAYOUT -->
    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <a href="#" class="profile">
                <div class="profile-icon">👤</div>
                <h2>Profil</h2>
            </a>

            <div class="menu">

                <a href="{{ url('/dashboard') }}">
                    🏠 Home
                </a>

                <a href="{{ route('skrining.index') }}" class="active">
                    🧾 Skrining Kesehatan Mental
                </a>

                <a href="#">
                    💬 Konsultasi Online
                </a>

                <a href="#">
                    📊 Pemantauan Kondisi Mental
                </a>

            </div>

            <!-- GAMBAR SIDEBAR -->
            <img 
                src="{{ asset('assets/images/sidebar.png') }}"
                class="sidebar-img"
                alt=""
            >

        </aside>

        <!-- CONTENT -->
        <main class="content">

            <!-- HERO -->
            <section class="hero">

                <div>
                    <h1>Daftar Tes Skrining Mental</h1>

                    <p>
                        Isi data diri dan riwayat kesehatan Anda<br>
                        sebelum memulai tes skrining
                    </p>
                </div>

                <img 
                    src="{{ asset('assets/images/otak.png') }}"
                    alt=""
                >

            </section>

            <!-- FORM -->
            <section class="form-area">

                <form action="#" method="POST">
                    @csrf

                    <!-- IDENTITAS -->
                    <div class="section-title">
                        <span class="round-icon">◎</span>
                        <span>1. Identitas Diri</span>
                    </div>

                    <div class="form-grid">

                        <div class="form-group">
                            <label>Nama Lengkap</label>

                            <input 
                                class="input-box"
                                type="text"
                                placeholder="Masukkan nama lengkap Anda"
                            >
                        </div>

                        <div class="form-group">
                            <label>Umur</label>

                            <div class="umur-wrap">

                                <input 
                                    class="input-box"
                                    type="number"
                                    placeholder="Masukkan umur anda"
                                >

                                <span>tahun</span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>

                            <select>
                                <option>Pilih jenis kelamin</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Email</label>

                            <input 
                                class="input-box"
                                type="email"
                                placeholder="Masukkan email Anda"
                            >
                        </div>

                    </div>

                    <!-- RIWAYAT -->
                    <div class="health">

                        <div class="section-title">
                            <span class="round-icon">◎</span>
                            <span>2. Riwayat Kesehatan</span>
                        </div>

                        <div class="health-grid">

                            <div class="form-group">

                                <label>
                                    Apakah Anda pernah mengalami gangguan kesehatan mental sebelumnya?
                                </label>

                                <div class="radio-group">
                                    <label><input type="radio"> Ya</label>
                                    <label><input type="radio"> Tidak</label>
                                </div>

                            </div>

                            <div class="form-group">

                                <label>
                                    Jika ya, sebutkan jenis gangguan yang pernah dialami
                                </label>

                                <input 
                                    class="input-box"
                                    type="text"
                                    placeholder="Contoh : Depresi, Kecemasan, Gangguan Panik"
                                >

                            </div>

                            <div class="form-group">

                                <label>
                                    Riwayat penyakit fisik yang pernah atau sedang Anda alami
                                </label>

                                <textarea 
                                    placeholder="Contoh : Hipertensi, Diabetes, Asma"
                                ></textarea>

                            </div>

                            <div class="form-group">

                                <label>
                                    Apakah Anda sedang mengonsumsi obat-obatan tertentu?
                                </label>

                                <div class="radio-group">
                                    <label><input type="radio"> Ya</label>
                                    <label><input type="radio"> Tidak</label>
                                </div>

                                <label style="margin-top:6px;">
                                    Jika ya, sebutkan obat yang dikonsumsi
                                </label>

                                <input 
                                    class="input-box"
                                    type="text"
                                    placeholder="Sebutkan nama obat"
                                >

                            </div>

                            <div class="form-group full">

                                <label>Catatan tambahan (opsional)</label>

                                <input 
                                    class="input-box"
                                    type="text"
                                    placeholder="Tuliskan hal lain yang menurut Anda penting"
                                >

                            </div>

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="submit-area">

                        <a href="{{ route('skrining.pilih-tes') }}" class="submit-btn">
    Klik Daftar Skrining
</a>

                        <div class="submit-note">
                            Pastikan semua data sudah benar sebelum klik daftar
                        </div>

                    </div>

                </form>

            </section>

            <!-- RIGHT SIDE -->
            <aside>

                <div class="side-card">

                    <h2>Informasi Penting</h2>

                    <p>
                        Data yang Anda berikan akan kami jaga kerahasiaannya
                        dan hanya digunakan untuk keperluan skrining kesehatan mental.
                    </p>

                    <hr>

                    <div class="info-row">
                        🔒 Data aman dan rahasia
                    </div>

                    <div class="info-row">
                        ✅ Hanya untuk keperluan skrining
                    </div>

                    <div class="info-row">
                        👤 Tidak akan dibagikan
                    </div>

                    <div class="info-row">
                        🗑️ Dapat dihapus kapan saja
                    </div>

                </div>

                <div class="help-card">

                    <h2>Butuh Bantuan Segera?</h2>

                    <p>
                        Kamu tidak sendiri, kami siap membantumu
                    </p>

                    <button>
                        Hubungi Psikolog
                    </button>

                </div>

            </aside>

        </main>

    </div>

</div>

<script>

function toggleDarkMode() {
    document.body.classList.toggle('dark');
}

</script>

</body>
</html>