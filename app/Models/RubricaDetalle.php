<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricaDetalle extends Model
{
    use HasFactory;

    protected $fillable = ['rubrica_id', 'nivel', 'descriptor'];

    public function rubrica()
    {
        return $this->belongsTo(Rubrica::class);
    }
}
