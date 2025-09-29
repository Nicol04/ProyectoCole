<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaAprendizaje extends Model
{
    use HasFactory;

    protected $fillable = ['sesion_id', 'titulo', 'contenido', 'tipo'];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
}
