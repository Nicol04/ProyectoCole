<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompetenciaTransversalResource\Pages;
use App\Filament\Admin\Resources\CompetenciaTransversalResource\RelationManagers;
use App\Models\CompetenciaTransversal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompetenciaTransversalResource extends Resource
{
    protected static ?string $model = CompetenciaTransversal::class;
    protected static ?string $navigationGroup = 'Currículo';
protected static ?string $navigationLabel = 'Competencias transversales';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')->required(),
                Forms\Components\Textarea::make('descripcion'),
                Forms\Components\Section::make('Capacidades transversales')
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
                Tables\Columns\TextColumn::make('nombre')->searchable(),
                Tables\Columns\TextColumn::make('descripcion')->limit(50),
                Tables\Columns\TextColumn::make('capacidades_count')
                    ->counts('capacidades')
                    ->label('N° Capacidades'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetenciaTransversals::route('/'),
            'create' => Pages\CreateCompetenciaTransversal::route('/create'),
            'edit' => Pages\EditCompetenciaTransversal::route('/{record}/edit'),
        ];
    }
}
