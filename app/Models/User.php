<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function avatar()
    {
        return $this->belongsTo(Avatar_usuarios::class, 'avatar_usuario_id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function usuario_aulas()
    {
        return $this->hasMany(usuario_aula::class);
    }
    public function aulas()
    {
        return $this->belongsToMany(Aula::class, 'usuario_aulas')
            ->withTimestamps()
            ->withPivot('año_id');
    }
    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
    public function intentos()
    {
        return $this->hasMany(IntentoEvaluacion::class);
    }
    public function respuestas()
    {
        return $this->hasMany(Respuesta_estudiante::class);
    }
}