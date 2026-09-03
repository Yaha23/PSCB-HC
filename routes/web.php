<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Inicio
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Dashboard general
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('redirect');
})
    ->middleware(['auth', 'active'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Redirección según rol
|--------------------------------------------------------------------------
*/

Route::get('/redirect', function () {

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('medico')) {
        return redirect()->route('medico.dashboard');
    }

    if ($user->hasRole('asistente')) {
        return redirect()->route('asistente.dashboard');
    }

    Auth::logout();

    return redirect()
        ->route('login')
        ->withErrors([
            'username' => 'El usuario no tiene un rol asignado.'
        ]);
})
    ->middleware(['auth', 'active'])
    ->name('redirect');


/*
|--------------------------------------------------------------------------
| Perfil y funciones generales autenticadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::put(
        '/citas/{id}/estado',
        [CitaController::class, 'cambiarEstado']
    )->name('citas.estado');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware([
        'auth',
        'active',
        'role:admin'
    ])
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/',
            [AdminController::class, 'index']
        )->name('dashboard');

        /*
         * Usuarios
         */
        Route::resource(
            'usuarios',
            UsuarioController::class
        );

        Route::get(
            'usuarios/{id}/confirm-delete',
            [UsuarioController::class, 'confirmDelete']
        )->name('usuarios.confirmDelete');


        /*
         * Pacientes
         */
        Route::get(
            'pacientes/reporte-pdf',
            [PacienteController::class, 'reportePdf']
        )->name('pacientes.reportePdf');

        Route::resource(
            'pacientes',
            PacienteController::class
        );

        Route::get(
            'pacientes/{id}/confirm-delete',
            [PacienteController::class, 'confirmDelete']
        )->name('pacientes.confirmDelete');


        /*
         * Horarios
         */
        Route::get(
            'horarios/reporte-pdf',
            [HorarioController::class, 'reportePdf']
        )->name('horarios.pdf');

        Route::resource(
            'horarios',
            HorarioController::class
        );

        Route::get(
            'horarios/{id}/confirm-delete',
            [HorarioController::class, 'confirmDelete']
        )->name('horarios.confirmDelete');


        /*
         * Citas
         */
        Route::resource(
            'citas',
            CitaController::class
        );

        Route::get(
            'citas/{id}/confirm-delete',
            [CitaController::class, 'confirmDelete']
        )->name('citas.confirmDelete');


        /*
         * Configuraciones
         */
        Route::resource(
            'configuraciones',
            ConfiguracionController::class
        );

        Route::get(
            'configuraciones/{id}/confirm-delete',
            [ConfiguracionController::class, 'confirmDelete']
        )->name('configuraciones.confirmDelete');


        /*
         * Consultas / Historias clínicas
         */
        Route::get(
            'pacientes/{paciente}/consultas',
            [ConsultaController::class, 'index']
        )->name('consultas.index');

        Route::get(
            'consultas/{paciente_id}/create',
            [ConsultaController::class, 'create']
        )->name('consultas.create');

        Route::post(
            'consultas/store',
            [ConsultaController::class, 'store']
        )->name('consultas.store');

        Route::get(
            'consultas/{id}',
            [ConsultaController::class, 'show']
        )->name('consultas.show');

        Route::get(
            'consultas/{id}/edit',
            [ConsultaController::class, 'edit']
        )->name('consultas.edit');

        Route::put(
            'consultas/{id}',
            [ConsultaController::class, 'update']
        )->name('consultas.update');

        Route::delete(
            'consultas/{id}',
            [ConsultaController::class, 'destroy']
        )->name('consultas.destroy');

        Route::get(
            'consultas/{id}/delete',
            [ConsultaController::class, 'delete']
        )->name('consultas.delete');

        Route::get(
            'consultas/{id}/Historia_Clinica',
            [ConsultaController::class, 'historiaPdf']
        )->name('consultas.pdf');

        Route::get(
            'consultas/{id}/receta-pdf',
            [ConsultaController::class, 'recetaPdf']
        )->name('consultas.recetaPdf');
    });


/*
|--------------------------------------------------------------------------
| ASISTENTE
|--------------------------------------------------------------------------
*/

