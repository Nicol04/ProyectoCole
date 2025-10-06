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
        'competencia_transversal_id',
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

    public function perteneceA(): string
    {
        if ($this->competencia_id) {
            return 'Competencia de curso';
        }

        if ($this->competencia_transversal_id) {
            return 'Competencia transversal';
        }

        return 'Sin asignar';
    }

}
