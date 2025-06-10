<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\ExamenPregunta;
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
        $respuestaEstudiante = Respuesta_estudiante::create([
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

        // 1. Puntaje total obtenido
        $respuestas = json_decode($request->respuesta_json, true);
        $puntaje_total = array_sum(array_column($respuestas, 'valor_respuesta'));

        // 2. Puntaje máximo del examen
        $examenPregunta = ExamenPregunta::find($request->examen_pregunta_id);
        $preguntas = $examenPregunta ? json_decode($examenPregunta->examen_json, true) : [];
        $puntaje_maximo = array_sum(array_column($preguntas, 'puntuacion'));

        // 3. Porcentaje
        $porcentaje = $puntaje_maximo > 0 ? round(($puntaje_total / $puntaje_maximo) * 100, 2) : 0;

        // 4. Estado (puedes ajustar el criterio)
        $estado = $porcentaje >= 60 ? 'Aprobado' : 'Desaprobado';

        // 5. Guardar en calificaciones
        Calificacion::create([
            'intento_id' => $intento->id,
            'retroalimentacion' => null, // aún no se llena
            'fecha' => $intento->fecha_fin,
            'puntaje_total' => $puntaje_total,
            'puntaje_maximo' => $puntaje_maximo,
            'porcentaje' => $porcentaje,
            'estado' => $estado,
        ]);

        // Redirigir al padre (fuera del iframe)
        return response()->view('panel.iframe_redirect', [
            'url' => route('evaluaciones.examen', ['evaluacion_id' => $intento->evaluacion_id]),
            'mensaje' => 'Respuestas guardadas correctamente',
            'icono' => 'success'
        ]);
    }
    public function revision($intento_id)
    {
        $intento = \App\Models\IntentoEvaluacion::findOrFail($intento_id);
        if (!$intento->revision_vista) {
            $intento->revision_vista = true;
            $intento->save();
        }
        $respuesta = \App\Models\Respuesta_estudiante::where('intento_id', $intento_id)->firstOrFail();
        $respuestas = json_decode($respuesta->respuesta_json, true);
        return view('panel.examenes.revision', compact('respuestas'));
    }
}
