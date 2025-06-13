<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'user_id',
        'es_supervisado',
        'titulo',
        'fecha_creacion',
        'cantidad_preguntas',
        'cantidad_intentos',
        'imagen_url',
        'texto',
        'visible',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intentos()
    {
        return $this->hasMany(IntentoEvaluacion::class);
    }
    public function preguntas()
    {
        return $this->hasMany(ExamenPregunta::class);
    }
}
