<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CalificacionResource\Pages;
use App\Filament\Admin\Resources\CalificacionResource\RelationManagers;
use App\Models\Aula;
use App\Models\Calificacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalificacionResource extends Resource
{
    use Translatable;
    protected static ?string $model = Calificacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationLabel = 'Calificaciones';
    protected static ?string $label = 'Calificaciones';
    protected static ?string $navigationGroup = 'Gestión de estudiantes';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('intento_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('puntaje_total')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('retroalimentacion')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('fecha')
                    ->required(),
                Forms\Components\TextInput::make('puntaje_maximo')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('porcentaje')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('estado')
                    ->required()
                    ->maxLength(255)
                    ->default('pendiente'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('intento.evaluacion.titulo')
                    ->label('Evaluación')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('intento.usuario.persona.nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('intento.usuario.persona.apellido')
                    ->label('Apellido')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('numero_intento')
                    ->label('Intento')
                    ->state(function ($record) {
                        $intentoId = $record->intento_id;
                        $userId = $record->intento->user_id ?? null;
                        $evaluacionId = $record->intento->evaluacion_id ?? null;

                        if (!$userId || !$evaluacionId) {
                            return '-';
                        }

                        $intentos = \App\Models\IntentoEvaluacion::where('user_id', $userId)
                            ->where('evaluacion_id', $evaluacionId)
                            ->orderBy('created_at')
                            ->pluck('id')
                            ->toArray();

                        $posicion = array_search($intentoId, $intentos);
                        return $posicion !== false ? ($posicion + 1) . '° intento' : '-';
                    }),

                TextColumn::make('puntaje_total')
                    ->label('Puntaje')
                    ->sortable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match (strtolower($state)) {
                        'aprobado' => 'success',
                        'desaprobado' => 'danger',
                        'pendiente' => 'gray',
                        default => 'warning',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('intento.evaluacion.sesion.aulaCurso.aula.grado_seccion')
                    ->label('Aula')
                    ->sortable(),

                TextColumn::make('intento.evaluacion.sesion.aulaCurso.curso.curso')
                    ->label('Curso')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('aula')
                    ->label('Filtrar por Aula')
                    ->options(
                        fn() =>
                        \App\Models\Aula::all()->pluck('grado_seccion', 'id')
                    )
                    ->attribute('aula') // Esto es obligatorio si usas modifyQueryUsing
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        if (blank($state['value'])) return;

                        $query->whereHas('intento.evaluacion.sesion.aulaCurso', function ($q) use ($state) {
                            $q->where('aula_id', $state['value']);
                        });
                    }),
                SelectFilter::make('estado')
                    ->label('Filtrar por Estado')
                    ->options([
                        'aprobado' => 'Aprobado',
                        'desaprobado' => 'Desaprobado',
                    ])
                    ->attribute('estado') // Necesario si usas modifyQueryUsing
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        if (blank($state['value'])) return;

                        $query->where('estado', $state['value']);
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCalificacions::route('/'),
            'edit' => Pages\EditCalificacion::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
