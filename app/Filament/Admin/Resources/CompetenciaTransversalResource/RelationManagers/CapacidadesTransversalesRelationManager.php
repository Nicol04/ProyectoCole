<?php

namespace App\Filament\Admin\Resources\CompetenciaTransversalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CapacidadesTransversalesRelationManager extends RelationManager
{
    protected static string $relationship = 'capacidades';
    protected static ?string $title = 'Capacidades Transversales';
    protected static ?string $recordTitleAttribute = 'nombre';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Capacidad transversal')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre de la Capacidad transversal'),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción'),
                    ]),

                Forms\Components\Section::make('Desempeños')
                    ->schema([
                        Forms\Components\Section::make('Desempeños')
                            ->schema([
                                Forms\Components\Repeater::make('desempenos')
                                    ->relationship('desempenos') // usa la relación definida en CapacidadTransversal
                                    ->schema([
                                        Forms\Components\Select::make('estandar_id')
                                            ->label('Estándar')
                                            ->options(function (callable $get) {
                                                $capacidadTransversalId = $get('../../id');
                                                if (!$capacidadTransversalId) {
                                                    return [];
                                                }

                                                // Buscar la competencia transversal desde esta capacidad transversal
                                                $competenciaTransversalId = \App\Models\CapacidadTransversal::find($capacidadTransversalId)?->competencia_transversal_id;

                                                if (!$competenciaTransversalId) {
                                                    return [];
                                                }

                                                return \App\Models\Estandar::where('competencia_transversal_id', $competenciaTransversalId)
                                                    ->pluck('ciclo', 'id');
                                            })
                                            ->required()
                                            ->reactive()
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\Select::make('grado')
                                            ->required()
                                            ->options([
                                                '1° grado' => '1° grado',
                                                '2° grado' => '2° grado',
                                                '3° grado' => '3° grado',
                                                '4° grado' => '4° grado',
                                                '5° grado' => '5° grado',
                                                '6° grado' => '6° grado',
                                            ])
                                            ->label('Grado')
                                            ->searchable(),
                                        Forms\Components\Textarea::make('descripcion')
                                            ->required()
                                            ->label('Descripción del Desempeño')
                                            ->columnSpanFull()
                                            ->rows(3),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->addActionLabel('Agregar Desempeño')
                                    ->collapsible(),

                            ])
                            ->collapsible()
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Capacidad')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('desempenos_count')
                    ->counts('desempenos')
                    ->label('N° Desempeños'),
            ])
            ->filters([])
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
