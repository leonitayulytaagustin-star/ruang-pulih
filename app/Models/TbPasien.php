<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbPasien extends Model
{
    protected $table = 'tb_pasien';
    protected $primaryKey = 'id_pasien';
    protected $guarded = [];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function hasilSkrining()
    {
        return $this->hasMany(HasilSkrining::class, 'id_pasien', 'id_pasien');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_pasien', 'id_pasien');
    }

    public function pemantauan()
    {
        return $this->hasMany(PemantauanMental::class, 'id_pasien', 'id_pasien');
    }
}
