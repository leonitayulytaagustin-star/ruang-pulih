@extends('layouts.dashboard', ['title' => 'Pemantauan Kondisi Mental'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4 p-4 bg-primary text-white rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2 fw-bold"><i class="fa-solid fa-chart-line me-2"></i> Pemantauan Kondisi Mental</h1>
        <p class="mb-3 opacity-75">Isi pertanyaan harian secara rutin untuk membantu memantau perkembangan kondisi mentalmu.</p>
        <a href="{{ route('pasien.pemantauan.riwayat') }}" class="btn btn-light bg-opacity-25 text-primary border-0 shadow-sm fw-bold rounded-pill px-4">
            <i class="fa-solid fa-clock-rotate-left me-2"></i> Lihat Riwayat Pemantauan
        </a>
    </div>
</section>

@if ($hariIni)
    <div class="card border-0 shadow-sm p-5 rounded-4 text-center">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 100px; height: 100px;">
            <i class="fa-solid fa-check-double fs-1"></i>
        </div>
        <h3 class="fw-bold text-dark mb-3">Pemantauan Hari Ini Selesai</h3>
        <p class="text-muted mb-4 fs-5" style="max-width: 600px; margin: 0 auto;">Terima kasih telah menyempatkan waktu untuk mengecek kondisi mentalmu. Kamu dapat melihat hasil dan perkembangan kondisi mental hari ini.</p>
        <div>
            <a class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-sm" href="{{ route('pasien.pemantauan.hasil', $hariIni) }}">
                Lihat Hasil Pemantauan <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
@else
    <form method="POST" action="{{ route('pasien.pemantauan.store') }}" id="pemantauanForm">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Progress Bar -->
                <div class="card border-0 shadow-sm p-3 mb-4 rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-primary" id="progressText">Pertanyaan 1 dari {{ count($pertanyaan) }}</span>
                        <span class="badge bg-primary bg-opacity-10 text-white rounded-pill px-3" id="progressPercentage">0%</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="progressBar" role="progressbar" style="width: 0%; transition: width 0.4s ease;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-4" id="questionsContainer">
                    @php $totalQuestions = count($pertanyaan); @endphp
                    @foreach ($pertanyaan as $index => $item)
                        <div class="card border-0 shadow-sm p-4 rounded-4 question-card" id="question-{{ $index }}" style="{{ $index > 0 ? 'display: none;' : '' }}">
                            <h4 class="fw-bold mb-4 text-dark" style="line-height: 1.4;">
                                <span class="text-primary me-2">{{ $loop->iteration }}.</span> {{ $item->pertanyaan }}
                            </h4>
                            
                            <div class="row g-3">
                                @foreach ([
                                    0 => ['Tidak Sama Sekali', 'fa-face-smile', 'text-success'], 
                                    1 => ['Ringan', 'fa-face-meh', 'text-primary'], 
                                    2 => ['Sedang', 'fa-face-frown', 'text-warning'], 
                                    3 => ['Sangat Berat', 'fa-face-sad-cry', 'text-danger']
                                ] as $nilai => [$label, $iconClass, $textColorClass])
                                    <div class="col-sm-6 col-md-3">
                                        <label class="answer-option d-flex flex-column align-items-center justify-content-center h-100 p-4 rounded-4 border-2 cursor-pointer transition-all bg-light hover-bg-white text-center" style="cursor: pointer;">
                                            <input type="radio" name="jawaban[{{ $item->id_pertanyaan_pemantauan }}]" value="{{ $nilai }}" class="d-none answer-radio" data-question-index="{{ $index }}" data-text-color="{{ $textColorClass }}" onchange="handleAnswerSelection(this)">
                                            <input type="hidden" name="emoji[{{ $item->id_pertanyaan_pemantauan }}]" value=":)">
                                            
                                            <i class="fa-regular {{ $iconClass }} fs-1 mb-3 opacity-50 text-secondary transition-all icon-state"></i>
                                            <strong class="d-block">{{ $label }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Keterangan Tambahan (Last Step) -->
                    <div class="card border-0 shadow-sm p-4 rounded-4 question-card" id="question-{{ $totalQuestions }}" style="display: none;">
                        <h4 class="fw-bold mb-4 text-dark" style="line-height: 1.4;">
                            <span class="text-primary me-2"><i class="fa-solid fa-pen-to-square"></i></span> Catatan Tambahan <span class="text-muted fw-normal fs-6">(Opsional)</span>
                        </h4>
                        <div class="mb-3">
                            <textarea class="form-control bg-light border-0 focus-ring-primary p-3" name="keterangan" rows="5" placeholder="Ceritakan lebih detail bagaimana perasaanmu hari ini, apa yang mengganggumu, atau progres apa yang telah kamu rasakan..."></textarea>
                        </div>
                    </div>

                    <div class="card border-0 p-3 shadow-sm bg-white sticky-bottom mt-2 d-flex flex-row justify-content-between align-items-center rounded-4" style="bottom: 20px; z-index: 10;">
                        <button type="button" class="btn btn-light fw-bold text-dark shadow-sm rounded-pill px-4" id="btnPrev" style="display: none;" onclick="navigateQuestion(-1)">
                            <i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya
                        </button>
                        
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary shadow-sm px-5 py-2 fw-bold rounded-pill" id="btnNext" onclick="navigateQuestion(1)" disabled>
                                Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                            
                            <button class="btn btn-success shadow-sm px-5 py-2 fw-bold rounded-pill" id="btnSubmit" type="submit" style="display: none;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pemantauan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif

<style>
    .transition-all { transition: all 0.2s ease; }
    .hover-bg-white:hover { background-color: #fff !important; border-color: #dee2e6 !important; }
    .focus-ring-primary:focus { box-shadow: 0 0 0 0.25rem rgba(0, 92, 52, 0.15) !important; outline: none; }
    
    /* Active State for Answer Options */
    .answer-option.active {
        background-color: var(--bs-primary-bg-subtle) !important;
        border-color: var(--primary-green) !important;
        box-shadow: 0 4px 12px rgba(0, 92, 52, 0.1) !important;
    }
    
    .answer-option.active .icon-state {
        opacity: 1 !important;
        transform: scale(1.1);
    }

    .answer-option.active strong {
        color: var(--primary-green);
    }
    
    .fade-enter-active { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@if (!$hariIni)
@push('scripts')
<script>
    const totalQuestions = {{ $totalQuestions }};
    const totalSteps = totalQuestions + 1; // Termasuk halaman catatan tambahan
    let currentIndex = 0;

    function updateUI() {
        const questionCards = document.querySelectorAll('.question-card');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        
        // Hide all
        questionCards.forEach(card => {
            card.style.display = 'none';
            card.classList.remove('fade-enter-active');
        });

        // Show current
        const currentCard = document.getElementById('question-' + currentIndex);
        if (currentCard) {
            currentCard.style.display = 'block';
            void currentCard.offsetWidth; // trigger reflow
            currentCard.classList.add('fade-enter-active');

            // Restore active state for previously selected radio in this card
            const selectedRadio = currentCard.querySelector('.answer-radio:checked');
            if (selectedRadio) {
                applyActiveState(selectedRadio);
            }
        }

        // Progress
        const answeredCount = document.querySelectorAll('.answer-radio:checked').length;
        const percent = Math.min(100, Math.round((answeredCount / totalQuestions) * 100));
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressPercentage').innerText = percent + '%';
        
        if (currentIndex < totalQuestions) {
            document.getElementById('progressText').innerText = `Pertanyaan ${currentIndex + 1} dari ${totalQuestions}`;
        } else {
            document.getElementById('progressText').innerText = `Catatan Tambahan`;
        }

        // Nav Buttons
        btnPrev.style.display = currentIndex > 0 ? 'inline-flex' : 'none';

        if (currentIndex === totalSteps - 1) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'inline-flex';
        } else {
            btnNext.style.display = 'inline-flex';
            btnSubmit.style.display = 'none';
            
            // Check if current question answered
            const isAnswered = currentCard && currentCard.querySelector('.answer-radio:checked');
            btnNext.disabled = !isAnswered;
        }
    }

    function applyActiveState(input) {
        const label = input.closest('.answer-option');
        const row = input.closest('.row');
        const textColor = input.dataset.textColor;

        // Reset all options in this question
        row.querySelectorAll('.answer-option').forEach(el => {
            el.classList.remove('active', 'border-primary', 'bg-primary', 'bg-opacity-10', 'shadow-sm');
            el.classList.add('border-light', 'bg-light');
            
            const icon = el.querySelector('i');
            icon.classList.remove('text-success', 'text-primary', 'text-warning', 'text-danger');
            icon.classList.add('opacity-50', 'text-secondary');
        });

        // Set active state
        label.classList.add('active');
        label.classList.remove('border-light', 'bg-light');
        
        const activeIcon = label.querySelector('i');
        activeIcon.classList.remove('opacity-50', 'text-secondary');
        activeIcon.classList.add(textColor);
    }

    window.handleAnswerSelection = function(input) {
        applyActiveState(input);
        updateUI();
    }

    function navigateQuestion(step) {
        const newIndex = currentIndex + step;

        if (newIndex < 0 || newIndex >= totalSteps) {
            return;
        }

        if (step > 0 && currentIndex < totalQuestions) {
            const currentCard = document.getElementById('question-' + currentIndex);
            const isAnswered = currentCard && currentCard.querySelector('.answer-radio:checked');

            if (!isAnswered) {
                return;
            }
        }

        currentIndex = newIndex;
        updateUI();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateSubmit(event) {
        event.preventDefault();
        const answeredCount = document.querySelectorAll('.answer-radio:checked').length;
        
        if (answeredCount < totalQuestions) {
            Swal.fire({
                icon: 'warning',
                title: 'Belum Selesai',
                text: 'Harap jawab seluruh pertanyaan pemantauan.',
                confirmButtonColor: '#005c34',
            });
            return false;
        }

        Swal.fire({
            title: 'Kirim Pemantauan?',
            text: "Data ini akan membantu memantau kondisi mentalmu.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#005c34',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('pemantauanForm').submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateUI();
        
        const form = document.getElementById('pemantauanForm');
        if (form) {
            form.addEventListener('submit', validateSubmit);
        }
    });
</script>
@endpush
@endif
@endsection
