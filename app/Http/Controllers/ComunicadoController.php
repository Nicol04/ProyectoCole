<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComunicadoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();

        if (!$aula) {
            return back()->with('error', 'No tienes un aula asignada.');
        }

        $comunicados = Comunicado::with('user')
            ->where('aula_id', $aula->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('panel.comunicados.index', compact('user', 'aula', 'comunicados'));
    }
    public function marcarVisto(Comunicado $comunicado)
    {
        $comunicado->vistosPor()
            ->syncWithoutDetaching([Auth::id() => ['visto' => true]]);

        return response()->json(['success' => true]);
    }


    public function create()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();

        if (!$aula) {
            return back()->with('error', 'No tienes un aula asignada.');
        }

        return view('panel.comunicados.create', compact('aula'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'mensaje' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $mensajeLimpio = strip_tags($value);
                    $wordCount = str_word_count($mensajeLimpio);
                    $charCount = strlen($mensajeLimpio);
                    $palabras = explode(' ', $mensajeLimpio);
                    $maxPalabra = collect($palabras)->map(fn($p) => strlen($p))->max();

                    if ($wordCount > 200) {
                        $fail('El comunicado no debe superar las 200 palabras. Actualmente tiene ' . $wordCount . '.');
                    }

                    if ($charCount > 1000) {
                        $fail('El comunicado no debe superar los 1000 caracteres. Actualmente tiene ' . $charCount . '.');
                    }

                    if ($maxPalabra > 30) {
                        $fail('Algunas palabras son demasiado largas (más de 30 caracteres). Revisa tu mensaje.');
                    }
                }
            ]
        ]);


        $user = Auth::user();
        $aula = $user->aulas()->first();

        if (!$aula) {
            return back()->with('error', 'No tienes un aula asignada.');
        }

        \App\Models\Comunicado::create([
            'mensaje' => $request->mensaje,
            'user_id' => $user->id,
            'aula_id' => $aula->id,
        ]);

        return redirect()->route('comunicados.index')
            ->with('mensaje', 'Comunicado enviado con éxito.')
            ->with('icono', 'success');
    }
    public function edit(Comunicado $comunicado)
    {
        if (Auth::id() != $comunicado->user_id) {
            return redirect()->route('informativa')
                ->with('mensaje', 'No tienes permiso para esta acción.')
                ->with('icono', 'error');
        }

        return view('panel.comunicados.edit', compact('comunicado'));
    }

    public function update(Request $request, Comunicado $comunicado)
    {
        if (Auth::id() != $comunicado->user_id) {
            return redirect()->route('informativa')
                ->with('mensaje', 'No tienes permiso para esta acción.')
                ->with('icono', 'error');
        }

        $request->validate([
            'mensaje' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $mensajeLimpio = strip_tags($value);
                    $wordCount = str_word_count($mensajeLimpio);
                    $charCount = strlen($mensajeLimpio);
                    $palabras = explode(' ', $mensajeLimpio);
                    $maxPalabra = collect($palabras)->map(fn($p) => strlen($p))->max();

                    if ($wordCount > 200) {
                        $fail('El comunicado no debe superar las 200 palabras. Actualmente tiene ' . $wordCount . '.');
                    }

                    if ($charCount > 1000) {
                        $fail('El comunicado no debe superar los 1000 caracteres. Actualmente tiene ' . $charCount . '.');
                    }

                    if ($maxPalabra > 30) {
                        $fail('Algunas palabras son demasiado largas (más de 30 caracteres). Revisa tu mensaje.');
                    }
                }
            ]
        ]);

        $comunicado->update([
            'mensaje' => $request->mensaje,
        ]);

        return redirect()->route('comunicados.index')
            ->with('mensaje', 'Comunicado actualizado con éxito.')
            ->with('icono', 'success');
    }

    public function destroy(Comunicado $comunicado)
    {
        if (Auth::id() !== $comunicado->user_id) {
            return redirect()->route('comunicados.index')
                ->with('mensaje', 'No tienes permiso para esta acción.')
                ->with('icono', 'error');
        }

        $comunicado->delete();

        return redirect()->route('comunicados.index')
            ->with('mensaje', 'Comunicado eliminado con éxito.')
            ->with('icono', 'success');
    }

    public function informativa()
    {
        $user = Auth::user();
        $roleId = $user->roles->first()?->id;

        $aula = $user->aulas()->first();

        // Comunicados del aula
        $comunicados = $aula
            ? \App\Models\Comunicado::where('aula_id', $aula->id)
            ->with('user')
            ->orderByDesc('created_at')
            ->get()
            : collect();

        // Todos los docentes con sus aulas
        $docentes = \App\Models\User::whereHas('roles', fn($q) => $q->where('id', 2))
            ->with('aulas')
            ->get();

        $mejoresEstudiantes = collect();

        if ($aula) {
            $estudiantesAula = $aula->users()
                ->whereHas('roles', fn($q) => $q->where('id', 3))
                ->with(['persona', 'avatar', 'intentos.calificacion']) // Relación a calificaciones
                ->get();

            $mejoresEstudiantes = $estudiantesAula->map(function ($estudiante) {
                $intentos = $estudiante->intentos->filter(fn($i) => $i->calificacion);
                $total = $intentos->sum(fn($i) => $i->calificacion->puntaje_total ?? 0);
                $max = $intentos->sum(fn($i) => $i->calificacion->puntaje_maximo ?? 0);
                $promedio = $max > 0 ? round(($total / $max) * 100, 2) : 0;

                return [
                    'estudiante' => $estudiante,
                    'promedio' => $promedio
                ];
            })->sortByDesc('promedio')
                ->take(3)
                ->values();
        }
        return view('panel.informativa', compact('roleId', 'user', 'aula', 'comunicados', 'docentes', 'mejoresEstudiantes'));
    }
}
