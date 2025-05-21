<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EvaluacionResource\Pages;
use App\Filament\Admin\Resources\EvaluacionResource\RelationManagers;
use App\Models\Evaluacion;
use App\Models\Sesion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvaluacionResource extends Resource
{
    protected static ?string $model = Evaluacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Archivo')
                    ->description('Carga el archivo necesario para la evaluación.')
                    ->schema([
                        Forms\Components\Fieldset::make('Archivo')
                            ->relationship('archivo')
                            ->columns(2)
                            ->schema([
                                Forms\Components\FileUpload::make('url')
                                    ->label('Archivo')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                                    ->directory('temporales')
                                    ->preserveFilenames()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if (is_string($state)) {
                                            $extension = pathinfo($state, PATHINFO_EXTENSION);
                                        } elseif (is_object($state) && method_exists($state, 'getClientOriginalExtension')) {
                                            $extension = strtolower($state->getClientOriginalExtension());
                                        } else {
                                            $extension = null;
                                        }

                                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                            $set('tipo', 'imagen');
                                        } elseif ($extension === 'pdf') {
                                            $set('tipo', 'pdf');
                                        } else {
                                            $set('tipo', 'desconocido');
                                        }
                                    }),

                                Forms\Components\TextInput::make('tipo')
                                    ->label('Tipo de archivo')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                    ]),

                Forms\Components\Section::make('Sesiones')
                    ->description('Selecciona la sesión a la que pertenece esta evaluación.')
                    ->schema([
                        // Select para elegir la sesión
                        Forms\Components\Select::make('sesion_id')
                            ->label('Sesión')
                            ->options(Sesion::all()->pluck('titulo', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $sesion = Sesion::with('aulaCurso.aula.users.roles', 'aulaCurso.curso')->find($state);
                                $aula = $sesion?->aulaCurso?->aula;
                                $curso = $sesion?->aulaCurso?->curso;
                                $docente = $aula?->docente;

                                $set('user_id', $docente?->id);
                                $set('docente_nombre', $docente?->persona?->nombre . ' ' . $docente?->persona?->apellido ?? 'Sin asignar');
                                $set('aula_info', $aula?->grado_seccion ?? 'Sin aula');
                                $set('curso_nombre', $curso?->curso ?? 'Sin curso');
                            })
                            ->required(),

                        // Mostrar nombre del docente (solo lectura)
                        Forms\Components\TextInput::make('docente_nombre')
                            ->label('Docente')
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive(),

                        // Mostrar información del aula (solo lectura)
                        Forms\Components\TextInput::make('aula_info')
                            ->label('Aula')
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive(),

                        // Mostrar nombre del curso (solo lectura)
                        Forms\Components\TextInput::make('curso_nombre')
                            ->label('Curso')
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive(),

                        // Campo real que guarda el ID del docente (hidden o disabled)
                        Forms\Components\TextInput::make('user_id')
                            ->label('Docente ID')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                    ]),
                    
                Forms\Components\TextInput::make('modo')
                    ->required(),
                Forms\Components\Toggle::make('es_supervisado')
                    ->required(),
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_creacion')
                    ->required(),

                Forms\Components\TextInput::make('cantidad_preguntas')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sesion_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modo'),
                Tables\Columns\IconColumn::make('es_supervisado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_creacion')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad_preguntas')
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
                Tables\Columns\TextColumn::make('archivo_id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListEvaluacions::route('/'),
            'create' => Pages\CreateEvaluacion::route('/create'),
            'edit' => Pages\EditEvaluacion::route('/{record}/edit'),
        ];
    }
}
