<?php

namespace App\Providers;

use App\Models\AulaCurso;
use App\Models\Comunicado;
use App\Models\usuario_aula;
use App\Observers\UsuarioAulaObserver;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrapFive();
        usuario_aula::observe(UsuarioAulaObserver::class);
        Carbon::setLocale('es');
        CarbonImmutable::setLocale('es');
        Paginator::useBootstrapFive();
        Carbon::setLocale('es');
        CarbonImmutable::setLocale('es');

        usuario_aula::observe(UsuarioAulaObserver::class);

        // Cargar datos compartidos para el menú del estudiante
        View::composer('panel.includes.menu_estudiante', function ($view) {
            $evaluacionesPendientesCount = 0;
            $comunicadosNoVistos = [];

            if (Auth::check() && Auth::user()->roles->first()?->id == 3) {
                $user = Auth::user();
                $aula = $user->aulas()->first();

                // Evaluaciones pendientes
                $evaluacionesPendientesCount = $user->getEvaluacionesPendientesCount();

                // Comunicados no vistos
                if ($aula) {
                    $comunicadosNoVistos = Comunicado::where('aula_id', $aula->id)
                        ->whereDoesntHave('vistosPor', function ($query) use ($user) {
                            $query->where('user_id', $user->id)->where('visto', true);
                        })
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                }
            }

            $view->with([
                'evaluacionesPendientesCount' => $evaluacionesPendientesCount,
                'comunicadosNoVistos' => $comunicadosNoVistos
            ]);
        });
    }
}
