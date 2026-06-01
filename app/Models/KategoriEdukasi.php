<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriEdukasi extends Model
{
    protected $table = 'tb_kategori_edukasi';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

    public function konten()
    {
        return $this->hasMany(KontenEdukasi::class, 'id_kategori', 'id_kategori');
    }
}
