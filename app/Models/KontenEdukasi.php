<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontenEdukasi extends Model
{
    protected $table = 'tb_konten_edukasi';
    protected $primaryKey = 'id_konten';
    protected $guarded = [];

    protected $casts = [
        'tanggal_publish' => 'datetime',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        return url('uploads/edukasi/' . basename($this->thumbnail));
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriEdukasi::class, 'id_kategori', 'id_kategori');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_penulis', 'id_user');
    }
}
