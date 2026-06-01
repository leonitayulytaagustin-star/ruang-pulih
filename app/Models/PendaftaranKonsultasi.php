<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranKonsultasi extends Model
{
    protected $table = 'tb_pendaftaran_konsultasi';
    protected $primaryKey = 'id_pendaftaran_konsultasi';
    protected $guarded = [];

    protected $casts = [
        'persetujuan_syarat' => 'boolean',
    ];

    public function pasien()
    {
        return $this->belongsTo(TbPasien::class, 'id_pasien', 'id_pasien');
    }
}
