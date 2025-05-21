<?php

namespace App\Filament\Admin\Resources\AulaResource\Pages;

use App\Filament\Admin\Resources\AulaResource;
use App\Models\Sesion;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class EditarSesion extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = AulaResource::class;
    protected static string $view = 'filament.admin.resources.aula-resource.pages.editar-sesion';

    public Sesion $sesion;
    public array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->model($this->sesion)
            ->statePath('data')
            ->schema($this->getFormSchema());
    }

    public function mount($record): void
    {
        $this->sesion = Sesion::findOrFail($record);
        $this->data = [
            'fecha' => $this->sesion->fecha,
            'dia' => $this->sesion->dia,
            'titulo' => $this->sesion->titulo,
            'objetivo' => $this->sesion->objetivo,
            'actividades' => $this->sesion->actividades,
        ];
    }


    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormModel(): Sesion
    {
        return $this->sesion;
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
            Textarea::make('objetivo')
                ->required()
                ->columnSpanFull(),

            Textarea::make('actividades')
                ->required()
                ->columnSpanFull(),
        ];
    }

    public function submit()
    {
        $this->sesion->update($this->data);

        Notification::make()
            ->title('Sesión actualizada con éxito')
            ->success()
            ->send();

        return redirect()->route('filament.dashboard.resources.aulas.ver-sesiones', [
            'record' => $this->sesion->aulaCurso->aula->id,
            'cursoId' => $this->sesion->aulaCurso->curso->id,
        ]);
    }
}
