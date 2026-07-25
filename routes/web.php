<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;

/*
|--------------------------------------------------------------------------
| RUTAS PRINCIPALES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('redirect');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN POR ROL
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {

    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect('/admin');
    }

    if ($user->hasRole('medico')) {
        return redirect('/medico');
    }

    if ($user->hasRole('asistente')) {
        return redirect('/asistente');
    }

    return redirect('/login');

})->middleware('auth')->name('redirect');

/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::put('/citas/{id}/estado', [CitaController::class, 'cambiarEstado'])
            ->name('citas.estado');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth','role:admin'])
    ->name('admin.')
    ->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('usuarios', UsuarioController::class);
    Route::get('usuarios/{id}/confirm-delete', [UsuarioController::class, 'confirmDelete'])
    ->name('usuarios.confirmDelete');
    Route::get('pacientes/reporte-pdf', [PacienteController::class, 'reportePdf'])
    ->name('pacientes.reportePdf');
    // ✅ NUEVA RUTA
    Route::get('consultas/{id}/pdf', [ConsultaController::class, 'historiaPdf'])
    ->name('consultas.pdf');
    Route::resource('pacientes', PacienteController::class);
    Route::get('pacientes/{id}/confirm-delete', [PacienteController::class, 'confirmDelete'])
    ->name('pacientes.confirmDelete');
    
    Route::get('horarios/reporte-pdf',[HorarioController::class,'reportePdf'])->name('horarios.pdf');
    Route::resource('horarios', HorarioController::class);
     Route::get('horarios/{id}/confirm-delete', [HorarioController::class, 'confirmDelete'])
    ->name('horarios.confirmDelete');


    Route::resource('citas', CitaController::class);
     Route::get('citas/{id}/confirm-delete', [CitaController::class, 'confirmDelete'])
    ->name('citas.confirmDelete');
    

    Route::resource('configuraciones', ConfiguracionController::class);
    Route::get('configuraciones/{id}/confirm-delete', [ConfiguracionController::class, 'confirmDelete'])
    ->name('configuraciones.confirmDelete');

    Route::get(
    'pacientes/{paciente}/consultas',
    [ConsultaController::class,'index']
    )->name('consultas.index');

    Route::get(
    '/consultas/{paciente_id}/create',
    [ConsultaController::class,'create']
    )->name('consultas.create');

    Route::post(
    '/consultas/store',
    [ConsultaController::class,'store']
    )->name('consultas.store');
    

    Route::get(
    'consultas/{id}',
    [ConsultaController::class,'show']
    )->name('consultas.show');

    Route::get(
    'consultas/{id}/edit',
    [ConsultaController::class,'edit']
    )->name('consultas.edit');

    Route::put(
        'consultas/{id}',
        [ConsultaController::class,'update']
    )->name('consultas.update');

    Route::delete(
        'consultas/{id}',
        [ConsultaController::class,'destroy']
    )->name('consultas.destroy');

    Route::get('pacientes/{id}/delete',
    [PacienteController::class, 'delete'])
    ->name('pacientes.delete');

    Route::delete('pacientes/{id}',
    [PacienteController::class, 'destroy'])
    ->name('pacientes.destroy');

    Route::get(
    'consultas/{id}/delete',
    [ConsultaController::class,'delete']
    )->name('consultas.delete');

    Route::get(
    'consultas/{id}/receta-pdf',
    [ConsultaController::class,'recetaPdf']
    )->name('consultas.recetaPdf');


});



/*
|--------------------------------------------------------------------------
| ASISTENTE
|--------------------------------------------------------------------------
*/

