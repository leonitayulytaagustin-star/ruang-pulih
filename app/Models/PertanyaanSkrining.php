<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanSkrining extends Model
{
    protected $table = 'tb_pertanyaan_skrining';
    protected $primaryKey = 'id_pertanyaan';
    protected $guarded = [];

    public function jenisSkrining()
    {
        return $this->belongsTo(JenisSkrining::class, 'id_jenis_skrining', 'id_jenis_skrining');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanSkrining::class, 'id_pertanyaan', 'id_pertanyaan')->orderBy('urutan');
    }
}
