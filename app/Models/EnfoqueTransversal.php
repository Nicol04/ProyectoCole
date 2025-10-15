<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfoqueTransversal extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'valores_actitudes',
    ];

    protected $casts = [
        'valores_actitudes' => 'array',
    ];
    protected $table = 'enfoque_transversales';

}