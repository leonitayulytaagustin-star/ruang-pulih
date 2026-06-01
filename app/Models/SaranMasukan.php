<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranMasukan extends Model
{
    use HasFactory;

    protected $table = 'tb_saran_masukan';
    protected $primaryKey = 'id_saran';

    protected $fillable = [
        'id_user',
        'nama',
        'email',
        'pesan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
