<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionMomento extends Model
{
    use HasFactory;

    protected $fillable = ['sesion_id', 'momento', 'estrategia', 'descripcion_actividad'];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
}
