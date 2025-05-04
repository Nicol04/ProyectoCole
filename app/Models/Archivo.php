<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $fillable = [
        'curso_id',
        'user_id',
        'nombre',
        'tipo',
        'url',
    ];

    // Relación con el curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relación con el docente
    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
