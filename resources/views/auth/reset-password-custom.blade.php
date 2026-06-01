@extends('layouts.auth', ['title' => 'Ubah Password Baru'])

@section('form')
    <h2 class="auth-title">Ubah Password</h2>
    <p class="auth-subtitle">Silakan masukkan password baru Anda</p>

    <form action="{{ route('password.update.custom') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Password Baru</label>
            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                <i class="fa-solid fa-eye eye-icon" id="toggle-password" onclick="togglePassword('password', 'toggle-password')"></i>
            </div>
            @error('password')
                <small style="color: #e53e3e; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
                <i class="fa-solid fa-eye eye-icon" id="toggle-password-confirm" onclick="togglePassword('password_confirmation', 'toggle-password-confirm')"></i>
            </div>
        </div>
        <button type="submit" class="btn-submit">Ubah Password</button>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
