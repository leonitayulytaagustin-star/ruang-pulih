<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tes Anxiety - Ruang Pulih</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}
html,body{width:100%;height:100%;overflow:hidden;background:#F6FCF8}
body.dark{background:#111;color:white}
.page{height:100vh;padding:10px}

.topbar{height:64px;background:#4E946D;border-radius:8px;display:flex;align-items:center;justify-content:space-between;padding:0 22px}
.logo{display:flex;align-items:center;gap:14px;color:white}
.logo img{width:46px;height:46px;border-radius:50%;background:white;padding:5px}
.logo h1{font-size:30px}
.top-buttons{display:flex;gap:14px}
.top-buttons button{width:110px;height:38px;border:none;border-radius:10px;background:#B8EFC7;font-weight:bold;cursor:pointer}

.layout{height:calc(100vh - 72px);margin-top:6px;display:grid;grid-template-columns:310px 1fr;gap:10px}
.sidebar{background:#73D7B3;border-radius:10px;padding:14px;position:relative;overflow:hidden}
.profile-box{height:170px;background:rgba(255,255,255,.12);border-radius:14px;display:flex;flex-direction:column;justify-content:center;align-items:center}
.profile-box .icon{font-size:58px}
.profile-box h2{margin-top:8px;font-size:28px}
.menu{margin-top:18px}
.menu a{height:52px;border-radius:10px;display:flex;align-items:center;gap:14px;padding:0 18px;text-decoration:none;color:#000;font-size:14px;margin-bottom:10px}
.menu a.active{background:#B8EFC7}
.sidebar-image{position:absolute;bottom:22px;left:50%;transform:translateX(-50%);width:215px}

.content{display:grid;grid-template-rows:158px 1fr;gap:8px}
.hero{background:linear-gradient(90deg,#2E8B57,#58D0A7);border-radius:12px;color:white;padding:22px 26px;display:flex;align-items:center;justify-content:space-between}
.breadcrumb{font-size:14px;margin-bottom:20px;display:flex;gap:18px;align-items:center}
.hero h1{font-size:34px;margin-bottom:8px}
.hero p{font-size:15px;line-height:1.45}
.hero img{height:155px;object-fit:contain;margin-right:120px}

.test-area{display:grid;grid-template-columns:1fr 310px;gap:16px}
.question-box{padding:8px 0 0}
.progress-text{font-size:14px;font-weight:700;margin:0 0 14px 6px}
.progress-wrap{height:8px;background:#eee;border-radius:10px;margin:0 6px 22px;position:relative}
.progress-bar{height:100%;width:5%;background:#2E7D50;border-radius:10px}
.percent{position:absolute;right:0;top:-18px;font-size:13px}

.question-title{background:#B8EFC7;border-radius:12px;padding:20px;font-size:28px;font-weight:800;margin-bottom:16px}
.option{height:40px;border:1px solid #d0c7c7;border-radius:8px;display:flex;align-items:center;padding:0 18px;margin-bottom:12px;cursor:pointer;background:white;font-size:14px}
.option.active{border:2px solid #2E7D50;background:#E9FFF0;font-weight:700}

.nav-row{display:flex;justify-content:space-between;margin-top:16px}
.nav-btn{height:40px;border-radius:9px;border:1px solid #d0c7c7;background:white;padding:0 18px;font-size:17px;cursor:pointer;display:flex;align-items:center;gap:12px}
.next-btn{background:#2E7D50;color:white;border:none;margin-left:auto}
.next-btn span,.nav-btn span{font-size:30px;line-height:1}

.tips{height:105px;background:#58D0A7;border-radius:12px;margin-top:18px;padding:18px;display:flex;gap:18px;align-items:flex-start}
.tips h3{font-size:22px;margin-bottom:18px}
.tips p{font-size:18px;line-height:1.3}

.side-panel{display:flex;flex-direction:column;gap:20px}
.info-card,.guide-card{background:#F0EFF7;border-radius:12px;padding:18px}
.info-card h3,.guide-card h3{font-size:17px;margin-bottom:18px}
.info-card p{font-size:12px;line-height:1.35;margin-bottom:14px}
.info-row{display:flex;justify-content:space-between;font-size:13px;margin-top:14px}
.guide-item{display:flex;gap:12px;margin:15px 0;font-size:12px;line-height:1.25}

.result-box{display:none;background:#B8EFC7;border-radius:12px;padding:22px;margin-top:14px}
.result-box h2{font-size:24px;margin-bottom:12px}
.result-box p{font-size:16px;line-height:1.4}

body.dark .topbar{background:#1F5C3E}
body.dark .sidebar{background:#22684F}
body.dark .menu a{color:white}
body.dark .menu a.active,.dark .top-buttons button{background:#84D9B6;color:black}
body.dark .option,.dark .nav-btn{background:#1f1f1f;color:white;border-color:#444}
body.dark .option.active{background:#244b37;border-color:#73D8B3}
body.dark .info-card,.dark .guide-card{background:#222}
body.dark .tips{background:#25785B}
body.dark .question-title,.dark .result-box{background:#25785B;color:white}
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
                    <div class="breadcrumb">
                        <span>↩</span>
                        <span>Pilih Tes</span>
                        <span>&gt;</span>
                        <span>Gangguan Kecemasan (Anxiety)</span>
                    </div>

                    <h1>Gangguan Kecemasan (Anxiety)</h1>

                    <p>
                        Jawablah pertanyaan berikut sesuai dengan kondisi<br>
                        yang Anda alami dalam 2 minggu terakhir.
                    </p>
                </div>

                <img src="{{ asset('assets/images/enxiety.png') }}">
            </section>

            <section class="test-area">
                <div class="question-box">
                    <div class="progress-text" id="progressText">Pertanyaan 1 dari 20</div>

                    <div class="progress-wrap">
                        <div class="progress-bar" id="progressBar"></div>
                        <div class="percent" id="percentText">5%</div>
                    </div>

                    <div class="question-title" id="questionText">
                        1. Saya merasa gugup, cemas, atau tegang.
                    </div>

                    <div class="option" onclick="selectAnswer(0, this)">1. Tidak Pernah</div>
                    <div class="option" onclick="selectAnswer(1, this)">2. Jarang</div>
                    <div class="option" onclick="selectAnswer(2, this)">3. Sering</div>
                    <div class="option" onclick="selectAnswer(3, this)">4. Sangat sering</div>

                    <div class="result-box" id="resultBox">
                        <h2 id="resultTitle"></h2>
                        <p id="resultDesc"></p>
                    </div>

                    <div class="nav-row">
                        <button class="nav-btn" type="button" onclick="prevQuestion()">
                            <span>←</span> Sebelumnya
                        </button>

                        <button class="nav-btn next-btn" type="button" onclick="nextQuestion()" id="nextBtn">
                            Selanjutnya <span>→</span>
                        </button>
                    </div>

                    <div class="tips">
                        <div class="tips-icon">💡</div>
                        <div>
                            <h3>Tips</h3>
                            <p>Jawablah sesuai dengan kondisi Anda yang sebenarnya. Ini akan membantu memberikan hasil yang lebih akurat.</p>
                        </div>
                    </div>
                </div>

                <aside class="side-panel">
                    <div class="info-card">
                        <h3>ⓘ Informasi Tes</h3>
                        <p>Tes ini digunakan untuk mengetahui tingkat kecemasan yang Anda alami dalam 2 minggu terakhir.</p>
                        <hr>
                        <div class="info-row"><span>Jumlah Pertanyaan</span><strong>20</strong></div>
                        <div class="info-row"><span>Estimasi Waktu</span><strong>5-10 menit</strong></div>
                        <div class="info-row"><span>Selesai Dijawab</span><strong id="doneCount">0/20</strong></div>
                    </div>

                    <div class="guide-card">
                        <h3>ℹ Petunjuk</h3>
                        <hr>
                        <div class="guide-item">ⓐ Jawab semua pertanyaan dengan jujur</div>
                        <div class="guide-item">ⓐ Pilih jawaban yang paling sesuai dengan kondisi Anda</div>
                        <div class="guide-item">ⓐ Tidak ada jawaban benar atau salah</div>
                        <div class="guide-item">ⓐ Hasil tes bersifat rahasia dan hanya untuk Anda</div>
                    </div>
                </aside>
            </section>
        </main>
    </div>
</div>

<script>
const questions = [
    "Saya merasa gugup, cemas, atau tegang.",
    "Saya merasa sulit mengendalikan rasa khawatir.",
    "Saya terlalu sering mengkhawatirkan banyak hal.",
    "Saya sulit merasa rileks atau tenang.",
    "Saya merasa gelisah hingga sulit diam.",
    "Saya mudah merasa kesal atau tersinggung.",
    "Saya merasa takut seolah-olah sesuatu yang buruk akan terjadi.",
    "Saya merasa jantung berdebar saat sedang cemas.",
    "Saya merasa sulit bernapas saat merasa panik.",
    "Saya sulit tidur karena pikiran yang mengganggu.",
    "Saya merasa sulit berkonsentrasi karena kecemasan.",
    "Saya menghindari situasi tertentu karena takut atau cemas.",
    "Saya merasa tubuh tegang saat menghadapi masalah.",
    "Saya merasa panik tanpa alasan yang jelas.",
    "Saya sering membayangkan hal buruk akan terjadi.",
    "Saya merasa tidak nyaman berada di tempat ramai.",
    "Saya merasa cemas ketika harus berbicara dengan orang lain.",
    "Saya merasa takut gagal secara berlebihan.",
    "Saya merasa kecemasan mengganggu aktivitas harian.",
    "Saya merasa membutuhkan bantuan untuk mengelola kecemasan."
];

let current = 0;
let answers = Array(20).fill(null);

function toggleDarkMode(){
    document.body.classList.toggle('dark');
}

function selectAnswer(score, element){
    answers[current] = score;

    document.querySelectorAll('.option').forEach(opt => {
        opt.classList.remove('active');
    });

    element.classList.add('active');
    updateInfo();
}

function updateQuestion(){
    document.getElementById('questionText').innerText =
        (current + 1) + ". " + questions[current];

    document.getElementById('progressText').innerText =
        "Pertanyaan " + (current + 1) + " dari 20";

    let percent = Math.round(((current + 1) / 20) * 100);
    document.getElementById('progressBar').style.width = percent + "%";
    document.getElementById('percentText').innerText = percent + "%";

    document.querySelectorAll('.option').forEach((opt, index) => {
        opt.classList.remove('active');
        if(answers[current] === index){
            opt.classList.add('active');
        }
    });

    document.getElementById('nextBtn').innerHTML =
        current === 19 ? 'Lihat Hasil <span>→</span>' : 'Selanjutnya <span>→</span>';
}

function updateInfo(){
    const done = answers.filter(answer => answer !== null).length;
    document.getElementById('doneCount').innerText = done + "/20";
}

function nextQuestion(){
    if(answers[current] === null){
        alert("Pilih jawaban terlebih dahulu ya.");
        return;
    }

    if(current < 19){
        current++;
        updateQuestion();
    } else {
        showResult();
    }
}

function prevQuestion(){
    if(current > 0){
        current--;
        updateQuestion();
    }
}

function showResult(){
    const total = answers.reduce((sum, value) => sum + value, 0);
    let title = "";
    let desc = "";

    if(total <= 15){
        title = "Hasil: Kecemasan Ringan";
        desc = "Skor kamu " + total + ". Kecemasan masih tergolong ringan. Tetap jaga pola tidur, istirahat, dan lakukan aktivitas yang menenangkan.";
    } else if(total <= 30){
        title = "Hasil: Kecemasan Sedang";
        desc = "Skor kamu " + total + ". Kamu menunjukkan tanda kecemasan sedang. Cobalah mengelola stres dan pertimbangkan untuk berkonsultasi jika mengganggu aktivitas.";
    } else if(total <= 45){
        title = "Hasil: Kecemasan Tinggi";
        desc = "Skor kamu " + total + ". Tingkat kecemasan cukup tinggi. Disarankan untuk berbicara dengan psikolog atau tenaga profesional.";
    } else {
        title = "Hasil: Kecemasan Sangat Tinggi";
        desc = "Skor kamu " + total + ". Kamu sangat disarankan mencari bantuan profesional agar mendapatkan dukungan yang tepat.";
    }

    document.getElementById('resultTitle').innerText = title;
    document.getElementById('resultDesc').innerText = desc;
    document.getElementById('resultBox').style.display = "block";
}
</script>

</body>
</html>