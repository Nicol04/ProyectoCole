<?php

namespace App\Filament\Admin\Resources\AulaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesionesRelationManager extends RelationManager
{
    protected static string $relationship = 'sesiones';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')->required(),
                Forms\Components\TextInput::make('dia')->required(),
                Forms\Components\TextInput::make('titulo')->required(),
                Forms\Components\Textarea::make('objetivo'),
                Forms\Components\Textarea::make('actividades'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->columns([
                Tables\Columns\TextColumn::make('titulo'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
