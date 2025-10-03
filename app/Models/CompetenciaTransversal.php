<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciaTransversal extends Model
{
    use HasFactory;

    protected $table = 'competencias_transversales';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación: una competencia tiene muchas capacidades
    public function capacidades()
    {
        return $this->hasMany(CapacidadTransversal::class, 'competencia_transversal_id');
    }
}
