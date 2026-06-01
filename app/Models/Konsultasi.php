<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'tb_konsultasi';
    protected $primaryKey = 'id_konsultasi';
    protected $guarded = [];

    protected $casts = [
        'tanggal_konsultasi' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranKonsultasi::class, 'id_pendaftaran_konsultasi', 'id_pendaftaran_konsultasi');
    }

    public function pasien()
    {
        return $this->belongsTo(TbPasien::class, 'id_pasien', 'id_pasien');
    }

    public function psikolog()
    {
        return $this->belongsTo(TbPsikolog::class, 'id_psikolog', 'id_psikolog');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPsikolog::class, 'id_jadwal', 'id_jadwal');
    }

    public function chat()
    {
        return $this->hasMany(ChatKonsultasi::class, 'id_konsultasi', 'id_konsultasi')->orderBy('waktu_kirim');
    }
}
