<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPemantauan extends Model
{
    protected $table = 'tb_jawaban_pemantauan';
    protected $primaryKey = 'id_jawaban_pemantauan';
    protected $guarded = [];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanPemantauan::class, 'id_pertanyaan_pemantauan', 'id_pertanyaan_pemantauan');
    }
}
