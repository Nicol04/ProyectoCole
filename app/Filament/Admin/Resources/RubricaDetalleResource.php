<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RubricaDetalleResource\Pages;
use App\Filament\Admin\Resources\RubricaDetalleResource\RelationManagers;
use App\Models\RubricaDetalle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RubricaDetalleResource extends Resource
{
    protected static ?string $model = RubricaDetalle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rubrica_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nivel')
                    ->required(),
                Forms\Components\Textarea::make('descriptor')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rubrica_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nivel'),
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
            'index' => Pages\ListRubricaDetalles::route('/'),
            'create' => Pages\CreateRubricaDetalle::route('/create'),
            'edit' => Pages\EditRubricaDetalle::route('/{record}/edit'),
        ];
    }
}
