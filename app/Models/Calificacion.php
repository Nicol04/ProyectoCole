<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'evaluacion_id',
        'user_id',
        'nota',
        'retroalimentacion',
        'fecha',
    ];

    // Relaciones
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
