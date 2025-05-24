<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Evaluacion;
use App\Models\ExamenPregunta;
use App\Models\Sesion;
use Illuminate\Http\Request;

class ExamenPreguntaController extends Controller
{

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


}
