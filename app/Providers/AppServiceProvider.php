<?php

namespace App\Providers;

use App\Models\usuario_aula;
use App\Observers\UsuarioAulaObserver;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    }
}
