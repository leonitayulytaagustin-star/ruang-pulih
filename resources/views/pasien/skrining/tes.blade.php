@extends('layouts.dashboard', ['title' => 'Tes Skrining'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-file-signature me-2"></i> {{ $skrining->nama_skrining }}</h1>
        <p class="mb-0 opacity-75">{{ $skrining->deskripsi }}</p>
    </div>
    <a href="{{ route('pasien.skrining.pilih') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-none fw-bold" style="position: relative; z-index: 2;" onclick="confirmDelete(event, 'Yakin ingin membatalkan tes? Jawaban Anda tidak akan disimpan.')">
        <i class="fa-solid fa-arrow-left me-1"></i> Batal Tes
    </a>
</section>

<form method="POST" action="{{ route('pasien.skrining.submit', $skrining) }}" id="skriningForm">
    @csrf
    <div class="row g-4">
        <!-- Main Quiz Area -->
        <div class="col-lg-8">
            <!-- Progress Bar -->
            <div class="card border-0 shadow-sm p-3 mb-4 rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-primary" id="progressText">Pertanyaan 1 dari {{ $skrining->pertanyaan->count() }}</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3" id="progressPercentage">0%</span>
                </div>
                <div class="progress" style="height: 10px; border-radius: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="progressBar" role="progressbar" style="width: 0%; transition: width 0.4s ease;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="d-flex flex-column gap-4" id="questionsContainer">
                @php $totalQuestions = $skrining->pertanyaan->count(); @endphp
                @foreach ($skrining->pertanyaan as $index => $pertanyaan)
                    <div class="card border-0 shadow-sm p-4 rounded-4 question-card" id="question-{{ $index }}" style="{{ $index > 0 ? 'display: none;' : '' }}">
                        <h5 class="fw-bold mb-4 text-dark" style="line-height: 1.4;">
                            <span class="text-primary me-1">{{ $loop->iteration }}.</span> {{ $pertanyaan->pertanyaan }}
                        </h5>
                        
                        <div class="row g-3">
                            @foreach ($pertanyaan->jawaban as $jawaban)
                                <div class="col-sm-6">
                                    <label class="answer-option d-block h-100 p-3 rounded-4 border border-2 cursor-pointer transition-all bg-light" style="cursor: pointer;">
                                        <input type="radio" name="jawaban[{{ $pertanyaan->id_pertanyaan }}]" value="{{ $jawaban->id_jawaban }}" class="d-none answer-radio" data-question-index="{{ $index }}" onchange="this.closest('.row').querySelectorAll('.answer-option').forEach(el => { el.classList.remove('border-primary', 'bg-primary'); el.classList.add('border-light', 'bg-light'); let span = el.querySelector('span'); span.classList.remove('text-white'); span.classList.add('text-dark'); }); this.closest('.answer-option').classList.remove('border-light', 'bg-light'); this.closest('.answer-option').classList.add('border-primary', 'bg-primary'); let selectedSpan = this.closest('.answer-option').querySelector('span'); selectedSpan.classList.remove('text-dark'); selectedSpan.classList.add('text-white'); handleAnswerSelection();">
                                        <div class="d-flex align-items-center gap-2 h-100">
                                            <div class="radio-custom rounded-circle border border-2 d-flex align-items-center justify-content-center flex-shrink-0 bg-white" style="width: 20px; height: 20px;">
                                                <div class="radio-dot rounded-circle d-none" style="width: 10px; height: 10px; background-color: var(--primary-green);"></div>
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $jawaban->teks_jawaban }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <div class="card border-0 p-3 shadow-sm bg-white sticky-bottom mt-2 d-flex flex-row justify-content-between align-items-center rounded-4" style="bottom: 20px; z-index: 10;">
                    <button type="button" class="btn btn-light fw-bold text-dark shadow-sm rounded-pill px-4" id="btnPrev" style="display: none;" onclick="navigateQuestion(-1)">
                        <i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya
                    </button>
                    
                    <div class="ms-auto">
                        <button type="button" class="btn btn-primary shadow-sm px-5 py-2 fw-bold rounded-pill" id="btnNext" onclick="navigateQuestion(1)" disabled>
                            Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                        
                        <button class="btn btn-success shadow-sm px-5 py-2 fw-bold rounded-pill" id="btnSubmit" type="submit" style="display: none;">
                            <i class="fa-solid fa-paper-plane me-2"></i> Kirim & Simpan Hasil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info Area -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4 sticky-top" style="top: 20px;">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-primary text-white border-start border-white border-4">
                    <h5 class="fw-bold mb-3 text-white"><i class="fa-solid fa-circle-info me-2"></i> Informasi Tes</h5>
                    <p class="text-white opacity-75 small mb-0" style="line-height: 1.6;">
                        Jawablah setiap pertanyaan sesuai dengan kondisi yang <strong>benar-benar kamu rasakan</strong> akhir-akhir ini. Anda harus menjawab pertanyaan saat ini sebelum dapat melanjutkan ke pertanyaan berikutnya.
                    </p>
                </div>
                
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-book-open text-primary me-2"></i> Panduan Pengisian</h5>
                    <p class="text-muted small mb-0" style="white-space: pre-line; line-height: 1.6;">{{ $skrining->panduan_pengelolaan }}</p>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .transition-all { transition: all 0.2s ease; }
    
    /* Inactive State Hover */
    .answer-option:not(.bg-primary):hover { background-color: #fff !important; border-color: #dee2e6 !important; }
    
    /* Active/Checked State (Prevents hover overriding white text) */
    .answer-option.bg-primary:hover { background-color: var(--primary-green) !important; border-color: var(--primary-green) !important; }
    .answer-option.bg-primary:hover span { color: white !important; }

    .answer-option input:checked ~ div .radio-custom { border-color: var(--primary-green) !important; }
    .answer-option input:checked ~ div .radio-custom .radio-dot { display: block !important; }
    
    .fade-enter-active { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@push('scripts')
<script>
    const totalQuestions = {{ $totalQuestions }};
    let currentIndex = 0;

    function updateUI() {
        // Hide all questions
        document.querySelectorAll('.question-card').forEach(card => {
            card.style.display = 'none';
            card.classList.remove('fade-enter-active');
        });

        // Show current question with animation
        const currentCard = document.getElementById('question-' + currentIndex);
        if (currentCard) {
            currentCard.style.display = 'block';
            // Trigger reflow to restart animation
            void currentCard.offsetWidth;
            currentCard.classList.add('fade-enter-active');
        }

        // Update progress bar
        const answeredCount = document.querySelectorAll('.answer-radio:checked').length;
        const percent = Math.round((answeredCount / totalQuestions) * 100);
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressPercentage').innerText = percent + '%';
        document.getElementById('progressText').innerText = `Pertanyaan ${currentIndex + 1} dari ${totalQuestions}`;

        // Manage buttons visibility
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');

        btnPrev.style.display = currentIndex > 0 ? 'inline-flex' : 'none';

        const currentAnswered = document.querySelector(`input[name="jawaban[${currentCard.querySelector('.answer-radio').name.match(/\[(\d+)\]/)[1]}]"]:checked`);
        
        if (currentIndex === totalQuestions - 1) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'inline-flex';
            btnSubmit.disabled = !currentAnswered;
        } else {
            btnNext.style.display = 'inline-flex';
            btnSubmit.style.display = 'none';
            btnNext.disabled = !currentAnswered;
        }
    }

    function navigateQuestion(step) {
        const newIndex = currentIndex + step;
        if (newIndex >= 0 && newIndex < totalQuestions) {
            currentIndex = newIndex;
            updateUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function handleAnswerSelection() {
        updateUI();
        // Auto-advance after short delay if not the last question
        if (currentIndex < totalQuestions - 1) {
            setTimeout(() => {
                navigateQuestion(1);
            }, 400); // 400ms delay for better UX
        }
    }

    function validateSubmit(event) {
        event.preventDefault();
        const answeredCount = document.querySelectorAll('.answer-radio:checked').length;
        
        if (answeredCount < totalQuestions) {
            Swal.fire({
                icon: 'warning',
                title: 'Belum Selesai',
                text: 'Harap jawab seluruh pertanyaan sebelum mengirim hasil tes.',
                confirmButtonColor: '#005c34',
            });
            return false;
        }

        Swal.fire({
            title: 'Sudah Yakin?',
            text: "Pastikan semua jawaban Anda sudah sesuai dengan kondisi Anda.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#005c34',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim Hasil',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', function() {
        updateUI();
        
        const form = document.getElementById('skriningForm');
        if (form) {
            form.addEventListener('submit', validateSubmit);
        }
    });
</script>
@endpush
@endsection
