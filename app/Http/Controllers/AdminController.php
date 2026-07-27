<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paciente; 
use App\Models\Horario; 
use App\Models\Cita; 





class AdminController extends Controller
{
   public function index(){

    $user = auth()->user();

    // 🔒 VALIDAR ACCESO
    if(request()->is('admin') && !$user->hasRole('admin')){
        abort(403);
    }

    if(request()->is('asistente') && !$user->hasRole('asistente')){
        abort(403);
    }

    if(request()->is('medico') && !$user->hasRole('medico')){
        abort(403);
    }

    // =========================
    // 📊 CONTADORES
    // =========================

    if($user->hasRole('admin') || $user->hasRole('asistente')){
        
        $total_usuarios = User::count();
        $total_pacientes = Paciente::count();
        $total_horarios = Horario::count();
        $total_citas = Cita::where('estado', 'pendiente')->count();

    } else {

        // 👨‍⚕️ MÉDICO → SOLO SUS DATOS
        $total_usuarios = 0;

        $total_pacientes = Paciente::whereHas('consultas', function ($q) use ($user) {
            $q->where('medico_id', $user->id);
        })->count();

        $total_horarios = Horario::where('user_id', $user->id)->count();

        $total_citas = Cita::where('medico_id', $user->id)
            ->where('estado', 'pendiente')
            ->count();
    }

    // =========================
    // 📅 CALENDARIO (AQUÍ ESTÁ LA CLAVE)
    // =========================

    if($user->hasRole('admin') || $user->hasRole('asistente')){

        // 👑 ADMIN / ASISTENTE → TODAS
        $citas = Cita::where('estado', 'pendiente')->get();

    } else {

        // 👨‍⚕️ MÉDICO → SOLO SUS CITAS
        $citas = Cita::where('medico_id', $user->id)
            ->where('estado', 'pendiente')
            ->get();
    }

    $citas_calendario = $citas->map(function($cita){
        return [
            'title' => 'Cita médica',
            'start' => $cita->fecha,
        ];
    });

    return view(
        'admin.index',
        compact(
            'total_usuarios',
            'total_pacientes',
            'total_horarios',
            'total_citas',
            'citas_calendario'
        )
    );

    

    
}

private function getRouteBase()
{
    if(auth()->user()->hasRole('admin')){
        return 'admin';
    }

    if(auth()->user()->hasRole('asistente')){
        return 'asistente';
    }

    if(auth()->user()->hasRole('medico')){
        return 'medico';
    }

    abort(403);
}

}
