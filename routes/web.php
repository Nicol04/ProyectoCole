<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// parte informativa
Route::get('/', function () {
    return view('public.index');
})->name('public.index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/panel', function () {
    return view('panel.login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('mensaje', 'Sesión cerrada exitosamente')->with('icono', 'success');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/panel/index', function () {
        return view('panel.index');
    })->name('index');

Route::get('/panel/cursos', [CursoController::class, 'index'])->name('panel.cursos');
Route::get('/panel/estudiantes', [UserController::class, 'index'])->name('estudiantes.index');
});