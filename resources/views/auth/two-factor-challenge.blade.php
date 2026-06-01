@extends('layouts.auth', ['title' => 'Verifikasi Keamanan'])

@section('form')
    <h2 class="auth-title">Verifikasi 2 Langkah</h2>
    <p class="auth-subtitle">Selesaikan tantangan CAPTCHA di bawah ini dalam waktu <strong class="text-danger">15 detik</strong> untuk melanjutkan.</p>

    <div class="text-center mb-4 mt-4">
        <div class="p-3 bg-light rounded-4 d-inline-block border">
            <img src="{{ route('two-factor.captcha') }}" alt="CAPTCHA Challenge" class="rounded-3" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
        </div>
        <div class="mt-3">
            <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold" style="font-size: 14px;">
                Sisa Waktu: <span id="timer">15</span> detik
            </span>
        </div>
    </div>

    @error('email')
        <div class="alert alert-danger border-0 rounded-4 mb-4 small text-center" style="background: rgba(220, 53, 69, 0.1); color: #b02a37;">
            {{ $message }}
        </div>
    @enderror

    <form id="captcha-form" action="{{ route('two-factor.login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Masukkan Teks CAPTCHA</label>
            <div class="input-box">
                <i class="fa-solid fa-shield-halved"></i>
                <input type="text" name="captcha" placeholder="Teks tidak membedakan huruf besar/kecil" required autofocus autocomplete="off" style="text-align: center; padding-left: 0; font-weight: bold; letter-spacing: 2px;">
            </div>
            @error('captcha')
                <small style="color: #e53e3e; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn-submit">Verifikasi & Login</button>
    </form>

    <div class="auth-footer mt-4">
        Bermasalah dengan akun? <a href="{{ route('bantuan.index') }}">Hubungi Bantuan</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timeLeft = 15;
            const timerElement = document.getElementById('timer');
            
            const countdown = setInterval(() => {
                timeLeft--;
                timerElement.innerText = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    // Disable form to prevent submitting expired captcha
                    document.getElementById('captcha-form').querySelector('button').disabled = true;
                    // Auto redirect to login
                    window.location.href = "{{ route('login') }}";
                }
            }, 1000);
        });
    </script>
@endsection

