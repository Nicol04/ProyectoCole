<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SesionResource\Pages;
use App\Filament\Admin\Resources\SesionResource\RelationManagers;
use App\Models\Sesion;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesionResource extends Resource
{
    use Translatable;
    protected static ?string $model = Sesion::class;
    protected static ?string $navigationLabel = 'Sesiones';
    protected static ?string $label = 'Sesiones';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('fecha')
                    ->label('Fecha de sesión')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                        if ($state) {
                            $fecha = \Carbon\Carbon::parse($state)->locale('es');
                            $dia = ucfirst($fecha->isoFormat('dddd'));
                            $set('dia', $dia);
                        }
                    }),

                TextInput::make('dia')
                    ->label('Día')
                    ->readOnly()
                    ->reactive()
                    ->dehydrated(),

                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('objetivo')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('actividades')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Section::make('Datos de las aulas')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('grado')
                            ->label('Grado')
                            ->options(
                                \App\Models\Aula::query()->pluck('grado', 'grado')->unique()
                            )
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(fn($state, $set) => $set('seccion', null)),

                        Forms\Components\Select::make('seccion')
                            ->label('Sección')
                            ->options(
                                fn(callable $get) =>
                                \App\Models\Aula::where('grado', $get('grado'))
                                    ->pluck('seccion', 'seccion')
                            )
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $grado = $get('grado');
                                if ($grado && $state) {
                                    $aula = \App\Models\Aula::where('grado', $grado)
                                        ->where('seccion', $state)
                                        ->first();

                                    $set('aula_id', $aula?->id ?? null);
                                    $set('aula_curso_id', null);
                                }
                            }),

                        TextInput::make('aula_id')
                            ->label('ID Aula')
                            ->disabled()
                            ->dehydrated()
                            ->reactive(),

                        Forms\Components\Select::make('aula_curso_id')
                            ->label('Curso')
                            ->options(function (callable $get) {
                                $aulaId = $get('aula_id');
                                if (!$aulaId) return [];
                                return \App\Models\AulaCurso::where('aula_id', $aulaId)
                                    ->with('curso')
                                    ->get()
                                    ->pluck('curso.curso', 'id');
                            })
                            ->required()
                            ->reactive(),

                        Forms\Components\TextInput::make('aula_curso_id')
                            ->numeric()
                            ->reactive()
                            ->disabled()
                            ->dehydrated()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aulaCurso.aula.grado_seccion')
                    ->label('Aula'),
                Tables\Columns\TextColumn::make('aulaCurso.curso.curso')
                    ->label('Curso'),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aulaCurso.aula.docente.persona.nombre')
                    ->label('Docente')
                    ->formatStateUsing(fn ($state, $record) =>
                        optional($record->aulaCurso?->aula?->docente?->persona)->nombre ?? 'Sin docente'),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSesions::route('/'),
            'create' => Pages\CreateSesion::route('/create'),
            'edit' => Pages\EditSesion::route('/{record}/edit'),
        ];
    }
}
