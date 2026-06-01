<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitasPasien extends Model
{
    protected $table = 'tb_riwayat_aktivitas_pasien';
    protected $primaryKey = 'id_aktivitas';
    protected $guarded = [];

    protected $casts = [
        'tanggal_aktivitas' => 'datetime',
    ];
}
