<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EvaluacionResource\Pages;
use App\Filament\Admin\Resources\EvaluacionResource\RelationManagers;
use App\Exports\HistorialEstudiantesExport;
use App\Models\Archivo;
use App\Models\Evaluacion;
use App\Models\Sesion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class EvaluacionResource extends Resource
{
    use Translatable;
    protected static ?string $model = Evaluacion::class;
    protected static ?string $navigationGroup = 'Gestión de estudiantes';
    protected static ?string $navigationLabel = 'Evaluaciones';
    protected static ?string $label = 'Evaluaciones';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sesiones')
                    ->columns(2)
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
                        // Campo real que guarda el ID del docente 
                        Forms\Components\TextInput::make('user_id')
                            ->label('Docente ID')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                    ]),
                Forms\Components\Toggle::make('es_supervisado')
                    ->required(),
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_creacion')
                    ->label('Fecha de creación')
                    ->default(now())
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('cantidad_preguntas')
                    ->label('Cantidad de preguntas')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(20)
                    ->required(),
                Forms\Components\TextInput::make('cantidad_intentos')
                    ->label('Cantidad de intentos')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sesion.titulo')
                    ->label('Título de Sesión')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('docente.persona.nombre_completo')
                    ->label('Nombre del Docente')
                    ->getStateUsing(function ($record) {
                        return optional($record->docente->persona)->nombre . ' ' . optional($record->docente->persona)->apellido;
                    })
                    ->sortable(),
                Tables\Columns\IconColumn::make('es_supervisado')
                    ->boolean(),
                TextColumn::make('titulo')
                    ->searchable()
                    ->label('Título de Evaluación'),
                TextColumn::make('cantidad_preguntas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cantidad_intentos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fecha_creacion')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('exportarHistorial')
                    ->label('Exportar excel')
                    ->icon('heroicon-o-table-cells')
                    ->action(function ($record) {
                        return Excel::download(new HistorialEstudiantesExport($record->id), 'historial_estudiantes.xlsx');
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
