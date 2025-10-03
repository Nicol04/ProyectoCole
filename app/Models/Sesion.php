<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'dia',
        'titulo',
        'tema',
        'tiempo_estimado',
        'proposito_sesion',
        'aula_curso_id',
        'docente_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    /*
    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }*/
    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function aulaCurso()
    {
        return $this->belongsTo(AulaCurso::class);
    }
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
    // Nueva relación con detalles pedagógicos
    public function detalles()
    {
        return $this->hasMany(SesionDetalle::class);
    }

    public function detalle()
    {
        return $this->hasOne(SesionDetalle::class);
    }
}
