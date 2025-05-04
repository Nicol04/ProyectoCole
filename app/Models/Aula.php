<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $fillable = [
        'grado',
        'seccion',
        'cantidad_usuarios'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_aulas')
        ->withTimestamps()
        ->withPivot('año_id');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
}
