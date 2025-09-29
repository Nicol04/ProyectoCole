<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EstandarResource\Pages;
use App\Filament\Admin\Resources\EstandarResource\RelationManagers;
use App\Models\Estandar;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstandarResource extends Resource
{
    protected static ?string $model = Estandar::class;
    protected static ?string $navigationGroup = 'Currículo';
    protected static ?string $navigationLabel = 'Estándares';
    
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('curso_id')
                    ->label('Curso')
                    ->options(\App\Models\Curso::pluck('curso', 'id'))
                    ->reactive()
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(fn(callable $set) => $set('competencia_id', null))
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        if ($record && $record->competencia) {
                            $set('curso_id', $record->competencia->curso_id);
                        }
                    }),


                // Seleccionar competencia según curso
                Select::make('competencia_id')
                    ->label('Competencia')
                    ->options(function (callable $get) {
                        $cursoId = $get('curso_id');
                        if (!$cursoId) {
                            return [];
                        }
                        return \App\Models\Competencia::where('curso_id', $cursoId)
                            ->pluck('nombre', 'id');
                    })
                    ->reactive()
                    ->searchable()
                    ->required()
                    ->disabled(fn(callable $get) => !$get('curso_id')),


                TextInput::make('ciclo')
                    ->label('Ciclo')
                    ->required(),

                Textarea::make('descripcion')
                    ->label('Descripción del estándar')
                    ->required()
                    ->rows(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ciclo')->sortable()->searchable(),
                TextColumn::make('descripcion')->limit(50)->wrap(),
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
            'index' => Pages\ListEstandars::route('/'),
            'create' => Pages\CreateEstandar::route('/create'),
            'edit' => Pages\EditEstandar::route('/{record}/edit'),
        ];
    }
}
