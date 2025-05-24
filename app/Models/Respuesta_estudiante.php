<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'examen_preguntas_id',
        'intento_id',
        'respuesta_abierta',
        'fecha_respuesta',
    ];


    public function estudiante()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intento()
    {
        return $this->belongsTo(IntentoEvaluacion::class, 'intento_id');
    }

}
