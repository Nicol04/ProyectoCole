<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta_id',
        'user_id',
        'respuesta_id',
        'respuesta_abierta',
        'fecha_respuesta',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class);
    }
}
