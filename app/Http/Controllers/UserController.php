<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Models\Avatar_usuarios;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        // Determinar prefijo según rol y género
        $prefijo = '';
        if ($rol === 'Estudiante') {
            $prefijo = ($genero === 'Masculino') ? 'ME' : 'FE';
        } elseif ($rol === 'Docente') {
            $prefijo = ($genero === 'Masculino') ? 'MD' : 'FD';
        }

        // Filtrar avatares por prefijo
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
