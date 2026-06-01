<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPsikolog extends Model
{
    protected $table = 'tb_jadwal_psikolog';
    protected $primaryKey = 'id_jadwal';
    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function psikolog()
    {
        return $this->belongsTo(TbPsikolog::class, 'id_psikolog', 'id_psikolog');
    }
}
