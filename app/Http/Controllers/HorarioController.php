<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Configuracion;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class HorarioController extends Controller
{

  public function index(Request $request)
    {
        $user = auth()->user();
        $buscar = $request->buscar;
        $rol = $request->rol;
        $query = Horario::with('user');

        if($user->hasRole('medico')){
            $query->where('user_id',$user->id);
        }

        if($buscar && !$user->hasRole('medico')){

            $query->whereHas('user', function($q) use ($buscar){

                $q->where('name','LIKE','%'.$buscar.'%')
                ->orWhere('surname','LIKE','%'.$buscar.'%');

            });

        }

        if($rol && !$user->hasRole('medico')){
            $query->whereHas('user', function($q) use ($rol){
                $q->role($rol);

            });

        }

        $horarios = $query
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view( 'admin.horarios.index', compact( 'horarios','buscar', 'rol'));
    }

    public function create()
    {

        $medicos = User::role('medico')->get();
        $asistentes = User::role('asistente')->get();

       return view( 'admin.horarios.create', compact( 'medicos','asistentes'));
    }

    public function store(Request $request)
    {

        $request->validate([

            'user_id'=>'required',
            'rol'=>'required',
            'dia_semana'=>'required',
            'hora_inicio'=>'required',
            'hora_fin'=>'required',

        ]);
        $usuario = User::findOrFail($request->user_id);

        if($request->rol == 'medico'){


            $conflicto = Horario::whereHas('user', function($query) use ($usuario){
                    $query->where('specialty',$usuario->specialty);
                })

                ->where('dia_semana',$request->dia_semana)

                ->where(function($query) use ($request){

                    $query->whereBetween('hora_inicio',[$request->hora_inicio,$request->hora_fin])
                    ->orWhereBetween(
                        'hora_fin',
                        [
                            $request->hora_inicio,
                            $request->hora_fin
                        ]
                    )

                    ->orWhere(function($q) use ($request){
                        $q->where(
                            'hora_inicio',
                            '<=',
                            $request->hora_inicio
                        )

                        ->where(
                            'hora_fin',
                            '>=',
                            $request->hora_fin
                        );

                    });


                })->exists();

            if($conflicto){

                return back()->withInput()->with('mensaje','Ya existe un horario para esa especialidad')
                ->with('icono','error');


            }

        }


        Horario::create([

            'user_id'=>$request->user_id,
            'especialidad'=>$request->especialidad,
            'dia_semana'=>$request->dia_semana,
            'hora_inicio'=>$request->hora_inicio,
            'hora_fin'=>$request->hora_fin,
        ]);

        return redirect()->route($this->getRouteBase().'.horarios.index')
        ->with('mensaje','Horario registrado correctamente')
        ->with('icono','success');

    }


    public function show($id)
    {

        $horario = Horario::with('user')->findOrFail($id);
        return view('admin.horarios.show',compact('horario'));
    }

    public function edit($id)
{
    $horario = Horario::with('user')->findOrFail($id);
    $user = auth()->user();
    if ($user->hasRole('medico') && $horario->user_id != $user->id) {
        abort(403);
    }

    $medicos = User::role('medico')->get();
    $asistentes = User::role('asistente')->get();

    return view('admin.horarios.edit',compact('horario','medicos','asistentes'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'rol'          => 'required',
            'dia_semana'   => 'required',
            'hora_inicio'  => 'required',
            'hora_fin'     => 'required',
        ]);

        $horario = Horario::findOrFail($id);
        $usuario = User::findOrFail($request->user_id);

        if ($request->rol == 'medico') {
            $conflicto = Horario::whereHas('user', function ($query) use ($usuario) {
                    $query->where('specialty', $usuario->specialty);
                })

                ->where('id', '!=', $id)
                ->where('dia_semana', $request->dia_semana)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('hora_inicio', [
                        $request->hora_inicio,
                        $request->hora_fin
                    ])
                    ->orWhereBetween('hora_fin', [
                        $request->hora_inicio,
                        $request->hora_fin
                    ])

                    ->orWhere(function ($q) use ($request) {

                        $q->where('hora_inicio', '<=', $request->hora_inicio)
                        ->where('hora_fin', '>=', $request->hora_fin);

                    });

                })->exists();

            if ($conflicto) {

                return back()
                    ->withInput()
                    ->with('mensaje', 'Ya existe un horario para esa especialidad.')
                    ->with('icono', 'error');

            }

        }

        $horario->update([

            'user_id' => $request->user_id,

            'especialidad' => $request->rol == 'medico'
                ? $usuario->specialty
                : null,

            'dia_semana' => $request->dia_semana,

            'hora_inicio' => $request->hora_inicio,

            'hora_fin' => $request->hora_fin,

        ]);

        return redirect()
            ->route($this->getRouteBase().'.horarios.index')
            ->with('mensaje', 'Horario actualizado correctamente')
            ->with('icono', 'success');
    }


   
public function confirmDelete($id)
{
    $horario = Horario::with('user')->findOrFail($id);

    $base = $this->getRouteBase();

    return view('admin.horarios.delete', compact('horario', 'base'));
}


    public function destroy($id)
    {
        Horario::destroy($id);
        return redirect()->route($this->getRouteBase().'.horarios.index')
        ->with('mensaje',
        'Horario eliminado correctamente')
        ->with('icono','success');

    }

    private function getRouteBase()
    {

        if(auth()->user()->hasRole('admin'))
            return 'admin';
        if(auth()->user()->hasRole('asistente'))
            return 'asistente';
        if(auth()->user()->hasRole('medico'))
            return 'medico';
        return '';

    }

    
public function reportePdf(Request $request)
{
    $user = auth()->user();
    $buscar = $request->buscar;
    $rol = $request->rol;

    $query = Horario::with('user');

    if ($user->hasRole('medico')) {
        $query->where('user_id', $user->id);
    }

    if ($buscar) {
        $query->whereHas('user', function ($q) use ($buscar) {
            $q->where('name', 'LIKE', "%$buscar%")
              ->orWhere('surname', 'LIKE', "%$buscar%");
        });
    }

    if ($rol) {
        $query->whereHas('user', function ($q) use ($rol) {
            $q->role($rol);
        });
    }

    $horarios = $query
        ->orderBy('id', 'asc')
        ->get();

    // Obtener la configuración actual del sistema
    $configuracion = Configuracion::first();

    // Generar el PDF con los horarios y el logo configurado
    $pdf = Pdf::loadView(
        'admin.horarios.reporte_pdf',
        compact('horarios', 'configuracion')
    );

    return $pdf->stream('horarios_personal.pdf');
}


}