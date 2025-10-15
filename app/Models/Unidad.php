<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'nombre',
        'grado',
        'secciones',
        'fecha_inicio',
        'fecha_fin',
        'profesores_responsables',
        'situacion_significativa',
        'productos',
    ];

    protected $casts = [
        'secciones' => 'array',
        'profesores_responsables' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /** 🔗 Relación con detalles */
    public function detalles()
    {
        return $this->hasMany(UnidadDetalle::class, 'unidad_id');
    }
}
