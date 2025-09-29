<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CapacidadResource\Pages;
use App\Filament\Admin\Resources\CapacidadResource\RelationManagers;
use App\Models\Capacidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapacidadResource extends Resource
{
    protected static ?string $model = Capacidad::class;
    protected static ?string $navigationGroup = 'Currículo';
    protected static ?string $navigationLabel = 'Capacidades';
    protected static ?string $pluralModelLabel = 'Capacidades';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('competencia.curso.curso')
                    ->sortable()
                    ->searchable()
                    ->label('Curso'),
                Tables\Columns\TextColumn::make('competencia.nombre')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->label('Competencia'),
                Tables\Columns\TextColumn::make('nombre')
                    ->sortable()
                    ->limit(30)
                    ->searchable()
                    ->label('Capacidad'),
                Tables\Columns\TextColumn::make('desempenos_count')
                    ->counts('desempenos')
                    ->label('Desempeños')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('curso')
                    ->relationship('competencia.curso', 'curso')
                    ->preload()
                    ->label('Filtrar por Curso')
                    ->searchable()
                    ->multiple(false),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCapacidads::route('/'),
            'edit' => Pages\EditCapacidad::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
