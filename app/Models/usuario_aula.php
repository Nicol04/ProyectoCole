<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_aula extends Model
{
    use HasFactory;

    protected $table = 'usuario_aulas';

    protected $fillable = [
        'user_id',
        'aula_id',
        'año_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function año()
    {
        return $this->belongsTo(Año::class);
    }
}
