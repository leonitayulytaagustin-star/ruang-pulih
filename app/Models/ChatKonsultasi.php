<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatKonsultasi extends Model
{
    protected $table = 'tb_chat_konsultasi';
    protected $primaryKey = 'id_chat';
    protected $guarded = [];

    protected $casts = [
        'waktu_kirim' => 'datetime',
        'status_baca' => 'boolean',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id_user');
    }
}
