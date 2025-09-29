<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
    use HasFactory;

    protected $fillable = ['sesion_id', 'criterio_id', 'descripcion'];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class);
    }

    public function detalles()
    {
        return $this->hasMany(RubricaDetalle::class);
    }
}
