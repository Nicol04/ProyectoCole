<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'user_id',
        'aula_id',
        'fecha',
        'dia',
        'titulo',
        'objetivo',
        'actividades',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}
