<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbPsikolog extends Model
{
    protected $table = 'tb_psikolog';
    protected $primaryKey = 'id_psikolog';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalPsikolog::class, 'id_psikolog', 'id_psikolog');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_psikolog', 'id_psikolog');
    }
}
