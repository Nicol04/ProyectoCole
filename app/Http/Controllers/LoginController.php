<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('mensaje', 'Todos los campos son obligatorios')
                ->with('icono', 'warning');
        }

        $credentials = $request->only('name', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->estado === 'Inactivo') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('mensaje', 'Tu cuenta está inactiva. Contacta con un administrador.')
                    ->with('icono', 'error');
            }

            // Verificar si el usuario es Docente o Estudiante
            if ($user->hasRole('Docente') || $user->hasRole('Estudiante')) {
                return redirect()->route('index')
                    ->with('mensaje', 'Inicio de sesión exitoso, Bienvenido a tu aula virtual!')
                    ->with('icono', 'success');
            } else {
                Auth::logout();
                return redirect()->route('login')
                    ->with('mensaje', 'No tienes permiso para acceder. Solo Docentes y Estudiantes pueden ingresar.')
                    ->with('icono', 'error');
            }
        }
        return back()->with('mensaje', 'Credenciales incorrectas.')
            ->with('icono', 'error');
    }

    public function showLoginForm()
    {
        return view('panel.login');
    }
}
