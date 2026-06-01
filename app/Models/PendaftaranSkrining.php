<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranSkrining extends Model
{
    protected $table = 'tb_pendaftaran_skrining';
    protected $primaryKey = 'id_pendaftaran_skrining';
    protected $guarded = [];

    protected $casts = [
        'pernah_gangguan_mental' => 'boolean',
        'sedang_konsumsi_obat' => 'boolean',
    ];
}
