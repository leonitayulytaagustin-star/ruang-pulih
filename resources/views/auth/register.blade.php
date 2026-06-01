@extends('layouts.auth', ['title' => 'Register'])

@section('form')
    <h2 class="auth-title">Selamat Datang</h2>
    <p class="auth-subtitle">Mulai perjalanan pemulihanmu sekarang</p>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <div class="input-box">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" placeholder="Masukkan nama" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email</label>
            <div class="input-box">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Masukkan email" required>
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Buat password" required>
                <i class="fa-solid fa-eye eye-icon" id="toggle-password" onclick="togglePassword('password', 'toggle-password')"></i>
            </div>
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                <i class="fa-solid fa-eye eye-icon" id="toggle-confirm" onclick="togglePassword('password_confirmation', 'toggle-confirm')"></i>
            </div>
        </div>
        <button type="submit" class="btn-submit">Daftar sekarang</button>
    </form>
    
    <div class="divider">atau daftar dengan</div>
    <button type="button" onclick="loginWithGoogle()" class="google-btn" id="google-login-btn">
        <i class="fa-brands fa-google"></i> Google
    </button>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyA1BExAFzR75PxAkLAowpUzzA5wzhVfCHU",
            authDomain: "ruang-pulih-654c5.firebaseapp.com",
            projectId: "ruang-pulih-654c5",
            storageBucket: "ruang-pulih-654c5.firebasestorage.app",
            messagingSenderId: "352089767597",
            appId: "1:352089767597:web:16482acc174ccc44749024"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        window.loginWithGoogle = function() {
            const btn = document.getElementById('google-login-btn');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Loading...';
            btn.disabled = true;

            signInWithPopup(auth, provider)
                .then((result) => {
                    return result.user.getIdToken();
                })
                .then((idToken) => {
                    return fetch("{{ route('auth.google.firebase') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id_token: idToken })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan sistem');
                    }
                })
                .catch((error) => {
                    console.error("Auth Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: error.message,
                        confirmButtonColor: '#005c34',
                    });
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                });
        }
    </script>
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
