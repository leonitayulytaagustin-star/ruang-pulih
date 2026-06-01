<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'tb_user';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'nomor_telepon',
        'jenis_kelamin',
        'role',
        'foto_profil',
        'status_akun',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->nama_lengkap;
    }

    public function getIdAttribute(): int
    {
        return $this->id_user;
    }

    public function getFotoProfilUrlAttribute(): ?string
    {
        if (!$this->foto_profil) {
            return null;
        }

        // Jika foto_profil adalah URL lengkap (misal dari Google)
        if (filter_var($this->foto_profil, FILTER_VALIDATE_URL)) {
            return $this->foto_profil;
        }

        return url('uploads/profiles/'.$this->foto_profil);
    }

    public function pasien()
    {
        return $this->hasOne(TbPasien::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(TbAdmin::class, 'id_user', 'id_user');
    }

    public function psikolog()
    {
        return $this->hasOne(TbPsikolog::class, 'id_user', 'id_user');
    }
}
