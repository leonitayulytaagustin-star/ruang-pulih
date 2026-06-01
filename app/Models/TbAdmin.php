<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbAdmin extends Model
{
    protected $table = 'tb_admin';
    protected $primaryKey = 'id_admin';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
