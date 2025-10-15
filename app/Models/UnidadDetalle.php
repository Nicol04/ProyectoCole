<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadDetalle extends Model
{
    use HasFactory;

    protected $table = 'unidad_detalles';

    protected $fillable = [
        'unidad_id',
        'contenido',
        'enfoques',
        'materiales_basicos',
        'recursos'
    ];

    protected $casts = [
        'contenido' => 'array',
        'enfoques' => 'array',
    ];

    /** 🔗 Relación con Unidad */
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
}
