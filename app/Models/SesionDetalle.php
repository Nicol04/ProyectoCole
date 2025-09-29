<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'competencia_id',
        'capacidad_id',
        'desempeno_id',
        'criterio_id',
        'evidencia',
        'instrumento'
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class);
    }

    public function capacidad()
    {
        return $this->belongsTo(Capacidad::class);
    }

    public function desempeno()
    {
        return $this->belongsTo(Desempeno::class);
    }

    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class);
    }
}
