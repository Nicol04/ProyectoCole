<?php

namespace App\Filament\Admin\Resources\WidgetsResource\Widgets;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\User;
use App\Models\Recurso;
use App\Models\Categoria;
use App\Models\Avatar_usuarios;
use App\Models\Calificacion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\CursoResource;
use App\Filament\Admin\Resources\AulaResource;
use App\Filament\Admin\Resources\AvatarUsuariosResource;
use App\Filament\Admin\Resources\RecursoResource;
use App\Filament\Admin\Resources\CategoriaResource;
use App\Filament\Admin\Resources\CalificacionResource;
use App\Filament\Admin\Resources\EvaluacionResource;
use App\Models\Evaluacion;

class EstadisticasDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $cantidadUsuarios = User::count();
        $cantidadEstudiantes = User::whereHas('roles', fn($q) => $q->where('name', 'estudiante'))->count();
        $cantidadDocentes = User::whereHas('roles', fn($q) => $q->where('name', 'docente'))->count();
        $cantidadCursos = Curso::count();
        $cantidadAulas = Aula::count();
        $cantidadRecursos = Recurso::count();
        $cantidadCategorias = Categoria::count();
        $cantidadAvatares = Avatar_usuarios::count();
        $cantidadCalificaciones = Calificacion::count();
        $cantidadEvaluaciones = Evaluacion::count();
        return [
            Stat::make('Usuarios', $cantidadUsuarios)
                ->description('Total registrados')
                ->color('gray')
                ->icon('heroicon-o-user-circle')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . UserResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Estudiantes', $cantidadEstudiantes)
                ->description('Total registrados')
                ->color('success')
                ->icon('heroicon-o-users')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . UserResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Docentes', $cantidadDocentes)
                ->description('Total registrados')
                ->color('info')
                ->icon('heroicon-o-academic-cap')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . UserResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Cursos', $cantidadCursos)
                ->description('Total disponibles')
                ->color('warning')
                ->icon('heroicon-o-book-open')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . CursoResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Aulas', $cantidadAulas)
                ->description('Total creadas')
                ->color('primary')
                ->icon('heroicon-o-building-library')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . AulaResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Recursos', $cantidadRecursos)
                ->description('Material educativo')
                ->color('gray')
                ->icon('heroicon-o-document-text')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . RecursoResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),

            Stat::make('Categorías', $cantidadCategorias)
                ->description('Organización de recursos')
                ->color('success')
                ->icon('heroicon-o-tag')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . CategoriaResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),
            Stat::make('Avatares registrados', $cantidadAvatares)
                ->description('Personalizados por los usuarios')
                ->color('info')
                ->icon('heroicon-o-face-smile')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . AvatarUsuariosResource::getUrl() . "'",
                    'style' => 'cursor: default;',
                ]),

            Stat::make('Evaluaciones', $cantidadEvaluaciones)
                ->description('Total de evaluaciones')
                ->color('success')
                ->icon('heroicon-o-users')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . EvaluacionResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),
                
            Stat::make('Calificaciones', $cantidadCalificaciones)
                ->description('Total de calificaciones registradas')
                ->color('warning')
                ->icon('heroicon-o-star')
                ->extraAttributes([
                    'onclick' => "window.location.href='" . CalificacionResource::getUrl() . "'",
                    'style' => 'cursor: pointer;',
                ]),
        ];
    }
}
