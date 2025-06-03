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

        return view('panel.examenes.renderizar', compact(
            'evaluacion_id',
            'cantidad_preguntas',
            'titulo',
            'preguntas_json',
            'evaluacion' // <-- agrega esto si quieres usar $evaluacion en la vista
        ));
    }
    public function store(Request $request){
        $evaluacion_id = $request->input('evaluacion_id');
        $examen_json = $request->input('jsonFinal');
        $request->validate([
            'evaluacion_id' => 'required|integer|exists:evaluacions,id',
            'jsonFinal' => 'required|json',
        ]);

        $examenPregunta = new ExamenPregunta();
        $examenPregunta->evaluacion_id = $evaluacion_id;
        $examenPregunta->examen_json = $examen_json;
        $examenPregunta->save();

        return redirect()->back();
    }
}
