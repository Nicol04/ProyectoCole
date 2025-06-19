<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Models\Avatar_usuarios;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();
        $estudiantes = collect();
        if ($aula) {
            $estudiantes = $aula->users()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'estudiante');
                })
                ->with(['avatar', 'persona'])
                ->get();
        }
        return view('panel.estudiantes.index', compact('aula', 'estudiantes'));
    }

    public function show($id)
    {
        $estudiante = User::with(['persona', 'avatar'])->findOrFail($id);

        // 1. Obtener todas las aulas del estudiante
        $aulas = $estudiante->aulas()->pluck('aulas.id');
        $cursosAula = \App\Models\Curso::whereIn(
            'id',
            \App\Models\AulaCurso::whereIn('aula_id', $aulas)->pluck('curso_id')
        )->get();
        // 2. Obtener los aula_curso_id de esas aulas
        $aulaCursoIds = \App\Models\AulaCurso::whereIn('aula_id', $aulas)->pluck('id');

        // 3. Obtener las sesiones de esos aula_curso
        $sesionIds = \App\Models\Sesion::whereIn('aula_curso_id', $aulaCursoIds)->pluck('id');

        // 4. Obtener las evaluaciones de esas sesiones
        $evaluaciones = \App\Models\Evaluacion::whereIn('sesion_id', $sesionIds)->get();

        $calificaciones = [];
        foreach ($evaluaciones as $evaluacion) {
            // 5. Solo intentos FINALIZADOS del estudiante
            $intentos = $evaluacion->intentos()
                ->where('user_id', $estudiante->id)
                ->where('estado', 'finalizado')
                ->with('calificacion')
                ->get();

            // 6. Mejor intento (mayor puntaje_total)
            $mejorIntento = $intentos->sortByDesc(function ($intento) {
                return $intento->calificacion->puntaje_total ?? 0;
            })->first();

            if ($mejorIntento && $mejorIntento->calificacion) {
                $calificaciones[] = [
                    'curso' => $evaluacion->sesion->aulaCurso->curso->curso ?? '',
                    'evaluacion' => $evaluacion->titulo,
                    'puntaje_total' => $mejorIntento->calificacion->puntaje_total,
                    'puntaje_maximo' => $mejorIntento->calificacion->puntaje_maximo,
                    'porcentaje' => $mejorIntento->calificacion->porcentaje,
                    'estado' => $mejorIntento->calificacion->estado,
                    'fecha_fin' => $mejorIntento->fecha_fin,
                    'intento_id' => $mejorIntento->id,
                    'intentos' => $intentos->count(),
                    'revision_vista' => $mejorIntento->revision_vista ?? false,
                ];
            }
        }

        $cursosContados = [];
        foreach ($calificaciones as $calificacion) {
            $cursoNombre = $calificacion['curso'];
            if (!isset($cursosContados[$cursoNombre])) {
                $cursosContados[$cursoNombre] = 0;
            }
            $cursosContados[$cursoNombre]++;
        }

        // Filtrar por curso si viene en la URL
        if (request()->filled('curso')) {
            $cursoFiltro = request('curso');
            $calificaciones = array_filter($calificaciones, function ($calificacion) use ($cursoFiltro) {
                return $calificacion['curso'] === $cursoFiltro;
            });
        }

        // Filtrar por estado si viene en la URL
        if (request()->filled('estado')) {
            $estadoFiltro = strtolower(request('estado'));
            $calificaciones = array_filter($calificaciones, function ($calificacion) use ($estadoFiltro) {
                return strtolower($calificacion['estado']) === $estadoFiltro;
            });
        }

        // Filtrar por fecha exacta
        if (request()->filled('fecha')) {
            $fecha = request('fecha');
            $calificaciones = array_filter($calificaciones, function ($calificacion) use ($fecha) {
                return isset($calificacion['fecha_fin']) &&
                    \Carbon\Carbon::parse($calificacion['fecha_fin'])->format('Y-m-d') === $fecha;
            });
        }

        // Filtrar por intervalo de fechas
        if (request()->filled('fecha_inicio') && request()->filled('fecha_fin')) {
            $fechaInicio = request('fecha_inicio');
            $fechaFin = request('fecha_fin');
            $calificaciones = array_filter($calificaciones, function ($calificacion) use ($fechaInicio, $fechaFin) {
                if (!isset($calificacion['fecha_fin'])) return false;
                $fecha = \Carbon\Carbon::parse($calificacion['fecha_fin'])->format('Y-m-d');
                return $fecha >= $fechaInicio && $fecha <= $fechaFin;
            });
        }
        $calificaciones = array_values($calificaciones);

        // Paginación manual
        $page = request()->get('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $calificacionesPaginadas = new LengthAwarePaginator(
            array_slice($calificaciones, $offset, $perPage),
            count($calificaciones),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return view('panel.estudiantes.show', compact(
            'estudiante',
            'calificacionesPaginadas',
            'cursosContados',
            'cursosAula'
        ));
    }

    public function exportarUsuarios()
    {
        return Excel::download(new ExportUser, 'usuarios.xlsx');
    }
    public function perfil()
    {
        $user = Auth::user();
        $persona = $user->persona;
        $rol = $user->roles->first()?->name;
        return view('panel.perfil.index', compact('user', 'persona', 'rol'));
    }

    public function editarAvatar($id)
    {
        $user = User::findOrFail($id);
        $rol = $user->roles->first()?->name; // 'estudiante' o 'docente'
        $genero = $user->persona->genero ?? null; // 'masculino' o 'femenino'
        $prefijo = '';
        if ($rol === 'Estudiante') {
            $prefijo = ($genero === 'Masculino') ? 'ME' : 'FE';
        } elseif ($rol === 'Docente') {
            $prefijo = ($genero === 'Masculino') ? 'MD' : 'FD';
        }
        $avatars = Avatar_usuarios::where('name', 'like', $prefijo . '%')->get();
        return view('panel.perfil.edit', compact('user', 'avatars'));
    }

    public function actualizarAvatar(Request $request, $id)
    {
        $request->validate([
            'avatar_id' => 'required|exists:avatar_usuarios,id',
        ]);
        $user = User::findOrFail($id);
        $user->avatar_usuario_id = $request->input('avatar_id');
        $user->save();
        return redirect()->route('users.perfil')
            ->with('mensaje', 'Avatar actualizado correctamente.')
            ->with('icono', 'success');
    }
}
