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
        'password_plano',
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
    public function getEvaluacionesPendientesCount()
    {
        $aulaIds = $this->aulas()->pluck('aulas.id');
        $aulaCursoIds = \App\Models\AulaCurso::whereIn('aula_id', $aulaIds)->pluck('id');
        $sesionIds = \App\Models\Sesion::whereIn('aula_curso_id', $aulaCursoIds)->pluck('id');
        $evaluaciones = \App\Models\Evaluacion::whereIn('sesion_id', $sesionIds)
            ->has('preguntas')
            ->with(['intentos' => function ($q) {
                $q->where('user_id', $this->id);
            }])
            ->get();

        $evaluacionesEnProgreso = collect();
        $evaluacionesNoIniciadas = collect();

        foreach ($evaluaciones as $evaluacion) {
            $intentos = $evaluacion->intentos;
            $tieneEnProgreso = $intentos->contains(function ($intento) {
                return $intento->estado === 'en progreso' && is_null($intento->fecha_fin);
            });

            if ($tieneEnProgreso) {
                $evaluacionesEnProgreso->push($evaluacion);
            } elseif ($intentos->isEmpty()) {
                $evaluacionesNoIniciadas->push($evaluacion);
            }
        }

        return $evaluacionesEnProgreso->count() + $evaluacionesNoIniciadas->count();
    }
    public function comunicadosVistos()
    {
        return $this->belongsToMany(Comunicado::class, 'comunicado_user')
            ->withPivot('visto')
            ->withTimestamps();
    }
    public function comunicadoUser()
    {
        return $this->hasMany(Comunicado_user::class);
    }
}
