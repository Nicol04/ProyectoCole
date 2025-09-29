<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompetenciaResource\Pages;
use App\Filament\Admin\Resources\CompetenciaResource\RelationManagers;
use App\Models\Competencia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompetenciaResource extends Resource
{
    protected static ?string $model = Competencia::class;
    protected static ?string $navigationGroup = 'Currículo';
    protected static ?string $navigationLabel = 'Competencias';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Competencia')
                    ->schema([
                        Forms\Components\Select::make('curso_id')
                            ->relationship('curso', 'curso')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Curso'),
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre de la Competencia'),
                        Forms\Components\Textarea::make('descripcion')
                            ->columnSpanFull()
                            ->label('Descripción'),
                    ]),

                Forms\Components\Section::make('Capacidades')
                    ->schema([
                        Forms\Components\Repeater::make('capacidades')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nombre de la Capacidad'),
                                Forms\Components\Textarea::make('descripcion')
                                    ->label('Descripción de la Capacidad'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Agregar Capacidad')
                            ->label('Capacidades'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso.curso')
                    ->sortable()
                    ->searchable()
                    ->label('Curso'),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->limit(50)
                    ->label('Competencia'),
                Tables\Columns\TextColumn::make('capacidades_count')
                    ->counts('capacidades')
                    ->label('N° Capacidades'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('curso')
                    ->relationship('curso', 'curso')
                    ->preload()
                    ->label('Filtrar por Curso'),
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
            RelationManagers\CapacidadesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetencias::route('/'),
            'create' => Pages\CreateCompetencia::route('/create'),
            'edit' => Pages\EditCompetencia::route('/{record}/edit'),
        ];
    }
}
