<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailHasilSkrining extends Model
{
    protected $table = 'tb_detail_hasil_skrining';
    protected $primaryKey = 'id_detail_hasil';
    protected $guarded = [];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanSkrining::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function jawaban()
    {
        return $this->belongsTo(JawabanSkrining::class, 'id_jawaban', 'id_jawaban');
    }
}
