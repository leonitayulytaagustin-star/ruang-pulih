<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodHarian extends Model
{
    protected $table = 'tb_mood_harian';
    protected $primaryKey = 'id_mood';
    protected $guarded = [];

    protected $casts = [
        'tanggal_mood' => 'date',
    ];
}
