<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AulaResource\Pages;
use App\Filament\Admin\Resources\AulaResource\RelationManagers;
use App\Filament\Admin\Resources\AulaResource\RelationManagers\CursosRelationManager;
use App\Filament\Admin\Resources\AulaResource\RelationManagers\UsersRelationManager;
use App\Models\Aula;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AulaResource extends Resource
{
    protected static ?string $model = Aula::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('grado')
                    ->required()
                    ->options([
                        '5' => '5',
                        '6' => '6',
                    ])
                    ->label('Grado'),

                Forms\Components\Select::make('seccion')
                    ->required()
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                    ])
                    ->label('Sección'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grado'),
                Tables\Columns\TextColumn::make('seccion'),
                Tables\Columns\TextColumn::make('cantidad_usuarios')
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
                Tables\Actions\ViewAction::make(),
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
            UsersRelationManager::class,
            CursosRelationManager::class,
        ];
    }
    public static function relationManagers(): array
    {
        return [
            UsersRelationManager::class,
            CursosRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAulas::route('/'),
            'create' => Pages\CreateAula::route('/create'),
            'edit' => Pages\EditAula::route('/{record}/edit'),
            'ver-sesiones' => Pages\VerSesiones::route('/{record}/ver-sesiones/{cursoId}'),
            'crear-sesion' => Pages\CrearSesion::route('/{record}/crear-sesion/{cursoId}'),
            'editar-sesion' => Pages\EditarSesion::route('/editar-sesion/{record}'),
        ];
    }
}
