<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RubricaResource\Pages;
use App\Filament\Admin\Resources\RubricaResource\RelationManagers;
use App\Models\Rubrica;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RubricaResource extends Resource
{
    protected static ?string $model = Rubrica::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sesion_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('criterio_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('descripcion')
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
                Tables\Columns\TextColumn::make('criterio_id')
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
            'index' => Pages\ListRubricas::route('/'),
            'create' => Pages\CreateRubrica::route('/create'),
            'edit' => Pages\EditRubrica::route('/{record}/edit'),
        ];
    }
}
