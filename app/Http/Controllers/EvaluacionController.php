<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Archivo;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function index()
    {
        return view('panel.evaluaciones.index');
    }
    public function create()
    {
        $user = Auth::user();
        $cursos = collect();

        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');

        return view('panel.evaluaciones.create', compact('cursos'));
    }
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'sesion_id' => 'required|exists:sesions,id',
            'titulo' => 'required|string|max:255',
            'cantidad_preguntas' => 'required|integer|min:2|max:20',
            'cantidad_intentos' => 'nullable|integer|min:1|max:10',
            'es_supervisado' => 'nullable|boolean',
        ], [
            'curso_id.required' => 'El curso es obligatorio.',
            'curso_id.exists' => 'El curso seleccionado no es válido.',
            'sesion_id.required' => 'La sesión es obligatoria.',
            'sesion_id.exists' => 'La sesión seleccionada no es válida.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no debe superar los 255 caracteres.',
            'cantidad_preguntas.required' => 'La cantidad de preguntas es obligatoria.',
            'cantidad_preguntas.min' => 'Debe haber al menos 2 preguntas.',
            'cantidad_preguntas.max' => 'No puede haber más de 20 preguntas.',
            'cantidad_intentos.min' => 'Debe haber al menos 1 intento.',
            'cantidad_intentos.max' => 'No puede haber más de 10 intentos.',
        ]);

        // Por defecto cantidad_intentos en 1 si no viene
        $cantidad_intentos = $validated['cantidad_intentos'] ?? 1;

        // Usar transacción para evitar inconsistencias
        DB::beginTransaction();

        try {

            // Crear evaluación
            $evaluacion = Evaluacion::create([
                'sesion_id' => $validated['sesion_id'],
                'user_id' => Auth::id(),
                'es_supervisado' => $request->has('es_supervisado') ? 1 : 0,
                'titulo' => $validated['titulo'],
                'fecha_creacion' => now(),
                'cantidad_preguntas' => $validated['cantidad_preguntas'],
                'cantidad_intentos' => $cantidad_intentos,
            ]);

            DB::commit();

            return redirect()->route('evaluaciones.generarExamen', $evaluacion->id)
                ->with('mensaje', 'Evaluación creada correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors('Error al crear la evaluación. Inténtalo de nuevo.');
        }
    }
    public function getSesionesPorCurso($cursoId)
    {
        $sesiones = Sesion::whereHas('aulaCurso', function ($query) use ($cursoId) {
        $query->where('curso_id', $cursoId);
        })->get();
        return response()->json($sesiones);
    }

    
}
