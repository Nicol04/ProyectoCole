<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicado_user extends Model
{
    protected $table = 'comunicado_user';

    protected $fillable = ['user_id', 'comunicado_id', 'visto'];

    public $timestamps = true;

    public function comunicado()
    {
        return $this->belongsTo(Comunicado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
