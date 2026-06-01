<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSkrining extends Model
{
    protected $table = 'tb_hasil_skrining';
    protected $primaryKey = 'id_hasil_skrining';
    protected $guarded = [];

    protected $casts = [
        'tanggal_skrining' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(TbPasien::class, 'id_pasien', 'id_pasien');
    }

    public function jenisSkrining()
    {
        return $this->belongsTo(JenisSkrining::class, 'id_jenis_skrining', 'id_jenis_skrining');
    }

    public function detail()
    {
        return $this->hasMany(DetailHasilSkrining::class, 'id_hasil_skrining', 'id_hasil_skrining');
    }
}
