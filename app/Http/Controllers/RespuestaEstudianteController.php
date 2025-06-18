<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\ExamenPregunta;
use App\Models\IntentoEvaluacion;
use Illuminate\Http\Request;
use App\Models\Respuesta_estudiante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistorialEstudiantesExport;

class RespuestaEstudianteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'examen_pregunta_id' => 'required|integer|exists:examen_preguntas,id',
            'intento_id' => 'required|integer|exists:intentos_evaluacion,id',
            'respuesta_json' => 'required',
        ]);
        $respuestaEstudiante = Respuesta_estudiante::create([
            'user_id' => Auth::id(),
            'examen_pregunta_id' => $request->examen_pregunta_id,
            'intento_id' => $request->intento_id,
            'respuesta_json' => $request->respuesta_json,
            'fecha_respuesta' => now(),
        ]);
        $intento = IntentoEvaluacion::find($request->intento_id);
        if ($intento) {
            $intento->estado = 'finalizado';
            $intento->fecha_fin = now();
            $intento->save();
        }
        $respuestas = json_decode($request->respuesta_json, true);
        $puntaje_total = array_sum(array_column($respuestas, 'valor_respuesta'));
        $examenPregunta = ExamenPregunta::find($request->examen_pregunta_id);
        $preguntas = $examenPregunta ? json_decode($examenPregunta->examen_json, true) : [];
        $puntaje_maximo = array_sum(array_column($preguntas, 'puntuacion'));
        $porcentaje = $puntaje_maximo > 0 ? round(($puntaje_total / $puntaje_maximo) * 100, 2) : 0;
        $estado = $porcentaje >= 60 ? 'Aprobado' : 'Desaprobado';
        Calificacion::create([
            'intento_id' => $intento->id,
            'retroalimentacion' => null,
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
        $intento = IntentoEvaluacion::findOrFail($intento_id);
        if (Auth::user()->roles->first()?->id == 3 && !$intento->revision_vista) {
            $intento->revision_vista = true;
            $intento->save();
        }
        $respuesta = Respuesta_estudiante::where('intento_id', $intento_id)->firstOrFail();
        $respuestas = json_decode($respuesta->respuesta_json, true);
        return view('panel.examenes.revision', compact('respuestas'));
    }
    public function destroy($id)
    {
        $intento = IntentoEvaluacion::findOrFail($id);
        Respuesta_estudiante::where('intento_id', $id)->delete();
        Calificacion::where('intento_id', $id)->delete();
        $intento->delete();
        return response()->json(['success' => true, 'message' => 'Intento eliminado exitosamente']);
    }
    public function exportarHistorialEstudiantes(Request $request)
    {
        $evaluacionId = $request->get('evaluacion_id');
        return Excel::download(new HistorialEstudiantesExport($evaluacionId), 'historial_estudiantes.xlsx');
    }
}
