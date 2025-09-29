<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estandar extends Model
{
    use HasFactory;
    protected $table = 'estandares';
    protected $fillable = [
        'competencia_id',
        'ciclo',
        'descripcion',
    ];
    public function competencia()
    {
        return $this->belongsTo(Competencia::class);
    }
    public function desempenos()
    {
        return $this->hasMany(Desempeno::class);
    }
}
