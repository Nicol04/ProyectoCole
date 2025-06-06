<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Evaluacion;
use App\Models\ExamenPregunta;
use App\Models\Sesion;
use Illuminate\Http\Request;

class ExamenPreguntaController extends Controller
{

    public function show($evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $examenPregunta = ExamenPregunta::where('evaluacion_id', $evaluacion_id)->first();
        $preguntas_json = $examenPregunta ? json_decode($examenPregunta->examen_json, true) : [];
        return view('panel.examenes.show', compact('evaluacion', 'preguntas_json'));
    }

    public function generarExamen($evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $sesion = Sesion::find($evaluacion->sesion_id);

        return view('panel.ia.generar_preguntas', [
            'evaluacion_id' => $evaluacion->id,
            'cantidad_preguntas' => $evaluacion->cantidad_preguntas,
            'titulo' => $sesion ? $sesion->titulo : '',
            'objetivo' => $sesion ? $sesion->objetivo : '',
            'actividades' => $sesion ? $sesion->actividades : '',
        ]);
    }
    public function formulario(Request $request)
    {
        return view('panel.examenes.formulario', [
            'evaluacion_id' => $request->input('evaluacion_id'),
            'cantidad_preguntas' => $request->input('cantidad_preguntas'),
            'titulo' => $request->input('titulo'),
            'objetivo' => $request->input('objetivo'),
            'actividades' => $request->input('actividades'),
        ]);
    }
    public function renderizar(Request $request)
    {
        $evaluacion_id = $request->input('evaluacion_id');
        $cantidad_preguntas = $request->input('cantidad_preguntas');
        $titulo = $request->input('titulo');

        $evaluacion = Evaluacion::with('preguntas')->findOrFail($evaluacion_id);
        $examenPregunta = $evaluacion->preguntas->first();

        if (!$examenPregunta) {
            return redirect()->back()->with('error', 'No se encontraron preguntas para esta evaluación.');
        }

        $preguntas_json = json_decode($examenPregunta->examen_json, true);

        // Cambia aquí: pasa 'evaluacion_id' => $evaluacion_id
        return view('panel.examenes.renderizar', [
            'evaluacion_id' => $evaluacion_id,
            'cantidad_preguntas' => $cantidad_preguntas,
            'titulo' => $titulo,
            'preguntas_json' => $preguntas_json,
            'evaluacion' => $evaluacion,
            'examenPregunta' => $examenPregunta
        ]);
    }
    public function store(Request $request)
    {
        $evaluacion_id = $request->input('evaluacion_id');
        $examen_json = $request->input('jsonFinal');
        $imagen_url = $request->input('imagen_url');
        $texto = $request->input('texto');

        $request->validate([
            'evaluacion_id' => 'required|integer|exists:evaluacions,id',
            'jsonFinal' => 'required|json',
        ]);

        $examenPregunta = new ExamenPregunta();
        $examenPregunta->evaluacion_id = $evaluacion_id;
        $examenPregunta->examen_json = $examen_json;
        $examenPregunta->save();
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);

        if ($imagen_url) {
            $evaluacion->imagen_url = $imagen_url;
            $evaluacion->texto = null;
        }
        if ($texto) {
            $evaluacion->texto = $texto;
            $evaluacion->imagen_url = null;
        }
        $evaluacion->save();
        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $evaluacion_id]),
            'mensaje' => 'Examen guardado correctamente.',
            'icono' => 'success'
        ]);
    }
    public function edit($id, Request $request){
        $examenPregunta = ExamenPregunta::findOrFail($id);
        $preguntas_json = json_decode($examenPregunta->examen_json, true);
        $evaluacion_id = $request->query('evaluacion_id');
        $evaluacion = Evaluacion::find($evaluacion_id);
        return view('panel.examenes.edit', compact('examenPregunta', 'preguntas_json', 'evaluacion', 'evaluacion_id'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'jsonFinal' => 'required|json',
            'evaluacion_id' => 'required|integer|exists:evaluacions,id',
            'cantidad_intentos' => 'required|integer|min:1|max:10',
        ]);

        $examenPregunta = ExamenPregunta::findOrFail($id);
        $examenPregunta->examen_json = $request->input('jsonFinal');
        $examenPregunta->save();

        // Actualiza la cantidad de intentos en la evaluación
        $evaluacion = Evaluacion::findOrFail($request->input('evaluacion_id'));
        $evaluacion->cantidad_intentos = $request->input('cantidad_intentos');
        $evaluacion->save();

        // Redirige al show del examen en la página padre usando iframe_redirect
        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $evaluacion->id]),
            'mensaje' => 'Examen actualizado correctamente.',
            'icono' => 'success'
        ]);
    }
}
