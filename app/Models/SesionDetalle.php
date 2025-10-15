<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionDetalle extends Model
{
    use HasFactory;
    protected $table = 'sesion_detalles';
    protected $fillable = [
        'sesion_id',
        'competencias',
        'capacidades',
        'desempenos',
        'criterio_id',
        'evidencia',
        'instrumento',
        'competencia_transversal',
        'capacidad_transversal',
        'desempeno_transversal'
    ];

    // Esto convierte automáticamente JSON ↔ Array
    protected $casts = [
        'competencias' => 'array',
        'capacidades' => 'array',
        'desempenos' => 'array',
        'competencia_transversal' => 'array',
        'capacidad_transversal' => 'array',
        'desempeno_transversal' => 'array',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class);
    }
}
