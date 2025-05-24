<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTemporaryFiles extends Command
{
    
    //protected $signature = 'app:clear-temporary-files';

    protected $signature = 'clear:temp-files';
    protected $description = 'Eliminar archivos temporales viejos en storage/app/public/temp';

    public function handle()
    {
        $now = now();

        // Ruta 2: carpeta 'temp'
        $temp = Storage::disk('public')->files('temp');

        foreach ($temp as $file) {
            $lastModified = Storage::disk('public')->lastModified($file);
            $fileTime = Carbon::createFromTimestamp($lastModified);

            if ($fileTime->diffInMinutes($now) > 60) {
                Storage::disk('public')->delete($file);
                $this->info("Archivo eliminado de 'temp': $file");
            }
        }

        $this->info('Limpieza de archivos temporales finalizada.');
    }
}
