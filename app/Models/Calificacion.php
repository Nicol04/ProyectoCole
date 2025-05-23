<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'intento_id',
        'retroalimentacion',
        'fecha',
        'puntaje_total',
        'puntaje_maximo',
        'porcentaje',
        'estado'
    ];

    // Relaciones
    public function intento()
    {
        return $this->belongsTo(IntentoEvaluacion::class, 'intento_id');
    }
}
