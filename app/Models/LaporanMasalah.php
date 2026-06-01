<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    use HasFactory;

    protected $table = 'tb_laporan_masalah';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user',
        'kategori',
        'judul',
        'deskripsi',
        'status_laporan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
