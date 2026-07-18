<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;

class CitaController extends Controller
{
  public function index()
{
    $user = auth()->user();

    if ($user->hasRole('medico')) {
        $citas = Cita::with(['medico','paciente'])
            ->where('medico_id', $user->id)
            ->paginate(10);

        $base = 'medico';

    } elseif ($user->hasRole('asistente')) {

        $citas = Cita::with(['medico','paciente'])->paginate(10);
        $base = 'asistente';

    } else {

        $citas = Cita::with(['medico','paciente'])->paginate(10);
        $base = 'admin';
    }

    return view('admin.citas.index', compact('citas','base'));
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
        $medicos = User::role('medico')->get(); // ✅ CORRECTO

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

    // VALIDACIÓN DE ESTADO
    $request->validate([
        'estado' => 'required|in:pendiente,atendida,cancelada'
    ]);

    /*
    ==================================================
    🔐 CONTROL POR ROL
    ==================================================
    */

    // 🟡 ADMIN: puede todo
    if ($user->hasRole('admin')) {
        $cita->estado = $request->estado;
    }

    // 🟢 MEDICO: solo sus propias citas
    elseif ($user->hasRole('medico')) {

        if ($cita->medico_id != $user->id) {
            abort(403, 'No puedes modificar esta cita');
        }

        $cita->estado = $request->estado;
    }

    // 🔴 ASISTENTE: NO puede cambiar estado
    else {
        abort(403, 'No tienes permisos para cambiar el estado');
    }

    $cita->save();

    /*
    ==================================================
    MENSAJES
    ==================================================
    */
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
