<?php

namespace App\Filament\Admin\Resources\AulaResource\RelationManagers;

use App\Models\Curso;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CursosRelationManager extends RelationManager
{
    protected static string $relationship = 'Cursos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('curso')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('curso')
            ->columns([
                Tables\Columns\TextColumn::make('curso')->label('Curso'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('agregarCursos')
                    ->label('Vincular cursos')
                    ->icon('heroicon-m-plus')
                    ->form([
                        Forms\Components\Select::make('curso_ids')
                            ->label('Seleccionar cursos')
                            ->multiple()
                            ->searchable()
                            ->options(function (RelationManager $livewire) {
                                $aula = $livewire->getOwnerRecord();

                                return \App\Models\Curso::whereDoesntHave('aulas', function ($query) use ($aula) {
                                    $query->where('aula_id', $aula->id);
                                })
                                    ->pluck('curso', 'id');
                            })
                            ->required(),
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $aula = $livewire->getOwnerRecord();

                        foreach ($data['curso_ids'] as $cursoId) {
                            \App\Models\AulaCurso::create([
                                'aula_id' => $aula->id,
                                'curso_id' => $cursoId,
                            ]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Cursos vinculados exitosamente.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('verSesiones')
                    ->label('Sesiones')
                    ->icon('heroicon-o-clipboard-document')
                    ->url(fn($record) => route('filament.dashboard.resources.aulas.ver-sesiones', [
                        'record' => $this->ownerRecord->id,
                        'cursoId' => $record->id,
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
