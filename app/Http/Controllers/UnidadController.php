<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\AulaCurso;
use App\Models\Competencia;
use App\Models\Desempeno;
use App\Models\EnfoqueTransversal;
use App\Models\Unidad;
use App\Models\UnidadDetalle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = (string)$user->id;
        $unidades = Unidad::where(function ($query) use ($userId) {
            $query->whereJsonContains('profesores_responsables', $userId)
                ->orWhereJsonContains('profesores_responsables', (int)$userId)
                ->orWhere('profesores_responsables', 'LIKE', '%"' . $userId . '"%');
        })
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(8);

        return view('panel.unidades.index', compact('unidades'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $cursos = collect();
        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');
        $aula_curso_id = $request->query('aula_curso_id'); // Obtener el aula_curso_id si existe
        $curso = null;
        $competencias = collect();
        $disableCursoSelect = false;

        // Si se selecciona un aula_curso_id, obtener el curso y sus competencias
        if ($aula_curso_id) {
            $aulaCurso = AulaCurso::findOrFail($aula_curso_id); // Buscar el aula_curso
            $curso = $aulaCurso->curso; // Obtener el curso relacionado
            $competencias = Competencia::where('curso_id', $curso->id)
                ->select('id', 'nombre', 'descripcion')
                ->get(); // Obtener competencias del curso
            $disableCursoSelect = true;
        }

        $docente = $user;

        // Obtener el grado del docente autenticado (según su aula)
        $grado = $docente->usuario_aulas()->first()?->aula?->grado ?? 'Sin grado';

        // Buscar docentes del mismo grado (excepto el actual)
        $aulasIds = Aula::where('grado', $grado)->pluck('id');

        $docentes = User::whereHas('usuario_aulas', function ($q) use ($aulasIds) {
            $q->whereIn('aula_id', $aulasIds);
        })
            ->whereHas('roles', fn($r) => $r->where('name', 'docente'))
            ->where('id', '!=', $docente->id)
            ->with('persona')
            ->get()
            ->mapWithKeys(function ($user) {
                $persona = $user->persona;
                $nombreCompleto = trim(($persona?->nombre ?? '') . ' ' . ($persona?->apellido ?? ''));
                return [$user->id => $nombreCompleto ?: 'Docente sin nombre'];
            });

        // Obtener enfoques transversales
        $enfoques = EnfoqueTransversal::select('id', 'nombre', 'valores_actitudes')
            ->get()
            ->map(function ($enfoque) {
                $valores = [];

                // Si valores_actitudes es un array, procesarlo
                if (is_array($enfoque->valores_actitudes)) {
                    $valores = $enfoque->valores_actitudes;
                } else if (is_string($enfoque->valores_actitudes)) {
                    // Si es string, intentar decodificar JSON
                    $decoded = json_decode($enfoque->valores_actitudes, true);
                    $valores = is_array($decoded) ? $decoded : [];
                }

                return [
                    'id' => $enfoque->id,
                    'nombre' => $enfoque->nombre,
                    'valores' => $valores
                ];
            });

        return view('panel.unidades.create', compact(
            'grado',
            'docentes',
            'cursos',
            'aula_curso_id',
            'curso',
            'competencias',
            'disableCursoSelect',
            'enfoques'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'grado' => 'required|string|max:255',
            'profesores_responsables' => 'required|array|min:1',
            'profesores_responsables.*' => 'required|exists:users,id',
            'situacion_significativa' => 'required|string|min:10',
            'productos' => 'required|string|min:10',
            'contenido' => 'required|array|min:1',
            'contenido.cursos' => 'required|array|min:1',
            'contenido.cursos.*.competencias' => 'required|array|min:1',
            'materiales_basicos' => 'required|string|min:5',
            'recursos' => 'required|string|min:5',
            'enfoques' => 'required|array|min:1',
            'enfoques.*.enfoque_id' => 'required|exists:enfoque_transversales,id',
            'enfoques.*.valores' => 'required|array|min:1',
            'enfoques.*.valores.*.valor' => 'required|string',
            'enfoques.*.valores.*.actitud' => 'required|string',
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre de la unidad es obligatorio.',
            'nombre.max' => 'El nombre de la unidad no puede exceder 255 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'profesores_responsables.required' => 'Debe seleccionar al menos un profesor responsable.',
            'profesores_responsables.min' => 'Debe seleccionar al menos un profesor responsable.',
            'situacion_significativa.required' => 'La situación significativa es obligatoria.',
            'situacion_significativa.min' => 'La situación significativa debe tener al menos 10 caracteres.',
            'productos.required' => 'Los productos esperados son obligatorios.',
            'productos.min' => 'Los productos esperados deben tener al menos 10 caracteres.',
            'contenido.required' => 'Debe agregar al menos un contenido curricular.',
            'contenido.cursos.required' => 'Debe agregar al menos un curso.',
            'contenido.cursos.min' => 'Debe agregar al menos un curso.',
            'contenido.cursos.*.competencias.required' => 'Cada curso debe tener al menos una competencia.',
            'contenido.cursos.*.competencias.min' => 'Cada curso debe tener al menos una competencia.',
            'materiales_basicos.required' => 'Los materiales básicos son obligatorios.',
            'materiales_basicos.min' => 'Los materiales básicos deben tener al menos 5 caracteres.',
            'recursos.required' => 'Los recursos son obligatorios.',
            'recursos.min' => 'Los recursos deben tener al menos 5 caracteres.',
            'enfoques.required' => 'Debe agregar al menos un enfoque transversal.',
            'enfoques.min' => 'Debe agregar al menos un enfoque transversal.',
            'enfoques.*.enfoque_id.required' => 'Debe seleccionar un enfoque transversal.',
            'enfoques.*.valores.required' => 'Cada enfoque debe tener al menos un valor.',
            'enfoques.*.valores.min' => 'Cada enfoque debe tener al menos un valor.',
            'enfoques.*.valores.*.valor.required' => 'El valor es obligatorio.',
            'enfoques.*.valores.*.actitud.required' => 'La actitud es obligatoria.',
        ]);

        $docenteAuth = Auth::user();
        $profesores = $request->profesores_responsables;

        // Asegurar que todos los IDs sean strings y agregar el docente actual
        $profesores = array_map('strval', $profesores);
        $profesores[] = (string) $docenteAuth->id;

        // Eliminar duplicados y reindexar
        $profesores = array_values(array_unique($profesores));

        // 🔹 Obtener las secciones correspondientes a cada docente
        $secciones = \App\Models\User::whereIn('id', $profesores)
            ->with('usuario_aulas.aula')
            ->get()
            ->flatMap(fn($u) => $u->usuario_aulas->pluck('aula.seccion'))
            ->unique()
            ->values()
            ->toArray();

        // Crear la unidad
        $unidad = Unidad::create([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'grado' => $request->grado,
            'profesores_responsables' => $profesores,
            'secciones' => $secciones,
            'situacion_significativa' => $request->situacion_significativa,
            'productos' => $request->productos,
        ]);

        // Guardar el contenido curricular, materiales y enfoques en UnidadDetalle
        UnidadDetalle::create([
            'unidad_id' => $unidad->id,
            'contenido' => $request->contenido ?? [],
            'materiales_basicos' => $request->materiales_basicos,
            'recursos' => $request->recursos,
            'enfoques' => $request->enfoques ?? [],
        ]);

        return redirect()->route('unidades.show', $unidad->id)
            ->with('mensaje', 'Unidad creada correctamente.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $unidad = Unidad::findOrFail($id);
        $profesoresIds = $unidad->profesores_responsables ?? [];
        $profesores = collect();

        if (!empty($profesoresIds) && is_array($profesoresIds)) {
            $profesores = User::whereIn('id', $profesoresIds)
                ->with('persona')
                ->get()
                ->map(function ($user) {
                    $persona = $user->persona;
                    return [
                        'id' => $user->id,
                        'nombre_completo' => trim(($persona?->nombre ?? '') . ' ' . ($persona?->apellido ?? '')) ?: 'Docente sin nombre'
                    ];
                });
        }

        $detalle = $unidad->detalles()->first();
        $materialesBasicos = $detalle ? $detalle->materiales_basicos : null;
        $recursos = $detalle ? $detalle->recursos : null;

        // Procesar enfoques transversales
        $enfoquesInfo = [];
        if ($detalle && $detalle->enfoques) {
            $enfoquesData = is_string($detalle->enfoques) ? json_decode($detalle->enfoques, true) : $detalle->enfoques;

            if (is_array($enfoquesData)) {
                foreach ($enfoquesData as $key => $enfoqueItem) {
                    if (isset($enfoqueItem['enfoque_id'])) {
                        $enfoque = EnfoqueTransversal::find($enfoqueItem['enfoque_id']);

                        if ($enfoque) {
                            $valoresInfo = [];
                            $valores = $enfoqueItem['valores'] ?? [];

                            foreach ($valores as $valorKey => $valorData) {
                                if (is_array($valorData) && isset($valorData['valor']) && isset($valorData['actitud'])) {
                                    $valoresInfo[] = [
                                        'valor' => $valorData['valor'],
                                        'actitud' => $valorData['actitud']
                                    ];
                                }
                            }

                            $enfoquesInfo[] = [
                                'enfoque' => $enfoque,
                                'valores' => $valoresInfo
                            ];
                        }
                    }
                }
            }
        }

        // Procesar contenido curricular
        $cursosInfo = [];
        if ($detalle && $detalle->contenido) {
            $contenidoData = is_string($detalle->contenido) ? json_decode($detalle->contenido, true) : $detalle->contenido;
            
            if (is_array($contenidoData) && isset($contenidoData['cursos'])) {
                foreach ($contenidoData['cursos'] as $cursoData) {
                    // Buscar curso por ID
                    $curso = \App\Models\Curso::find($cursoData['curso_id']);
                    
                    if ($curso) {
                        $competenciasInfo = [];
                        
                        if (isset($cursoData['competencias']) && is_array($cursoData['competencias'])) {
                            foreach ($cursoData['competencias'] as $compData) {
                                // Buscar competencia por ID desde la base de datos
                                $competencia = \App\Models\Competencia::find($compData['competencia_id']);
                                
                                if ($competencia) {
                                    // Obtener capacidades por IDs
                                    $capacidades = collect();
                                    if (isset($compData['capacidades']) && is_array($compData['capacidades'])) {
                                        $capacidadesIds = array_filter($compData['capacidades'], function($id) {
                                            return !empty($id) && is_numeric($id);
                                        });
                                        
                                        if (!empty($capacidadesIds)) {
                                            $capacidades = \App\Models\Capacidad::whereIn('id', $capacidadesIds)
                                                ->select('id', 'nombre', 'descripcion')
                                                ->get();
                                        }
                                    }
                                    
                                    // Obtener desempeños por IDs
                                    $desempenos = collect();
                                    if (isset($compData['desempenos']) && is_array($compData['desempenos'])) {
                                        $desempenosIds = array_filter($compData['desempenos'], function($id) {
                                            return !empty($id) && is_numeric($id);
                                        });
                                        
                                        if (!empty($desempenosIds)) {
                                            $desempenos = \App\Models\Desempeno::whereIn('id', $desempenosIds)
                                                ->select('id', 'descripcion')
                                                ->get();
                                        }
                                    }
                                    
                                    // Procesar instrumentos
                                    $instrumentos = [];
                                    if (isset($compData['instrumentos']) && is_array($compData['instrumentos'])) {
                                        $instrumentos = array_filter($compData['instrumentos'], function($instrumento) {
                                            return !empty($instrumento);
                                        });
                                    }
                                    
                                    $competenciasInfo[] = [
                                        'competencia' => $competencia,
                                        'capacidades' => $capacidades,
                                        'desempenos' => $desempenos,
                                        'criterios' => $compData['criterios'] ?? 'No especificado',
                                        'evidencias' => $compData['evidencias'] ?? 'No especificado',
                                        'instrumentos' => $instrumentos
                                    ];
                                }
                            }
                        }
                        
                        $cursosInfo[] = [
                            'curso' => $curso,
                            'competencias' => $competenciasInfo
                        ];
                    }
                }
            }
        }

        return view('panel.unidades.show', compact('unidad', 'profesores', 'cursosInfo', 'enfoquesInfo', 'materialesBasicos', 'recursos'));
    }
}
