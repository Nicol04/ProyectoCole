<?php

namespace App\Http\Controllers;

use App\Models\AulaCurso;
use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function create(Request $request)
    {
        $aulaCursoId = $request->query('aula_curso_id');
        $aulaCurso = \App\Models\AulaCurso::findOrFail($aulaCursoId);
        $curso = $aulaCurso->curso;
        return view('panel.sesiones.create', compact('aulaCurso', 'curso'));
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'objetivo' => 'required|string',
            'actividades' => 'required|string',
            'fecha' => 'required|date',
            'aula_curso_id' => 'required|exists:aula_curso,id',
        ]);

        $validated['dia'] = $request->input('dia');

        $sesion = \App\Models\Sesion::create($validated);

        $aulaCurso = \App\Models\AulaCurso::find($request->aula_curso_id);

        return redirect()->route('sesiones.show', $sesion->id)
        ->with('mensaje', 'Sesión creada exitosamente')
        ->with('icono', 'success');
    }

    public function show($id)
    {
        $sesion = Sesion::with('aulaCurso.curso', 'evaluaciones')->findOrFail($id);
        return view('panel.sesiones.show', compact('sesion'));
    }
    public function edit($id)
    {
        $sesion = Sesion::findOrFail($id);
        return view('panel.sesiones.edit', compact('sesion'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'titulo' => 'required|string',
            'objetivo' => 'nullable|string',
            'actividades' => 'nullable|string',
        ]);

        $sesion = Sesion::findOrFail($id);
        $fecha = Carbon::parse($request->fecha);
        $dia = ucfirst($fecha->locale('es')->isoFormat('dddd'));

        $sesion->update([
            'fecha' => $request->fecha,
            'dia' => $dia,
            'titulo' => $request->titulo,
            'objetivo' => $request->objetivo,
            'actividades' => $request->actividades,
        ]);
        return redirect()->route('sesiones.show', $id)
            ->with('mensaje', 'Sesión actualizada exitosamente')
            ->with('icono', 'success');
    }
    public function destroy($id)
    {
        $sesion = Sesion::findOrFail($id);
        foreach ($sesion->evaluaciones as $evaluacion) {
            $evaluacion->preguntas()->delete();
            $evaluacion->delete();
        }
        $sesion->delete();
        return redirect()->back()
            ->with('mensaje', 'Sesión y sus evaluaciones eliminadas.')
            ->with('icono', 'success');
    }
}
