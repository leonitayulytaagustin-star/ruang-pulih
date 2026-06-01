<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemantauanMental extends Model
{
    protected $table = 'tb_pemantauan_mental';
    protected $primaryKey = 'id_pemantauan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_pemantauan' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(TbPasien::class, 'id_pasien', 'id_pasien');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanPemantauan::class, 'id_pemantauan', 'id_pemantauan');
    }
}
