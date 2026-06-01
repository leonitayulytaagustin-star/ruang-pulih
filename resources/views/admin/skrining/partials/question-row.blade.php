<div class="question-row card border-0 p-4 mb-4 shadow-sm" data-index="{{ $qIndex }}">
    <input type="hidden" name="pertanyaan[{{ $qIndex }}][id]" value="{{ $pertanyaan?->id_pertanyaan }}">
    <div class="mb-3">
        <label class="form-label fw-bold"><i class="fa-solid fa-circle-question text-primary me-2"></i> Pertanyaan {{ (int)$qIndex + 1 }}</label>
        <textarea class="form-control bg-light border-0" name="pertanyaan[{{ $qIndex }}][teks]" rows="2" required>{{ $pertanyaan?->pertanyaan }}</textarea>
    </div>
    
    <div class="answer-list">
        @php $answers = $pertanyaan?->jawaban ?? collect(); @endphp
        @forelse ($answers as $aIndex => $jawaban)
            <div class="answer-row row g-2 mb-2 align-items-center">
                <input type="hidden" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][id]" value="{{ $jawaban->id_jawaban }}">
                <div class="col-md-9">
                    <input class="form-control bg-light border-0" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][teks]" value="{{ $jawaban->teks_jawaban }}" placeholder="Teks Jawaban" required>
                </div>
                <div class="col-md-3">
                    <input class="form-control bg-light border-0" type="number" min="0" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][nilai]" value="{{ $jawaban->nilai_jawaban }}" placeholder="Nilai" required>
                </div>
            </div>
        @empty
            @foreach ([0, 1] as $aIndex)
                <div class="answer-row row g-2 mb-2 align-items-center">
                    <input type="hidden" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][id]">
                    <div class="col-md-9">
                        <input class="form-control bg-light border-0" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][teks]" placeholder="Teks Jawaban" required>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control bg-light border-0" type="number" min="0" name="pertanyaan[{{ $qIndex }}][jawaban][{{ $aIndex }}][nilai]" placeholder="Nilai" required>
                    </div>
                </div>
            @endforeach
        @endforelse
    </div>
    <div class="mt-2 text-end">
        <button class="btn btn-sm btn-secondary border-0 bg-light text-dark shadow-sm" type="button" onclick="addAnswer(this)">
            <i class="fa-solid fa-plus me-1"></i> Tambah Jawaban
        </button>
    </div>
</div>
