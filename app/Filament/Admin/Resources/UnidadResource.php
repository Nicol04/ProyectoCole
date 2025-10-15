<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UnidadResource\Pages;
use App\Models\Unidad;
use App\Models\Aula;
use App\Models\Curso;
use App\Models\Competencia;
use App\Models\EnfoqueTransversal;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UnidadResource extends Resource
{
    protected static ?string $model = Unidad::class;
    protected static ?string $label = 'Unidades';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // 🟦 SECCIÓN 1: DATOS GENERALES DE LA UNIDAD
            Forms\Components\Section::make('Datos Generales de la Unidad')
                ->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre de la Unidad')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('fecha_inicio')
                            ->label('Fecha de inicio')
                            ->required(),
                        Forms\Components\DatePicker::make('fecha_fin')
                            ->label('Fecha de fin')
                            ->required(),
                    ]),

                    Forms\Components\Select::make('grado')
                        ->label('Grado')
                        ->options(
                            \App\Models\Aula::query()
                                ->select('grado')
                                ->distinct()
                                ->pluck('grado', 'grado')
                        )
                        ->searchable()
                        ->reactive()
                        ->required()
                        ->helperText('Selecciona el grado para listar los docentes disponibles.'),

                    Forms\Components\Select::make('profesores_responsables')
                        ->label('Profesores responsables')
                        ->multiple()
                        ->options(function (callable $get) {
                            $grado = $get('grado');
                            if (!$grado) {
                                return [];
                            }

                            // Buscar aulas del grado seleccionado
                            $aulasIds = \App\Models\Aula::where('grado', $grado)->pluck('id');

                            // Buscar usuarios con rol docente en esas aulas
                            return \App\Models\User::whereHas('usuario_aulas', function ($q) use ($aulasIds) {
                                $q->whereIn('aula_id', $aulasIds);
                            })
                                ->whereHas('roles', fn($r) => $r->where('name', 'docente'))
                                ->with('persona')
                                ->get()
                                ->mapWithKeys(function ($user) {
                                    $persona = $user->persona;
                                    $nombreCompleto = trim(($persona?->nombre ?? '') . ' ' . ($persona?->apellido ?? ''));
                                    return [$user->id => $nombreCompleto ?: 'Docente sin nombre'];
                                });
                        })
                        ->reactive()
                        ->searchable()
                        ->preload()
                        ->helperText('Selecciona los docentes que pertenecen al grado elegido.')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('situacion_significativa')
                        ->label('Situación significativa')
                        ->rows(4)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('productos')
                        ->label('Productos esperados')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),

            Forms\Components\Section::make('Contenido Curricular')
                ->schema([
                    Forms\Components\Builder::make('contenido')
                        ->label('Cursos y Competencias')
                        ->blocks([
                            Forms\Components\Builder\Block::make('curso')
                                ->label('Curso')
                                ->schema([
                                    // 📘 Selecciona curso según el grado elegido
                                    Forms\Components\Select::make('curso_id')
                                        ->label('Curso')
                                        ->options(
                                            \App\Models\Curso::query()
                                                ->orderBy('curso')
                                                ->pluck('curso', 'id')
                                        )
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->helperText('Selecciona un curso.'),

                                    // 🧠 Competencias del curso
                                    Forms\Components\Repeater::make('competencias')
                                        ->label('Competencias del curso')
                                        ->schema([
                                            Forms\Components\Select::make('competencia_id')
                                                ->label('Competencia')
                                                ->options(function (callable $get) {
                                                    // Obtener el curso actual
                                                    $cursoId = $get('../../curso_id');
                                                    if (!$cursoId) return [];

                                                    // Obtener todas las competencias del curso
                                                    $competencias = \App\Models\Competencia::where('curso_id', $cursoId)
                                                        ->pluck('nombre', 'id');

                                                    // Obtener las competencias ya seleccionadas dentro del mismo Repeater
                                                    $todasCompetencias = $get('../../competencias') ?? [];

                                                    $competenciasSeleccionadas = collect($todasCompetencias)
                                                        ->pluck('competencia_id')
                                                        ->filter()
                                                        ->toArray();

                                                    // Filtrar para mostrar solo las no seleccionadas
                                                    return $competencias->reject(fn($_, $id) => in_array($id, $competenciasSeleccionadas));
                                                })
                                                ->reactive()
                                                ->required()
                                                ->searchable()
                                                ->afterStateUpdated(function (callable $set) {
                                                    $set('capacidades', []);
                                                    $set('desempenos', []);
                                                }),

                                            // 🟦 Capacidades dependientes de la competencia
                                            Forms\Components\Select::make('capacidades')
                                                ->label('Capacidades')
                                                ->multiple()
                                                ->options(function (callable $get) {
                                                    $competenciaId = $get('competencia_id');
                                                    if (!$competenciaId) return [];

                                                    return \App\Models\Capacidad::where('competencia_id', $competenciaId)
                                                        ->pluck('nombre', 'id');
                                                })
                                                ->reactive()
                                                ->searchable()
                                                ->placeholder('Seleccione una o más capacidades')
                                                ->preload()
                                                ->afterStateUpdated(function (callable $set) {
                                                    $set('desempenos', []);
                                                }),

                                            Forms\Components\Select::make('desempenos')
                                                ->label('Desempeños')
                                                ->multiple()
                                                ->options(function (callable $get, $state) {
                                                    $capacidadesIds = $get('capacidades');
                                                    $grado = $get('../../../../../grado');

                                                    if (!$capacidadesIds || empty($capacidadesIds)) {
                                                        return [];
                                                    }
                                                    $gradoLimpio = preg_replace('/[^0-9]/', '', $grado);
                                                    return \App\Models\Desempeno::whereIn('capacidad_id', (array) $capacidadesIds)
                                                        ->where('grado', 'LIKE', "%{$gradoLimpio}%") // 🔍 filtra por grado
                                                        ->pluck('descripcion', 'id');
                                                })
                                                ->reactive()
                                                ->searchable()
                                                ->placeholder('Selecciona antes un grado y una capacidad para cargar los desempeños relacionados')
                                                ->preload(),

                                            Forms\Components\Textarea::make('criterios')
                                                ->label('Criterios de Evaluación')
                                                ->rows(3),

                                            Forms\Components\Textarea::make('evidencias')
                                                ->label('Evidencias')
                                                ->rows(2),

                                            Forms\Components\Select::make('instrumentos_predefinidos')
                                                ->label('Instrumentos (predefinidos)')
                                                ->multiple()
                                                ->options([
                                                    'Rúbrica' => 'Rúbrica',
                                                    'Lista de cotejo' => 'Lista de cotejo',
                                                    'Guía de observación' => 'Guía de observación',
                                                    'Portafolio' => 'Portafolio',
                                                    'Registro anecdótico' => 'Registro anecdótico',
                                                    'Escala valorativa' => 'Escala valorativa',
                                                    'Personalizado' => 'Personalizado'
                                                ])
                                                ->searchable()
                                                ->live()
                                                ->columnSpanFull(),

                                            TagsInput::make('instrumentos_personalizados')
                                                ->label('Instrumentos personalizados')
                                                ->placeholder('Escribe un instrumento y presiona Enter')
                                                ->columnSpanFull()
                                                ->hidden(fn(callable $get) => !in_array('Personalizado', $get('instrumentos_predefinidos') ?? [])), // Se muestra solo si "Personalizado" está seleccionado

                                            Hidden::make('instrumentos')
                                                ->dehydrated()
                                                ->default([]),
                                        ])
                                        ->collapsible()
                                        ->createItemButtonLabel('Agregar Competencia'),
                                ])
                                ->columns(1),
                        ])
                        ->collapsible()
                        ->columnSpanFull(),
                ])
                ->collapsible(),
            // 🟧 SECCIÓN 3: ENFOQUES TRANSVERSALES
            Forms\Components\Section::make('Enfoques Transversales')
                ->schema([
                    Forms\Components\Repeater::make('enfoques')
                        ->label('Enfoques Transversales')
                        ->schema([
                            Forms\Components\Select::make('enfoque_id')
                                ->label('Seleccionar Enfoque')
                                ->options(\App\Models\EnfoqueTransversal::pluck('nombre', 'id'))
                                ->searchable()
                                ->placeholder('Seleccione un enfoque')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn($state, callable $set) => $set('valores', [])),

                            Forms\Components\Repeater::make('valores')
                                ->label('Valores y Actitudes')
                                ->helperText('Selecciona un valor para autocompletar su actitud o agrega nuevos.')
                                ->schema([
                                    Forms\Components\Select::make('valor')
                                        ->label('Valor')
                                        ->options(function (callable $get) {
                                            $enfoqueId = $get('../../enfoque_id');
                                            if (!$enfoqueId) return [];

                                            $enfoque = \App\Models\EnfoqueTransversal::find($enfoqueId);
                                            if (!$enfoque || empty($enfoque->valores_actitudes)) return [];

                                            return collect($enfoque->valores_actitudes)
                                                ->pluck('data.Valores', 'data.Valores')
                                                ->toArray();
                                        })
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            $enfoqueId = $get('../../enfoque_id');
                                            if (!$enfoqueId || !$state) return;

                                            $enfoque = \App\Models\EnfoqueTransversal::find($enfoqueId);
                                            if ($enfoque && $enfoque->valores_actitudes) {
                                                $valorData = collect($enfoque->valores_actitudes)
                                                    ->firstWhere('data.Valores', $state);

                                                if ($valorData) {
                                                    $set('actitud', $valorData['data']['Actitudes'] ?? '');
                                                }
                                            }
                                        })
                                        ->placeholder('Seleccione o escriba un valor')
                                        ->searchable()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('nuevo_valor')
                                                ->label('Nuevo valor')
                                                ->required(),
                                        ])
                                        ->createOptionUsing(function (array $data, callable $set, callable $get) {
                                            // 🔹 Agregar el nuevo valor al listado actual
                                            $nuevoValor = $data['nuevo_valor'];
                                            $enfoqueId = $get('../../enfoque_id');

                                            if ($enfoqueId && $nuevoValor) {
                                                $enfoque = \App\Models\EnfoqueTransversal::find($enfoqueId);
                                                if ($enfoque) {
                                                    $valoresActitudes = $enfoque->valores_actitudes ?? [];
                                                    $valoresActitudes[] = [
                                                        'data' => [
                                                            'Valores' => $nuevoValor,
                                                            'Actitudes' => '',
                                                        ],
                                                    ];
                                                    $enfoque->valores_actitudes = $valoresActitudes;
                                                    $enfoque->save();
                                                }
                                            }

                                            return $nuevoValor; // lo devuelve como opción seleccionada
                                        }),

                                    Forms\Components\Textarea::make('actitud')
                                        ->label('Actitud')
                                        ->rows(2)
                                        ->placeholder('Se completará automáticamente o puede editarla.'),
                                ])
                                ->columns(2)
                                ->collapsed(false)
                                ->addActionLabel('Agregar Valor y Actitud'),
                        ])
                        ->columns(1)
                        ->collapsed(false)
                        ->addActionLabel('Agregar Enfoque'),
                ])
                ->collapsed(false)
                ->collapsible(),
            // 🟩 SECCIÓN 4: MATERIALES Y RECURSOS
            Forms\Components\Section::make('Materiales y Recursos')
                ->schema([
                    Forms\Components\Textarea::make('materiales_basicos')
                        ->label('Materiales básicos a utilizar en la unidad')
                        ->rows(3)
                        ->placeholder('Ejemplo: Cartulinas, marcadores, papel bond, témperas, etc.')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('recursos')
                        ->label('Recursos a utilizar en la unidad')
                        ->rows(3)
                        ->placeholder('Ejemplo: Aula virtual, videos educativos, material impreso, pizarra digital, etc.')
                        ->columnSpanFull(),
                ])
                ->collapsed(false)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Unidad')->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')->date(),
                Tables\Columns\TextColumn::make('fecha_fin')->date(),
                Tables\Columns\TextColumn::make('grado')->label('Grado')->sortable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnidads::route('/'),
            'create' => Pages\CreateUnidad::route('/create'),
            'edit' => Pages\EditUnidad::route('/{record}/edit'),
        ];
    }
}
