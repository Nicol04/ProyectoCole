<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'competencias',
        'capacidades', 
        'desempenos',
        'criterio_id',
        'evidencia',
        'instrumento'
    ];

    // Esto convierte automáticamente JSON ↔ Array
    protected $casts = [
        'competencias' => 'array',
        'capacidades' => 'array',
        'desempenos' => 'array',
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
