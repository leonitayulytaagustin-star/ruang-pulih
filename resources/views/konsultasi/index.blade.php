<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Konsultasi Online - Ruang Pulih</title>
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
    height:62px;
    background:#2E7D50;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 22px;
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

.layout{
    height:calc(100vh - 76px);
    display:grid;
    grid-template-columns:310px 1fr;
    gap:10px;
    margin-top:8px;
}

.sidebar{
    background:#76D7B6;
    border-radius:10px;
    padding:18px 16px;
    position:relative;
    overflow:hidden;
}

.profile{
    height:150px;
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
    bottom:10px;
    left:50%;
    transform:translateX(-50%);
    width:225px;
}

.content{
    display:grid;
    grid-template-rows:145px 1fr;
    gap:14px;
}

.hero{
    background:linear-gradient(90deg,#2E8B57,#58D0A7);
    border-radius:10px;
    color:white;
    padding:26px 38px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.hero h1{
    font-size:38px;
    margin-bottom:12px;
}

.hero p{
    font-size:18px;
    line-height:1.25;
}

.hero img{
    width:200px;
    height:120px;
    object-fit:contain;
    margin-right:55px;
}

.form-title{
    font-size:18px;
    margin:0 0 18px 30px;
}

.form-section{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:90px;
    padding:0 55px 0 45px;
}

.form-group{
    margin-bottom:16px;
}

.form-group label{
    display:block;
    font-size:17px;
    font-weight:700;
    margin-bottom:8px;
}

.form-control,
select,
textarea{
    width:100%;
    height:46px;
    border:1px solid #d0c7c7;
    border-radius:8px;
    padding:0 22px;
    font-size:16px;
    outline:none;
    background:white;
}

textarea{
    height:135px;
    padding:22px;
    resize:none;
    line-height:1.25;
}

.form-control::placeholder,
textarea::placeholder{
    color:#aaa;
}

.checkbox-row{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin-top:28px;
    font-size:17px;
    line-height:1.25;
}

.checkbox-row input{
    width:32px;
    height:32px;
    accent-color:#76D7B6;
    cursor:pointer;
    flex-shrink:0;
}

.checkbox-row a{
    color:#006334;
    text-decoration:none;
    font-weight:700;
}

.action-row{
    display:flex;
    justify-content:flex-end;
    margin-top:70px;
}

.next-btn{
    width:230px;
    height:48px;
    border:none;
    border-radius:11px;
    background:#2E7D50;
    color:white;
    font-size:16px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:22px;
    text-decoration:none;
}

.next-btn span{
    font-size:30px;
}

body.dark .topbar,
body.dark .next-btn{
    background:#1F5C3E;
}

body.dark .sidebar{
    background:#22684F;
}

body.dark .menu a{
    color:white;
}

body.dark .menu a.active,
body.dark .top-btn button{
    background:#84D9B6;
    color:#000;
}

body.dark .form-control,
body.dark select,
body.dark textarea{
    background:#1f1f1f;
    color:white;
    border-color:#444;
}

body.dark .checkbox-row a{
    color:#84D9B6;
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

        <div class="top-btn">
            <button>About</button>
            <button>Setting</button>
            <button type="button" onclick="toggleDarkMode()">🌙 Mode</button>
        </div>
    </div>

    <div class="layout">

        <aside class="sidebar">
            <a href="#" class="profile">
                <div class="profile-icon">👤</div>
                <h2>Profil</h2>
            </a>

            <div class="menu">
                <a href="{{ url('/dashboard') }}">🏠 Home</a>
                <a href="{{ route('skrining.index') }}">🧾 Skrining Kesehatan Mental</a>
                <a href="{{ route('konsultasi.index') }}" class="active">💬 Konsultasi Online</a>
                <a href="#">📊 Pemantauan Kondisi Mental</a>
            </div>

            <img src="{{ asset('assets/images/sidebar.png') }}" class="sidebar-img">
        </aside>

        <main class="content">

            <section class="hero">
                <div>
                    <h1>Pendaftaran Konsultasi Online</h1>
                    <p>
                        Langkah sederhana untuk mulai peduli pada<br>
                        kesehatan mentalmu
                    </p>
                </div>

                <img src="{{ asset('assets/images/otak.png') }}" alt="">
            </section>

            <section>
                <h2 class="form-title">
                    Lengkapi data dibawah ini untuk memulai konsultasi
                </h2>

                <form action="#" method="POST">
                    @csrf

                    <div class="form-section">

                        <div class="left-form">

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama lengkap Anda">
                            </div>

                            <div class="form-group">
                                <label>Umur</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur anda">
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
                                <label>Nomor HP</label>
                                <input type="text" class="form-control" placeholder="Masukkan nomor HP anda">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Masukkan email anda">
                            </div>

                        </div>

                        <div class="right-form">

                            <div class="form-group">
                                <label>Keluhan</label>
                                <textarea placeholder="Saya sering merasa cemas berlebihan, dan sulit tidur, dan overthinking tentang banyak hal. Saya ingin belajar cara mengelola pikiran dan emosi saya."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tingkat urgensi</label>
                                <select>
                                    <option>Sedang</option>
                                    <option>Rendah</option>
                                    <option>Tinggi</option>
                                    <option>Sangat Mendesak</option>
                                </select>
                            </div>

                            <div class="checkbox-row">
                                <input type="checkbox" id="setuju">

                                <label for="setuju">
                                    Saya menyetujui
                                    <a href="#">Syarat & Ketentuan</a>
                                    serta
                                    <a href="#">Kebijakan Privasi</a>
                                    yang berlaku
                                </label>
                            </div>

                            <div class="action-row">
                                <a href="#" class="next-btn" onclick="return cekSetuju()">
                                    Lanjut Pilih Psikologi <span>→</span>
                                </a>
                            </div>

                        </div>

                    </div>

                </form>
            </section>

        </main>

    </div>

</div>

<script>
function toggleDarkMode(){
    document.body.classList.toggle('dark');
}

function cekSetuju(){
    const cek = document.getElementById('setuju');

    if(!cek.checked){
        alert('Centang persetujuan terlebih dahulu ya.');
        return false;
    }

    return true;
}
</script>

</body>
</html>