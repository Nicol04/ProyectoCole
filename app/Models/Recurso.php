<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'nombre',
        'categoria_id',
        'descripcion',
        'url',
        'public_id',
        'imagen_preview',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
