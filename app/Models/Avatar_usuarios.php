<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar_usuarios extends Model
{
    use HasFactory;

    protected $table = 'avatar_usuarios';

    protected $fillable = [
        'name',
        'path',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'avatar_usuario_id');
    }
}
