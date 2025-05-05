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

    public function users()
    {
        return $this->belongsToMany(User::class, 'usuario_aulas')
        ->withTimestamps()
        ->withPivot('año_id');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'aula_curso')->withTimestamps();
    }
    public function getGradoSeccionAttribute()
    {
        return "{$this->grado} - {$this->seccion}";
    }
}
