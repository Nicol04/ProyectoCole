<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'dia',
        'titulo',
        'objetivo',
        'actividades',
        'aula_curso_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aulaCurso()
    {
        return $this->belongsTo(AulaCurso::class);
    }
}
