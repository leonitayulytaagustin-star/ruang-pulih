<style>
    .profile-photo-field {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 18px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 18px;
    }
    .profile-photo-preview {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: #fff;
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid #fff;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
    }
    .profile-photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-photo-preview i {
        font-size: 42px;
    }
    @media (max-width: 576px) {
        .profile-photo-field {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="profile-photo-field mb-4">
    <div class="profile-photo-preview">
        @if($user->foto_profil_url)
            <img src="{{ $user->foto_profil_url }}" alt="Foto profil {{ $user->nama_lengkap }}">
        @else
            <i class="fa-solid fa-user"></i>
        @endif
    </div>
    <div class="flex-grow-1">
        <label class="form-label fw-semibold text-dark">Foto Profil</label>
        <input class="form-control bg-white @error('foto_profil') is-invalid @enderror" type="file" name="foto_profil" accept="image/jpeg,image/png,image/webp">
        @error('foto_profil')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Gunakan JPG, PNG, atau WebP maksimal 2MB. Upload baru akan mengganti foto lama.</div>

        @if($user->foto_profil)
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="hapus_foto_profil" value="1" id="hapusFotoProfil">
                <label class="form-check-label text-danger fw-semibold" for="hapusFotoProfil">
                    Hapus foto profil saat menyimpan
                </label>
            </div>
        @endif
    </div>
</div>
