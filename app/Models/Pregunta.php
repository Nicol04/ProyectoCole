<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'tipo_pregunta',
        'enunciado',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    public function respuestasEstudiantes()
    {
        return $this->hasMany(Respuesta_estudiante::class);
    }
}
