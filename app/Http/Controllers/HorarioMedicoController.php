<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioMedico;
use App\Models\Consulta;
use App\Models\User; // 👈 ESTA LÍNEA FALTABA
class HorarioMedicoController extends Controller
{
   public function index()
{
    $user = auth()->user();

    if($user->hasRole('medico')){
        $horariosmedicos = HorarioMedico::with('medico')
            ->where('medico_id', $user->id)
            ->paginate(10);
    } else {
        $horariosmedicos = HorarioMedico::with('medico')->paginate(10);
    }

    return view('admin.horariosmedicos.index', compact('horariosmedicos'));
}

    public function create()
    {
        $medicos = User::role('medico')->get();

        return view('admin.horariosmedicos.create', compact('medicos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'medico_id' => 'required',
        'dia_semana' => 'required',
        'hora_inicio' => 'required',
        'hora_fin' => 'required',
    ]);

        //Obtener el médico seleccionado
        $medico = User::findOrFail($request->medico_id);

        //  Validar cruce de horarios por ESPECIALIDAD
    $conflicto = HorarioMedico::whereHas('medico', function ($query) use ($medico) {
        $query->where('specialty', $medico->specialty);        
        })
        ->where('dia_semana', $request->dia_semana)
        ->where(function ($query) use ($request) {
            $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                ->orWhere(function ($q) use ($request) {
                    $q->where('hora_inicio', '<=', $request->hora_inicio)
                      ->where('hora_fin', '>=', $request->hora_fin);
                });
        })
        ->exists();

    // 🚫 Si hay conflicto, no guardar
    if ($conflicto) {
        return redirect()->back()
            ->withInput()
            ->with('mensaje', 'Ya existe un horario en esa especialidad en ese rango de horas')
            ->with('icono', 'error');
    }

    // ✅ Guardar si todo está bien
    HorarioMedico::create($request->all());

    return redirect()->route($this->getRouteBase().'.horariosmedicos.index')
        ->with('mensaje', 'Horario registrado correctamente')
        ->with('icono', 'success');
}

    public function show($id)
    {
        $horario = HorarioMedico::findOrFail($id);
        return view('admin.horariosmedicos.show', compact('horario'));
    }

    public function edit($id)
    {
        $horario = HorarioMedico::findOrFail($id);
        $medicos = User::role('medico')->get();
        return view('admin.horariosmedicos.edit', compact('horario','medicos'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'medico_id' => 'required',
        'dia_semana' => 'required',
        'hora_inicio' => 'required',
        'hora_fin' => 'required',
    ]);

    $horario = HorarioMedico::findOrFail($id);

    $medico = User::findOrFail($request->medico_id);
    $conflicto = HorarioMedico::whereHas('medico', function ($query) use ($medico) {
        $query->where('specialty', $medico->specialty);        })
        ->where('dia_semana', $request->dia_semana)
        ->where('id', '!=', $id) // 👈 importante para excluir el actual
        ->where(function ($query) use ($request) {
            $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                ->orWhere(function ($q) use ($request) {
                    $q->where('hora_inicio', '<=', $request->hora_inicio)
                      ->where('hora_fin', '>=', $request->hora_fin);
                });
        })
        ->exists();

    if ($conflicto) {
        return redirect()->back()
            ->withInput()
            ->with('mensaje', 'Conflicto de horario en esa especialidad')
            ->with('icono', 'error');
    }

    $horario->update([
        'medico_id' => $request->medico_id,
        'dia_semana' => $request->dia_semana,
        'hora_inicio' => $request->hora_inicio,
        'hora_fin' => $request->hora_fin,
    ]);

    return redirect()->route($this->getRouteBase().'.horariosmedicos.index')
        ->with('mensaje', 'Horario actualizado correctamente')
        ->with('icono', 'success');
}

    public function confirmDelete($id)
    {
        $horario = HorarioMedico::findOrFail($id);
        return view('admin.horariosmedicos.delete', compact('horario'));
    }

    public function destroy($id)
    {
        HorarioMedico::destroy($id);

        return redirect()->route($this->getRouteBase().'.horariosmedicos.index')
        ->with('mensaje', 'Horario eliminado correctamente')
        ->with('icono', 'success');
    }

    private function getRouteBase()
{
    if (auth()->user()->hasRole('admin')) return 'admin';
    if (auth()->user()->hasRole('asistente')) return 'asistente';
    if (auth()->user()->hasRole('medico')) return 'medico';

    return '';
}
}
