<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    use HasFactory;

    protected $fillable = ['mensaje', 'user_id', 'aula_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
    public function vistosPor()
    {
        return $this->belongsToMany(User::class, 'comunicado_user')
            ->withPivot('visto')
            ->withTimestamps();
    }
}
