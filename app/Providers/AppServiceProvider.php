<?php

namespace App\Providers;

use App\Models\AulaCurso;
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
        View::composer('panel.includes.menu_estudiante', function ($view) {
            $evaluacionesPendientesCount = 0;
            if (Auth::check() && Auth::user()->roles->first()?->id == 3) {
                $evaluacionesPendientesCount = Auth::user()->getEvaluacionesPendientesCount();
            }
            $view->with('evaluacionesPendientesCount', $evaluacionesPendientesCount);
        });
    }
}
