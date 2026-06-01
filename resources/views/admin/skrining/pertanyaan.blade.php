@extends('layouts.dashboard', ['title' => 'Kelola Pertanyaan Skrining'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-list-check me-2"></i> {{ $skrining->nama_skrining }}</h1>
        <p class="mb-0">Kelola pertanyaan dan pilihan jawaban untuk <strong>{{ $skrining->jenis_penyakit }}</strong>.</p>
    </div>
    <a href="{{ route('admin.skrining.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<form action="{{ route('admin.skrining.pertanyaan.update', $skrining) }}" method="POST">
    @csrf @method('PUT')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fa-solid fa-clipboard-list text-primary me-2"></i> Daftar Pertanyaan</h4>
        <button class="btn btn-primary shadow-sm" type="button" onclick="addQuestion()">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pertanyaan
        </button>
    </div>

    <div id="question-list">
        @forelse ($skrining->pertanyaan as $qIndex => $pertanyaan)
            @include('admin.skrining.partials.question-row', ['qIndex' => $qIndex, 'pertanyaan' => $pertanyaan])
        @empty
            @include('admin.skrining.partials.question-row', ['qIndex' => 0, 'pertanyaan' => null])
        @endforelse
    </div>

    <div class="card border-0 p-3 shadow-sm bg-white sticky-bottom mb-4 d-flex justify-content-end" style="bottom: 20px; z-index: 10;">
        <button class="btn btn-success shadow-sm px-4 fw-bold" type="submit">
            <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Semua Pertanyaan
        </button>
    </div>
</form>

<template id="question-template">
    @include('admin.skrining.partials.question-row', ['qIndex' => '__INDEX__', 'pertanyaan' => null])
</template>

@push('scripts')
<script>
let questionIndex = document.querySelectorAll('.question-row').length;
function addQuestion() {
    const html = document.getElementById('question-template').innerHTML.replaceAll('__INDEX__', questionIndex);
    document.getElementById('question-list').insertAdjacentHTML('beforeend', html);
    questionIndex++;
}
function addAnswer(button) {
    const wrap = button.closest('.question-row').querySelector('.answer-list');
    const qIndex = button.closest('.question-row').dataset.index;
    const aIndex = wrap.querySelectorAll('.answer-row').length;
    wrap.insertAdjacentHTML('beforeend', `
        <div class="answer-row row g-2 mb-2 align-items-center">
            <input type="hidden" name="pertanyaan[${qIndex}][jawaban][${aIndex}][id]">
            <div class="col-md-9">
                <input class="form-control bg-light border-0" name="pertanyaan[${qIndex}][jawaban][${aIndex}][teks]" placeholder="Teks Jawaban" required>
            </div>
            <div class="col-md-3">
                <input class="form-control bg-light border-0" type="number" min="0" name="pertanyaan[${qIndex}][jawaban][${aIndex}][nilai]" placeholder="Nilai" required>
            </div>
        </div>
    `);
}
</script>
@endpush
@endsection
