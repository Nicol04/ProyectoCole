<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Año extends Model
{
    use HasFactory;
    protected $table = 'años';
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
    ];
    public function usuario_aulas()
    {
        return $this->hasMany(usuario_aula::class, 'año_id');
    }
}
