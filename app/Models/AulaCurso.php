<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaCurso extends Model
{
    use HasFactory;

    protected $table = 'aula_curso';

    protected $fillable = [
        'aula_id',
        'curso_id',
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
}
