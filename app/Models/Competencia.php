<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $fillable = ['curso_id', 'nombre', 'descripcion'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function capacidades()
    {
        return $this->hasMany(Capacidad::class);
    }
    public function estandar()
    {
        return $this->belongsTo(Estandar::class);
    }
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($competencia) {
            $competencia->capacidades()->delete();
        });
    }
    public function estandares()
    {
        return $this->hasMany(Estandar::class);
    }
}
