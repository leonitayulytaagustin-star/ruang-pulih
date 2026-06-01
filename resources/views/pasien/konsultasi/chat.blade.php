@extends('layouts.dashboard', ['title' => 'Chat Konsultasi'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center mb-4">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-comments me-2"></i> Ruang Konsultasi</h1>
        <p class="mb-0">Bersama Psikolog <strong>{{ $konsultasi->psikolog->user->nama_lengkap }}</strong></p>
    </div>
    <a href="{{ route('pasien.konsultasi.riwayat') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm d-flex flex-column" style="height: 650px;">
            <!-- Chat Header -->
            <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center rounded-top-4">
                <div class="d-flex align-items-center gap-3">
                    @if ($konsultasi->psikolog->user->foto_profil)
                        <img src="{{ $konsultasi->psikolog->user->foto_profil_url }}" alt="{{ $konsultasi->psikolog->user->nama_lengkap }}" class="rounded-circle object-fit-cover border border-light-subtle shadow-sm" style="width: 45px; height: 45px;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-user-doctor fs-5"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $konsultasi->psikolog->user->nama_lengkap }}</h6>
                        <small class="text-success fw-medium"><i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>Online</small>
                    </div>
                </div>
                <div>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">
                        Status: <span class="text-primary text-capitalize fw-bold ms-1">{{ str_replace('_', ' ', $konsultasi->status_konsultasi) }}</span>
                    </span>
                </div>
            </div>
            
            <!-- Chat Messages Area -->
            <div class="card-body bg-light overflow-auto p-4 d-flex flex-column gap-3" style="flex: 1;" id="chatContainer">
                <div class="text-center mb-3">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill small fw-medium">Sesi dimulai pada {{ optional($konsultasi->tanggal_konsultasi)->format('d M Y') }}</span>
                </div>

                @forelse ($konsultasi->chat as $chat)
                    @if ($chat->id_pengirim === auth()->id())
                        <!-- Pesan Pasien (Kanan) -->
                        <div class="d-flex flex-column align-items-end">
                            <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px;">
                                <p class="mb-1" style="line-height: 1.5;">{{ $chat->pesan }}</p>
                                @if ($chat->file_lampiran)
                                    <div class="mt-2 p-2 bg-white bg-opacity-25 rounded-3">
                                        <a href="{{ asset('storage/'.$chat->file_lampiran) }}" target="_blank" class="text-white text-decoration-none d-flex align-items-center gap-2 small fw-semibold">
                                            <i class="fa-solid fa-paperclip"></i> Lampiran Terkirim
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted mt-1 fw-medium" style="font-size: 0.75rem;">{{ optional($chat->waktu_kirim)->format('H.i') }} <i class="fa-solid fa-check-double ms-1 text-primary"></i></small>
                        </div>
                    @else
                        <!-- Pesan Psikolog (Kiri) -->
                        <div class="d-flex flex-column align-items-start">
                            <div class="bg-white border p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-left-radius: 4px;">
                                <strong class="d-block mb-1 text-primary small">{{ $chat->pengirim->nama_lengkap }} (Psikolog)</strong>
                                <p class="mb-1 text-dark" style="line-height: 1.5;">{{ $chat->pesan }}</p>
                                @if ($chat->file_lampiran)
                                    <div class="mt-2 p-2 bg-light rounded-3 border">
                                        <a href="{{ asset('storage/'.$chat->file_lampiran) }}" target="_blank" class="text-primary text-decoration-none d-flex align-items-center gap-2 small fw-semibold">
                                            <i class="fa-solid fa-file-arrow-down"></i> Unduh Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted mt-1 fw-medium" style="font-size: 0.75rem;">{{ optional($chat->waktu_kirim)->format('H.i') }}</small>
                        </div>
                    @endif
                @empty
                    <!-- Empty State -->
                    <div class="m-auto text-center text-muted">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-3 mx-auto d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-comments fs-2 text-primary opacity-50"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Sesi Chat Telah Dibuka</h6>
                        <p class="mb-0 small">Kirim pesan pertamamu kepada psikolog sekarang.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Chat Input Area -->
            <div class="card-footer bg-white border-top p-3 rounded-bottom-4">
                @if ($konsultasi->status_konsultasi === 'selesai')
                    <div class="text-center p-2 text-muted bg-light rounded-3 border">
                        <i class="fa-solid fa-lock me-2"></i> Sesi konsultasi ini telah selesai. Anda tidak dapat mengirim pesan lagi.
                    </div>
                @else
                    <form method="POST" enctype="multipart/form-data" action="{{ route('pasien.konsultasi.chat.send', $konsultasi) }}">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="file_lampiran" class="form-control d-none" id="file_lampiran">
                            <label class="input-group-text bg-light border text-muted cursor-pointer px-3" for="file_lampiran" title="Tambah Lampiran" style="cursor: pointer;">
                                <i class="fa-solid fa-paperclip fs-5"></i>
                            </label>
                            <input type="text" class="form-control border bg-light px-3 py-2" name="pesan" placeholder="Ketik pesan Anda di sini..." autocomplete="off" required>
                            <button class="btn btn-primary px-4 fw-bold shadow-sm" type="submit">
                                <i class="fa-solid fa-paper-plane me-2"></i> Kirim
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom of chat
    document.addEventListener("DOMContentLoaded", function() {
        var chatContainer = document.getElementById("chatContainer");
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
</script>
@endpush
@endsection
