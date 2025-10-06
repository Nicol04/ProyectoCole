<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacidadTransversal extends Model
{
    use HasFactory;
    protected $table = 'capacidades_transversales';

    protected $fillable = [
        'competencia_transversal_id',
        'nombre',
        'descripcion',
    ];

    // Relación: una capacidad pertenece a una competencia
    public function competencia()
    {
        return $this->belongsTo(CompetenciaTransversal::class, 'competencia_transversal_id');
    }
    public function desempenos()
    {
        return $this->hasMany(Desempeno::class, 'capacidad_transversal_id');
    }
}
