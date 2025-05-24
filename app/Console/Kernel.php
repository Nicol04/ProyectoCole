<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos Artisan personalizados.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define la programación de tareas (scheduler).
     */
    protected function schedule(Schedule $schedule)
    {
        // Programa tu comando aquí
        $schedule->command('clear:temp-files')->hourly(); // o daily(), everyFiveMinutes(), etc.
    }
}