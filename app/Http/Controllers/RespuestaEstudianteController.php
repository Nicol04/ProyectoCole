<?php

namespace App\Http\Controllers;

use App\Models\IntentoEvaluacion;
use Illuminate\Http\Request;
use App\Models\Respuesta_estudiante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
class RespuestaEstudianteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'examen_pregunta_id' => 'required|integer|exists:examen_preguntas,id',
            'intento_id' => 'required|integer|exists:intentos_evaluacion,id',
            'respuesta_json' => 'required',
        ]);

        // Guardar la respuesta del estudiante
        Respuesta_estudiante::create([
            'user_id' => Auth::id(),
            'examen_pregunta_id' => $request->examen_pregunta_id,
            'intento_id' => $request->intento_id,
            'respuesta_json' => $request->respuesta_json,
            'fecha_respuesta' => now(),
        ]);

        // Actualizar el intento a finalizado y poner fecha_fin
        $intento = IntentoEvaluacion::find($request->intento_id);
        if ($intento) {
            $intento->estado = 'finalizado';
            $intento->fecha_fin = now();
            $intento->save();
        }

        // Redirigir al padre (fuera del iframe)
        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $intento->evaluacion_id]),
            'mensaje' => 'Respuestas guardadas correctamente',
            'icono' => 'success'
        ]);
    }
}
