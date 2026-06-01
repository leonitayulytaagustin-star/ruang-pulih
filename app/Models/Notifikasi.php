<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'tb_notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $guarded = [];

    protected $casts = [
        'status_baca' => 'boolean',
    ];
}
