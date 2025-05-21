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
        'archivo_id',
        'modo',
        'es_supervisado',
        'titulo',
        'fecha_creacion',
        'cantidad_preguntas',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
    public function intentos()
    {
        return $this->hasMany(IntentoEvaluacion::class);
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
    public function archivo()
    {
        return $this->belongsTo(Archivo::class);
    }
}
