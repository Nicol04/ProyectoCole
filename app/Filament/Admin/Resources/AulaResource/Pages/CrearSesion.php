<?php

namespace App\Filament\Admin\Resources\AulaResource\Pages;

use App\Filament\Admin\Resources\AulaResource;
use App\Models\Aula;
use App\Models\AulaCurso;
use App\Models\Curso;
use App\Models\Sesion;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\Page;

class CrearSesion extends Page
{
    protected static string $resource = AulaResource::class;
    protected static string $view = 'filament.admin.resources.aula-resource.pages.crear-sesion';

    public $aula;
    public $curso;
    public $aulaCursoId;

    public string $titulo = '';
    public string $fecha = '';
    public string $dia = '';
    public string $objetivo = '';
    public string $actividades = '';

    public function mount($record, $cursoId)
    {
        $this->aula = Aula::findOrFail($record);
        $this->curso = Curso::findOrFail($cursoId);

        $aulaCurso = AulaCurso::where('aula_id', $this->aula->id)
            ->where('curso_id', $this->curso->id)
            ->firstOrFail();

        $this->aulaCursoId = $aulaCurso->id;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('titulo')->required(),
            DatePicker::make('fecha')
                ->label('Fecha de sesión')
                ->required()
                ->reactive()
                ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                    if ($state) {
                        $fecha = \Carbon\Carbon::parse($state)->locale('es');
                        $dia = ucfirst($fecha->isoFormat('dddd'));
                        $set('dia', $dia);
                    }
                }),

            TextInput::make('dia')
                ->label('Día')
                ->readOnly()
                ->reactive()
                ->dehydrated(),
            Forms\Components\Textarea::make('objetivo')->required(),
            Forms\Components\Textarea::make('actividades')->required(),
        ];
    }

    public function create()
    {
        Sesion::create([
            'aula_curso_id' => $this->aulaCursoId,
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'dia' => $this->dia,
            'objetivo' => $this->objetivo,
            'actividades' => $this->actividades,
        ]);

        Notification::make()
            ->title('Sesión creada con éxito')
            ->success()
            ->send();

        return redirect()->route('filament.dashboard.resources.aulas.ver-sesiones', [
            'record' => $this->aula->id,
            'cursoId' => $this->curso->id,
        ]);
    }
}
