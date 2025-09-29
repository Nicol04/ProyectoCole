<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacidad extends Model
{
    use HasFactory;
    protected $table = 'capacidades';

    protected $fillable = ['competencia_id', 'nombre', 'descripcion'];

    public function competencia()
    {
        return $this->belongsTo(Competencia::class);
    }

    public function criterios()
    {
        return $this->hasMany(CriterioEvaluacion::class);
    }
    public function desempenos()
    {
        return $this->hasMany(Desempeno::class);
    }
}
