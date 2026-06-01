@extends('layouts.auth', ['title' => 'Reset Kata Sandi'])

@section('form')
    <h2 class="auth-title">Reset Kata Sandi</h2>
    <p class="auth-subtitle">Masukkan email Anda untuk memulihkan akses akun</p>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <div class="input-box">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Masukkan email terdaftar" required>
            </div>
        </div>
        <button type="submit" class="btn-submit">Verifikasi Email</button>
    </form>

    <div class="auth-footer">
        Ingat kata sandi Anda? <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error_sweetalert'))
            Swal.fire({
                icon: 'error',
                title: 'Email Tidak Ditemukan',
                text: "{{ session('error_sweetalert') }}",
                confirmButtonColor: '#005c34',
            });
        @endif
    </script>
@endsection
