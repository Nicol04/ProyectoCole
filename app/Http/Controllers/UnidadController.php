<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\AulaCurso;
use App\Models\Competencia;
use App\Models\Desempeno;
use App\Models\Unidad;
use App\Models\UnidadDetalle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $cursos = collect();

        // Obtener todos los cursos relacionados al docente
        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');

        // Variables inicializadas
        $aula_curso_id = $request->query('aula_curso_id'); // Obtener el aula_curso_id si existe
        $curso = null;
        $competencias = collect(); // Inicializar como colección vacía
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

        return view('panel.unidades.create', compact(
            'grado', 
            'docentes',
            'cursos',
            'aula_curso_id',
            'curso',
            'competencias',
            'disableCursoSelect'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'grado' => 'required|string|max:255',
            'profesores_responsables' => 'required|array|min:1',
            'situacion_significativa' => 'required|string',
            'productos' => 'required|string',
            'contenido' => 'nullable|array',
        ]);

        $docenteAuth = Auth::user();
        $profesores = $request->profesores_responsables;
        $profesores[] = $docenteAuth->id; // también incluir al docente actual

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

        // Guardar el contenido curricular en UnidadDetalle
        if ($request->has('contenido')) {
            UnidadDetalle::create([
                'unidad_id' => $unidad->id,
                'contenido' => $request->contenido,
            ]);
        }

        return redirect()->back()
            ->with('mensaje', 'Unidad creada correctamente.')
            ->with('icono', 'success');
    }


}
