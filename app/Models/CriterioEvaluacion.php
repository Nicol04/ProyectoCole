<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterioEvaluacion extends Model
{
    use HasFactory;

    protected $fillable = ['capacidad_id', 'descripcion'];

    public function capacidad()
    {
        return $this->belongsTo(Capacidad::class);
    }

    public function desempenos()
    {
        return $this->hasMany(Desempeno::class, 'criterio_id');
    }
}
