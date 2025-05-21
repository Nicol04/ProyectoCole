<?php

namespace App\Filament\Admin\Resources\AulaResource\RelationManagers;

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
                Tables\Columns\TextColumn::make('curso'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('verSesiones')
                    ->label('Sesiones')
                    ->icon('heroicon-o-clipboard-document')
                    ->url(fn($record) => route('filament.dashboard.resources.aulas.ver-sesiones', [
                        'record' => $this->ownerRecord->id,
                        'cursoId' => $record->id,
                    ]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
