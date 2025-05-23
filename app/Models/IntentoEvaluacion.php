<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntentoEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'intentos_evaluacion';

    protected $fillable = [
        'evaluacion_id',
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    // Relaciones
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function calificacion()
    {
        return $this->hasOne(Calificacion::class, 'intento_id');
    }

}