Route::prefix('asistente')
    ->middleware([
        'auth',
        'active',
        'role:asistente'
    ])
    ->name('asistente.')
    ->group(function () {

        Route::get(
            '/',
            [AdminController::class, 'index']
        )->name('dashboard');

        Route::get(
            'pacientes/reporte-pdf',
            [PacienteController::class, 'reportePdf']
        )->name('pacientes.reportePdf');

        Route::get(
            'consultas/{id}/Historia_Clinica',
            [ConsultaController::class, 'historiaPdf']
        )->name('consultas.pdf');

        Route::resource(
            'pacientes',
            PacienteController::class
        );

        Route::resource(
            'citas',
            CitaController::class
        );

        Route::get(
            'citas/{id}/confirm-delete',
            [CitaController::class, 'confirmDelete']
        )->name('citas.confirmDelete');

        Route::get(
            'horarios/reporte-pdf',
            [HorarioController::class, 'reportePdf']
        )->name('horarios.pdf');

        Route::resource(
            'horarios',
            HorarioController::class
        );

        Route::get(
            'horarios/{id}/confirm-delete',
            [HorarioController::class, 'confirmDelete']
        )->name('horarios.confirmDelete');

        Route::get(
            'pacientes/{paciente}/consultas',
            [ConsultaController::class, 'index']
        )->name('consultas.index');

        Route::get(
            'consultas/{paciente_id}/create',
            [ConsultaController::class, 'create']
        )->name('consultas.create');

        Route::post(
            'consultas/store',
            [ConsultaController::class, 'store']
        )->name('consultas.store');

        Route::get(
            'consultas/{id}',
            [ConsultaController::class, 'show']
        )->name('consultas.show');

        Route::get(
            'consultas/{id}/edit',
            [ConsultaController::class, 'edit']
        )->name('consultas.edit');

        Route::put(
            'consultas/{id}',
            [ConsultaController::class, 'update']
        )->name('consultas.update');

        Route::delete(
            'consultas/{id}',
            [ConsultaController::class, 'destroy']
        )->name('consultas.destroy');

        Route::get(
            'consultas/{id}/delete',
            [ConsultaController::class, 'delete']
        )->name('consultas.delete');

        Route::get(
            'consultas/{id}/receta-pdf',
            [ConsultaController::class, 'recetaPdf']
        )->name('consultas.recetaPdf');
    });


/*
|--------------------------------------------------------------------------
| MÉDICO
|--------------------------------------------------------------------------
*/

Route::prefix('medico')
    ->middleware([
        'auth',
        'active',
        'role:medico'
    ])
    ->name('medico.')
    ->group(function () {

        Route::get(
            '/',
            [AdminController::class, 'index']
        )->name('dashboard');

        Route::get(
            'pacientes/reporte-pdf',
            [PacienteController::class, 'reportePdf']
        )->name('pacientes.reportePdf');

        Route::get(
            'consultas/{id}/Historia_Clinica',
            [ConsultaController::class, 'historiaPdf']
        )->name('consultas.pdf');

        Route::resource(
            'pacientes',
            PacienteController::class
        );

        Route::resource(
            'citas',
            CitaController::class
        );

        Route::get(
            'horarios/reporte-pdf',
            [HorarioController::class, 'reportePdf']
        )->name('horarios.pdf');

        Route::resource(
            'horarios',
            HorarioController::class
        );

        Route::get(
            'pacientes/{paciente}/consultas',
            [ConsultaController::class, 'index']
        )->name('consultas.index');

        Route::get(
            'consultas/{paciente_id}/create',
            [ConsultaController::class, 'create']
        )->name('consultas.create');

        Route::post(
            'consultas/store',
            [ConsultaController::class, 'store']
        )->name('consultas.store');

        Route::get(
            'consultas/{id}',
            [ConsultaController::class, 'show']
        )->name('consultas.show');

        Route::get(
            'consultas/{id}/edit',
            [ConsultaController::class, 'edit']
        )->name('consultas.edit');

        Route::put(
            'consultas/{id}',
            [ConsultaController::class, 'update']
        )->name('consultas.update');

        Route::delete(
            'consultas/{id}',
            [ConsultaController::class, 'destroy']
        )->name('consultas.destroy');

        Route::get(
            'consultas/{id}/delete',
            [ConsultaController::class, 'delete']
        )->name('consultas.delete');

        Route::get(
            'consultas/{id}/receta-pdf',
            [ConsultaController::class, 'recetaPdf']
        )->name('consultas.recetaPdf');
    });