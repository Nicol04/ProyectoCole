<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SesionMomentoResource\Pages;
use App\Filament\Admin\Resources\SesionMomentoResource\RelationManagers;
use App\Models\SesionMomento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesionMomentoResource extends Resource
{
    protected static ?string $model = SesionMomento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sesion_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('momento')
                    ->required(),
                Forms\Components\Textarea::make('estrategia')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('descripcion_actividad')
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
                Tables\Columns\TextColumn::make('momento'),
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
            'index' => Pages\ListSesionMomentos::route('/'),
            'create' => Pages\CreateSesionMomento::route('/create'),
            'edit' => Pages\EditSesionMomento::route('/{record}/edit'),
        ];
    }
}
