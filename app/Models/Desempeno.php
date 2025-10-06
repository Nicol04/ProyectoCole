<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desempeno extends Model
{
    use HasFactory;

    protected $fillable = ['capacidad_id', 'estandar_id', 'grado', 'capacidad_transversal_id', 'descripcion'];

    public function capacidad()
    {
        return $this->belongsTo(Capacidad::class, 'capacidad_id');
    }
    public function capacidadTransversal()
    {
        return $this->belongsTo(CapacidadTransversal::class, 'capacidad_transversal_id');
    }

    public function estandar()
    {
        return $this->belongsTo(Estandar::class, 'estandar_id');
    }
}
