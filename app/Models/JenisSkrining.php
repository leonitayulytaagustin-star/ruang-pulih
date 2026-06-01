<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSkrining extends Model
{
    protected $table = 'tb_jenis_skrining';
    protected $primaryKey = 'id_jenis_skrining';
    protected $guarded = [];

    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanSkrining::class, 'id_jenis_skrining', 'id_jenis_skrining')->orderBy('urutan');
    }

    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }

        return url('uploads/skrining/' . $this->gambar);
    }
}
