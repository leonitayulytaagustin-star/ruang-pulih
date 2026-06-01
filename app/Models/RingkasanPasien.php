<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RingkasanPasien extends Model
{
    protected $table = 'tb_ringkasan_pasien';
    protected $primaryKey = 'id_ringkasan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_update' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(TbPasien::class, 'id_pasien', 'id_pasien');
    }
}