Route::prefix('asistente')
    ->middleware(['auth','role:asistente'])
    ->name('asistente.')
    ->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('pacientes/reporte-pdf', [PacienteController::class, 'reportePdf'])
    ->name('pacientes.reportePdf');
    // ✅ NUEVA RUTA
    Route::get('consultas/{id}/pdf', [ConsultaController::class, 'historiaPdf'])
    ->name('consultas.pdf');
    Route::resource('pacientes', PacienteController::class);
    
    Route::resource('citas', CitaController::class);
     Route::get('citas/{id}/confirm-delete', [CitaController::class, 'confirmDelete'])
    ->name('citas.confirmDelete');
    
    Route::get('horarios/reporte-pdf',[HorarioController::class,'reportePdf'])->name('horarios.pdf');
    Route::resource('horarios', HorarioController::class);
    
    
    Route::get(
    'horarios/{id}/confirm-delete',
    [HorarioController::class, 'confirmDelete']
)->name('horarios.confirmDelete');

    Route::get(
    'pacientes/{paciente}/consultas',
    [ConsultaController::class,'index']
    )->name('consultas.index');

    Route::get(
    '/consultas/{paciente_id}/create',
    [ConsultaController::class,'create']
    )->name('consultas.create');

    Route::post(
    '/consultas/store',
    [ConsultaController::class,'store']
    )->name('consultas.store');

    Route::get(
    'consultas/{id}',
    [ConsultaController::class,'show']
    )->name('consultas.show');

    Route::get(
    'consultas/{id}/edit',
    [ConsultaController::class,'edit']
    )->name('consultas.edit');

    Route::put(
        'consultas/{id}',
        [ConsultaController::class,'update']
    )->name('consultas.update');


    Route::delete(
        'consultas/{id}',
        [ConsultaController::class,'destroy']
    )->name('consultas.destroy');

    Route::get('pacientes/{id}/delete',
    [PacienteController::class, 'delete'])
    ->name('pacientes.delete');

    Route::delete('pacientes/{id}',
    [PacienteController::class, 'destroy'])
    ->name('pacientes.destroy');

    Route::get(
    'consultas/{id}/delete',
    [ConsultaController::class,'delete']
    )->name('consultas.delete');    

    Route::get(
    'consultas/{id}/receta-pdf',
    [ConsultaController::class,'recetaPdf']
)->name('consultas.recetaPdf');
});



/*
|--------------------------------------------------------------------------
| MEDICO
|--------------------------------------------------------------------------
*/
Route::prefix('medico')
    ->middleware(['auth','role:medico'])
    ->name('medico.')
    ->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('pacientes/reporte-pdf', [PacienteController::class, 'reportePdf'])
        ->name('pacientes.reportePdf');
    // ✅ NUEVA RUTA
    Route::get('consultas/{id}/pdf', [ConsultaController::class, 'historiaPdf'])
    ->name('consultas.pdf');
    Route::resource('pacientes', PacienteController::class);
   
    Route::resource('citas', CitaController::class);
    
    Route::get('horarios/reporte-pdf',[HorarioController::class,'reportePdf'])->name('horarios.pdf');
    Route::resource('horarios', HorarioController::class);

    Route::get(
    'pacientes/{paciente}/consultas',
    [ConsultaController::class,'index']
    )->name('consultas.index');

    Route::get(
    '/consultas/{paciente_id}/create',
    [ConsultaController::class,'create']
    )->name('consultas.create');

    Route::post(
    '/consultas/store',
    [ConsultaController::class,'store']
    )->name('consultas.store');

    Route::get(
    'consultas/{id}',
    [ConsultaController::class,'show']
    )->name('consultas.show');
    Route::get(
    'consultas/{id}/edit',
    [ConsultaController::class,'edit']
    )->name('consultas.edit');

    Route::put(
        'consultas/{id}',
        [ConsultaController::class,'update']
    )->name('consultas.update');

    Route::delete(
        'consultas/{id}',
        [ConsultaController::class,'destroy']
    )->name('consultas.destroy');

   Route::get('pacientes/{id}/delete',
    [PacienteController::class, 'delete'])
    ->name('pacientes.delete');

    Route::delete('pacientes/{id}',
    [PacienteController::class, 'destroy'])
    ->name('pacientes.destroy');

    Route::get(
    'consultas/{id}/delete',
    [ConsultaController::class,'delete']
    )->name('consultas.delete');

    Route::get(
    'consultas/{id}/receta-pdf',
    [ConsultaController::class,'recetaPdf']
    )->name('consultas.recetaPdf');

});