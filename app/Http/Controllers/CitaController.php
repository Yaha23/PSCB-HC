<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;

class CitaController extends Controller
{
 public function index(Request $request)
{
    $user = auth()->user();

    $buscar = $request->buscar;
    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;

    $citas = Cita::with(['medico', 'paciente']);

    /*
    |--------------------------------------------------------------------------
    | FILTRO POR MÉDICO
    |--------------------------------------------------------------------------
    */

    if ($user->hasRole('medico')) {

        $citas->where('medico_id', $user->id);

        $base = 'medico';

    } elseif ($user->hasRole('asistente')) {

        $base = 'asistente';

    } else {

        $base = 'admin';
    }


    /*
    |--------------------------------------------------------------------------
    | FILTRO POR FECHA
    |--------------------------------------------------------------------------
    */

    if ($fecha_inicio && $fecha_fin) {

        $citas->whereBetween('fecha', [
            $fecha_inicio,
            $fecha_fin
        ]);

    } elseif ($fecha_inicio) {

        $citas->whereDate('fecha', '>=', $fecha_inicio);

    } elseif ($fecha_fin) {

        $citas->whereDate('fecha', '<=', $fecha_fin);
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR PACIENTE
    |--------------------------------------------------------------------------
    */

    $citas->when($buscar, function ($query, $buscar) {

    $query->whereHas('paciente', function ($q) use ($buscar) {

        $q->where('nombres', 'like', "%{$buscar}%")
          ->orWhere('apellidos', 'like', "%{$buscar}%");

    });

});


    /*
    |--------------------------------------------------------------------------
    | ORDEN DE REGISTRO
    |--------------------------------------------------------------------------
    */

    $citas = $citas
        ->orderBy('id', 'asc')
        ->paginate(10)
        ->withQueryString();


    return view('admin.citas.index', compact(
        'citas',
        'base',
        'buscar',
        'fecha_inicio',
        'fecha_fin'
    ));
}

    public function create()
    {
        $medicos = User::role('medico')->get();
        $pacientes = Paciente::all();

         $user = auth()->user();

        if ($user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = 'asistente';
        }

        return view('admin.citas.create', compact('medicos','pacientes','base'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = 'asistente';
        }
        $request->validate([
            'medico_id' => 'required|exists:users,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        Cita::create($request->all());

         return redirect()->route($base.'.citas.index')
            ->with('mensaje', 'Cita Medica registrada correctamente')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $cita = Cita::with(['medico','paciente'])->findOrFail($id);
        return view('admin.citas.show', compact('cita'));
    }

    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        $medicos = User::role('medico')->get(); 

        $pacientes = Paciente::all();

        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = 'asistente';
        }

        return view('admin.citas.edit', compact('cita','medicos','pacientes','base'));
    }

    public function update(Request $request, $id)
    {
            $user = auth()->user();

        if ($user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = 'asistente';
        }
        $cita = Cita::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route($base.'.citas.index')
        ->with('mensaje', 'Cita Medica actualizada correctamente.')
        ->with('icono', 'success');
    }

    public function confirmDelete($id)
    {
        $cita = Cita::findOrFail($id);
        return view('admin.citas.delete', compact('cita'));
    }

    public function destroy($id)
    {
        Cita::destroy($id);
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = 'asistente';
        }

         return redirect()->route($base.'.citas.index')
        ->with('mensaje', 'Cita Medica eliminada correctamente.')
        ->with('icono', 'success');
    }

 public function cambiarEstado(Request $request, $id)
{
    $user = auth()->user();

    $cita = Cita::findOrFail($id);

    $request->validate([
        'estado' => 'required|in:pendiente,atendida,cancelada'
    ]);


    if ($user->hasRole('admin')) {
        $cita->estado = $request->estado;
    }

    
    elseif ($user->hasRole('medico')) {

        if ($cita->medico_id != $user->id) {
            abort(403, 'No puedes modificar esta cita');
        }

        $cita->estado = $request->estado;
    }

    else {
        abort(403, 'No tienes permisos para cambiar el estado');
    }

    $cita->save();


    switch ($request->estado) {
        case 'pendiente':
            $mensaje = 'Cita marcada como pendiente correctamente';
            break;

        case 'atendida':
            $mensaje = 'Cita atendida correctamente';
            break;

        case 'cancelada':
            $mensaje = 'Cita cancelada correctamente';
            break;
    }

    return back()
        ->with('mensaje', $mensaje)
        ->with('icono', 'success');
}

        public function __construct()
    {
        $this->middleware('can:admin.citas.index')->only('index');
        $this->middleware('can:admin.citas.create')->only('create','store');
        $this->middleware('can:admin.citas.edit')->only('edit','update');
        $this->middleware('can:admin.citas.destroy')->only('destroy');
    }

    


}
