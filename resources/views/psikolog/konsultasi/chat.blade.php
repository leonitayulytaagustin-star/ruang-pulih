@extends('layouts.dashboard', ['title' => 'Chat Konsultasi'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-comments me-2"></i> Chat Konsultasi</h1>
        <p class="mb-0">Dengan <strong>{{ $konsultasi->pasien->user->nama_lengkap }}</strong> - <span class="badge bg-light bg-opacity-25 text-white px-2 py-1 text-capitalize">{{ str_replace('_', ' ', $konsultasi->status_konsultasi) }}</span></p>
    </div>
    <a href="{{ route('psikolog.konsultasi.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm d-flex flex-column" style="height: 600px;">
            <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $konsultasi->pasien->user->nama_lengkap }}</h6>
                        <small class="text-success"><i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>Online</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body bg-light overflow-auto p-4 d-flex flex-column gap-3" style="flex: 1;">
                @forelse ($konsultasi->chat as $chat)
                    @if ($chat->id_pengirim === auth()->id())
                        <div class="d-flex flex-column align-items-end">
                            <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px;">
                                <p class="mb-1">{{ $chat->pesan }}</p>
                                @if ($chat->file_lampiran)
                                    <div class="mt-2 p-2 bg-white bg-opacity-25 rounded-3">
                                        <a href="{{ asset('storage/'.$chat->file_lampiran) }}" target="_blank" class="text-white text-decoration-none d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-paperclip"></i> Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted mt-1" style="font-size: 0.75rem;">{{ optional($chat->waktu_kirim)->format('H.i') }}</small>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-start">
                            <div class="bg-white border p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-left-radius: 4px;">
                                <strong class="d-block mb-1 text-primary small">{{ $chat->pengirim->nama_lengkap }}</strong>
                                <p class="mb-1 text-dark">{{ $chat->pesan }}</p>
                                @if ($chat->file_lampiran)
                                    <div class="mt-2 p-2 bg-light rounded-3 border">
                                        <a href="{{ asset('storage/'.$chat->file_lampiran) }}" target="_blank" class="text-primary text-decoration-none d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-paperclip"></i> Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted mt-1" style="font-size: 0.75rem;">{{ optional($chat->waktu_kirim)->format('H.i') }}</small>
                        </div>
                    @endif
                @empty
                    <div class="m-auto text-center text-muted">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-3 mx-auto d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-comments fs-2 text-primary opacity-50"></i>
                        </div>
                        <p class="mb-0">Belum ada pesan. Mulai percakapan sekarang.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="card-footer bg-white border-top p-3">
                <form method="POST" enctype="multipart/form-data" action="{{ route('psikolog.konsultasi.chat.send', $konsultasi) }}">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="file_lampiran" class="form-control d-none" id="file_lampiran">
                        <label class="input-group-text bg-light border text-muted cursor-pointer" for="file_lampiran" title="Tambah Lampiran" style="cursor: pointer;">
                            <i class="fa-solid fa-paperclip"></i>
                        </label>
                        <input type="text" class="form-control border bg-light" name="pesan" placeholder="Ketik pesan di sini..." autocomplete="off" required>
                        <button class="btn btn-primary px-4 fw-bold shadow-sm" type="submit">
                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 p-4 shadow-sm h-100">
            <h5 class="fw-bold mb-4 pb-3 border-bottom"><i class="fa-solid fa-clipboard-user text-primary me-2"></i> Catatan Sesi</h5>
            <form method="POST" action="{{ route('psikolog.konsultasi.finish', $konsultasi) }}" class="d-flex flex-column h-100">
                @csrf @method('PATCH')
                <div class="mb-3 flex-grow-1">
                    <label class="form-label fw-semibold text-muted small">Catatan Psikolog (Opsional)</label>
                    <textarea class="form-control bg-light border-0 h-100 min-vh-25" name="catatan_psikolog" placeholder="Tuliskan catatan hasil konsultasi di sini..." style="min-height: 200px;">{{ $konsultasi->catatan_psikolog }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small">Ubah Status Sesi</label>
                    <select class="form-select bg-light border-0" name="status_konsultasi">
                        <option value="selesai" @selected($konsultasi->status_konsultasi === 'selesai')>Selesai</option>
                        <option value="follow_up" @selected($konsultasi->status_konsultasi === 'follow_up')>Follow Up (Sesi Lanjutan)</option>
                    </select>
                </div>
                <button class="btn btn-success w-100 shadow-sm fw-bold" type="submit">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Sesi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
