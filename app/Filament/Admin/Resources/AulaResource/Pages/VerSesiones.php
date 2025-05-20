<?php

namespace App\Filament\Admin\Resources\AulaResource\Pages;

use App\Filament\Admin\Resources\AulaResource;
use App\Models\Aula;
use App\Models\AulaCurso;
use App\Models\Curso;
use Filament\Resources\Pages\Page;

class VerSesiones extends Page
{
    protected static string $resource = AulaResource::class;
    protected static string $view = 'filament.admin.resources.aula-resource.pages.ver-sesiones';
    public $aula;
    public $curso;
    public $sesiones;


    public function mount($record, $cursoId)
    {
        $this->aula = Aula::findOrFail($record);
        $this->curso = Curso::findOrFail($cursoId);

        $aulaCurso = AulaCurso::where('aula_id', $this->aula->id)
            ->where('curso_id', $this->curso->id)
            ->firstOrFail();

        $this->sesiones = $aulaCurso->sesiones;
    }
    protected function getViewData(): array
    {
        logger('getViewData ejecutado');
        return [
            'aula' => $this->aula,
            'curso' => $this->curso,
            'sesiones' => $this->sesiones,
        ];
    }
}
