<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SesionDetalleResource\Pages;
use App\Filament\Admin\Resources\SesionDetalleResource\RelationManagers;
use App\Models\SesionDetalle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesionDetalleResource extends Resource
{
    protected static ?string $model = SesionDetalle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sesion_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('competencia_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('capacidad_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('criterio_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('desempeno_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('evidencia')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('instrumento')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sesion_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('competencia_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacidad_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('criterio_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('desempeno_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSesionDetalles::route('/'),
            'create' => Pages\CreateSesionDetalle::route('/create'),
            'edit' => Pages\EditSesionDetalle::route('/{record}/edit'),
        ];
    }
}
