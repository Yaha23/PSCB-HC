<?php

namespace App\Http\Controllers;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\SignoVital;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Configuracion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    
   public function index(Request $request, $paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);

        $query = Consulta::with('medico','signosVitales')
                ->where('paciente_id', $paciente_id);

        
        if(auth()->user()->hasRole('medico')){
            $query->where('medico_id', auth()->id());
        }

        

        if($request->estado == 'pendiente'){
            $query->where('estado', 'pendiente');
            }

        if($request->estado == 'registrado'){
                $query->where('estado', 'finalizada');
            }

        $consultas = $query
            ->orderBy('fecha_atencion','desc')
            ->get();

        $totalQuery = Consulta::where('paciente_id', $paciente_id);
        $pendientesQuery = Consulta::where('paciente_id', $paciente_id)->where('estado','pendiente');
        $registradosQuery = Consulta::where('paciente_id', $paciente_id)->where('estado','finalizada');


        if(auth()->user()->hasRole('medico')){

            $totalQuery->where('medico_id', auth()->id());
            $pendientesQuery->where('medico_id', auth()->id());
            $registradosQuery->where('medico_id', auth()->id());

        }

        $total = $totalQuery->count();
        $pendientes = $pendientesQuery->count();
        $registrados = $registradosQuery->count();

            $base = $this->getRouteBase();

            return view(
                'admin.consultas.index',
                compact(
                    'paciente',
                    'consultas',
                    'base',
                    'total',
                    'pendientes',
                    'registrados'
                )
            );
    }

   
   public function create($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);

        $medicos = \App\Models\User::role('medico')->get();

        $ultimaConsulta = Consulta::where('paciente_id', $paciente_id)
            ->latest()
            ->first();

        $base = $this->getRouteBase();

        return view('admin.consultas.create', compact(
            'paciente',
            'medicos',
            'ultimaConsulta',
            'base'
        ));
    }

   public function store(Request $request)
{
  

    $request->validate([

        'paciente_id' => 'required|exists:pacientes,id',
        'medico_id' => 'required|exists:users,id',
        'especialidad' => 'required',

        'fecha_atencion' => 'required|date',
        'hora_atencion' => 'required',

        'peso' => 'required|numeric',
        'talla' => 'required|numeric',
        'presion_arterial' => 'required',
        'frecuencia_cardiaca' => 'required|numeric',
        'temperatura' => 'required|numeric',
        'frecuencia_respiratoria' => 'required|numeric',
    ]);


    if (auth()->user()->hasRole('admin')) {

        $request->validate([

            'motivo_consulta' => 'required',
            'tiempo_enfermedad' => 'required',
            'apetito' => 'required',
            'sed' => 'required',
            'sueno' => 'required',
            'estado_animo' => 'required',
            'orina' => 'required',
            'deposiciones' => 'required',

            'diagnostico_principal' => 'required',
            'tratamiento' => 'required',
            'acuerdos_compromisos' => 'required',
            'examenes_auxiliares' => 'required',
            'referencia' => 'required',
            'observaciones' => 'required',

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EVITAR HISTORIAS DUPLICADAS
    |--------------------------------------------------------------------------
    |
    | Comprobamos si ya existe una consulta para:
    | mismo paciente + mismo médico + misma fecha + misma hora.
    |
    */

    $duplicado = Consulta::where('paciente_id', $request->paciente_id)
        ->where('medico_id', $request->medico_id)
        ->where('fecha_atencion', $request->fecha_atencion)
        ->where('hora_atencion', $request->hora_atencion)
        ->exists();


    if ($duplicado) {

        return redirect()
            ->route(
                $this->getRouteBase() . '.consultas.index',
                $request->paciente_id
            )
            ->with([
                'mensaje' => 'Esta historia clínica ya fue registrada para este paciente, médico, fecha y hora.',
                'icono' => 'warning'
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR HISTORIA CLÍNICA
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use ($request, &$consulta) {

        $consulta = Consulta::create([

            'paciente_id' => $request->paciente_id,

            'medico_id' => $request->medico_id,

            'asistente_id' => auth()->user()->hasRole('asistente')
                ? auth()->id()
                : null,

            'especialidad' => $request->especialidad,

            'fecha_atencion' => $request->fecha_atencion,

            'hora_atencion' => $request->hora_atencion,

            'motivo_consulta' => $request->motivo_consulta,

            'tiempo_enfermedad' => $request->tiempo_enfermedad,

            'apetito' => $request->apetito,

            'sed' => $request->sed,

            'sueno' => $request->sueno,

            'estado_animo' => $request->estado_animo,

            'orina' => $request->orina,

            'deposiciones' => $request->deposiciones,


            /*
            |--------------------------------------------------------------------------
            | DATOS MÉDICOS
            |--------------------------------------------------------------------------
            */

            'diagnostico_principal' => auth()->user()->hasRole('admin')
                ? $request->diagnostico_principal
                : null,

            'tratamiento' => auth()->user()->hasRole('admin')
                ? $request->tratamiento
                : null,

            'acuerdos_compromisos' => auth()->user()->hasRole('admin')
                ? $request->acuerdos_compromisos
                : null,

            'examenes_auxiliares' => auth()->user()->hasRole('admin')
                ? $request->examenes_auxiliares
                : null,

            'referencia' => auth()->user()->hasRole('admin')
                ? $request->referencia
                : null,

            'observaciones' => auth()->user()->hasRole('admin')
                ? $request->observaciones
                : null,


          

            'estado' => auth()->user()->hasRole('admin')
                ? 'finalizada'
                : 'pendiente',

        ]);


        /*
        |--------------------------------------------------------------------------
        | SIGNOS VITALES
        |--------------------------------------------------------------------------
        */

        SignoVital::create([

            'consulta_id' => $consulta->id,

            'peso' => $request->peso,

            'talla' => $request->talla,

            'presion_arterial' => $request->presion_arterial,

            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,

            'temperatura' => $request->temperatura,

            'frecuencia_respiratoria' => $request->frecuencia_respiratoria,

        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | MENSAJE
    |--------------------------------------------------------------------------
    */

    if (auth()->user()->hasRole('admin')) {

        $mensaje = 'Historia clínica registrada correctamente.';

    } elseif (auth()->user()->hasRole('asistente')) {

        $mensaje = 'Datos clínicos registrados y enviados al médico correctamente.';

    } else {

        $mensaje = 'Historia clínica registrada correctamente.';

    }


    return redirect()
        ->route(
            $this->getRouteBase() . '.consultas.index',
            $consulta->paciente_id
        )
        ->with([
            'mensaje' => $mensaje,
            'icono' => 'success'
        ]);
}



    public function show($id)
    {
        $consulta = Consulta::with('paciente','medico','signosVitales' )->findOrFail($id);
        $base = $this->getRouteBase();

        return view('admin.consultas.show', compact('consulta','base')
        );
    }

  
    private function getRouteBase()
    {
        if (auth()->user()->hasRole('admin')) {
            return 'admin';
        }

        if (auth()->user()->hasRole('asistente')) {
            return 'asistente';
        }

        if (auth()->user()->hasRole('medico')) {
            return 'medico';
        }

        return '';
    }

  
   public function edit($id)
    {
        $consulta = Consulta::with(['paciente', 'medico', 'signosVitales' ])->findOrFail($id);
        $medicos = \App\Models\User::role('medico')->get();
        $base = $this->getRouteBase();

        if (
            !auth()->user()->hasRole('medico') &&
            !auth()->user()->hasRole('admin') &&
            !auth()->user()->hasRole('asistente')
        ) {
            abort(403);
        }


        return view('admin.consultas.edit',
            compact(
                'consulta',
                'base',
                'medicos'
            )
        );
    }

  
    public function update(Request $request, $id)
    {
        $consulta = Consulta::with('signosVitales')->findOrFail($id);


        if(auth()->user()->hasRole('asistente')){


            $request->validate([

                'medico_id'=>'required',
                'especialidad'=>'required',
                'fecha_atencion'=>'required',

                'peso'=>'required',
                'talla'=>'required',
                'presion_arterial'=>'required',
                'temperatura'=>'required',
                'frecuencia_cardiaca'=>'required',
                'frecuencia_respiratoria'=>'required',

            ]);

            $consulta->update([

                'medico_id'     => $request->medico_id,
                'especialidad'  => $request->especialidad,
                'fecha_atencion'=> $request->fecha_atencion,
                'hora_atencion' => $request->hora_atencion,
                'estado' => 'pendiente'

            ]);


            $consulta->signosVitales()->update([

                'peso'=>$request->peso,
                'talla'=>$request->talla,
                'presion_arterial'=>$request->presion_arterial,
                'temperatura'=>$request->temperatura,
                'frecuencia_cardiaca'=>$request->frecuencia_cardiaca,
                'frecuencia_respiratoria'=>$request->frecuencia_respiratoria,
            ]);

            return redirect()
            ->route(
                $this->getRouteBase().'.consultas.index',
                $consulta->paciente_id
            )
            ->with([
                'mensaje'=>'Asignación médica y Datos clínicos actualizados correctamente',
                'icono'=>'success'
            ]);

        }

        if(auth()->user()->hasRole('admin')){

    $request->validate([

        'medico_id' => 'required',
        'especialidad' => 'required',
        'fecha_atencion' => 'required',

        'peso' => 'required',
        'talla' => 'required',
        'presion_arterial' => 'required',
        'temperatura' => 'required',
        'frecuencia_cardiaca' => 'required',
        'frecuencia_respiratoria' => 'required',

        'motivo_consulta' => 'required',
        'tiempo_enfermedad' => 'required',
        'apetito' => 'required',
        'sed' => 'required',
        'sueno' => 'required',
        'estado_animo' => 'required',
        'orina' => 'required',
        'deposiciones' => 'required',

        'diagnostico_principal' => 'required',
        'tratamiento' => 'required',
        'acuerdos_compromisos' => 'required',
        'examenes_auxiliares' => 'required',
        'referencia' => 'required',
        'observaciones' => 'required',

    ]);

    // Detectamos si la historia estaba pendiente
    $primeraVez = empty($consulta->diagnostico_principal);

    $consulta->update([

        'medico_id' => $request->medico_id,
        'especialidad' => $request->especialidad,
        'fecha_atencion' => $request->fecha_atencion,
        'hora_atencion' => $request->hora_atencion,

        'motivo_consulta' => $request->motivo_consulta,
        'tiempo_enfermedad' => $request->tiempo_enfermedad,
        'apetito' => $request->apetito,
        'sed' => $request->sed,
        'sueno' => $request->sueno,
        'estado_animo' => $request->estado_animo,
        'orina' => $request->orina,
        'deposiciones' => $request->deposiciones,

        'diagnostico_principal' => $request->diagnostico_principal,
        'tratamiento' => $request->tratamiento,
        'acuerdos_compromisos' => $request->acuerdos_compromisos,
        'examenes_auxiliares' => $request->examenes_auxiliares,
        'referencia' => $request->referencia,
        'observaciones' => $request->observaciones,

        'estado' => 'finalizada',

    ]);

    $consulta->signosVitales()->update([

        'peso' => $request->peso,
        'talla' => $request->talla,
        'presion_arterial' => $request->presion_arterial,
        'temperatura' => $request->temperatura,
        'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
        'frecuencia_respiratoria' => $request->frecuencia_respiratoria,

    ]);

    // Mensaje diferente según la situación
    $mensaje = $primeraVez
        ? 'Historia clínica completada correctamente.'
        : 'Historia clínica actualizada correctamente.';

    return redirect()
        ->route(
            $this->getRouteBase().'.consultas.index',
            $consulta->paciente_id
        )
        ->with([
            'mensaje' => $mensaje,
            'icono' => 'success'
        ]);
}


        if(auth()->user()->hasRole('medico')){

            $request->validate([

                'motivo_consulta'=>'required',
                'tiempo_enfermedad'=>'required',
                'apetito'=>'required',
                'sed'=>'required',
                'sueno'=>'required',
                'estado_animo'=>'required',
                'orina'=>'required',
                'deposiciones'=>'required',
                'diagnostico_principal'=>'required',
                'tratamiento'=>'required',
                'acuerdos_compromisos'=>'required',
                'examenes_auxiliares'=>'required',
                'referencia'=>'required',
                'observaciones'=>'required',
            ]);

            $primeraVez = empty($consulta->diagnostico_principal);
            $consulta->update([

                'motivo_consulta'=>$request->motivo_consulta,
                'tiempo_enfermedad'=>$request->tiempo_enfermedad,
                'apetito'=>$request->apetito,
                'sed'=>$request->sed,
                'sueno'=>$request->sueno,
                'estado_animo'=>$request->estado_animo,
                'orina'=>$request->orina,
                'deposiciones'=>$request->deposiciones,
                'diagnostico_principal'=>$request->diagnostico_principal,
                'tratamiento'=>$request->tratamiento,
                'acuerdos_compromisos'=>$request->acuerdos_compromisos,
                'examenes_auxiliares'=>$request->examenes_auxiliares,
                'referencia'=>$request->referencia,
                'observaciones'=>$request->observaciones,

                'estado'=>'finalizada'

            ]);

            
            $mensaje = $primeraVez
            ? 'Historia clínica completada correctamente.'
            : 'Historia clínica actualizada correctamente.';

            return redirect()
                ->route(
                    $this->getRouteBase().'.consultas.index',
                    $consulta->paciente_id
                )
                ->with([
                    'mensaje' => $mensaje,
                    'icono' => 'success'
                ]);
        }



        abort(403);

    }

    public function delete($id)
    {
        $consulta = Consulta::with([ 'paciente', 'medico','signosVitales' ])->findOrFail($id);
        $base = $this->getRouteBase();
        return view( 'admin.consultas.delete', compact('consulta', 'base')
        );
    }
    

  public function destroy($id)
    {
        $user = auth()->user();
        $consulta = Consulta::with('signosVitales')->findOrFail($id);
        $paciente_id = $consulta->paciente_id;

        if ($user->hasRole('admin')) {

            if ($consulta->signosVitales) {
                $consulta->signosVitales()->delete();
            }

            $consulta->delete();

            return redirect()
                ->route($this->getRouteBase().'.consultas.index', $paciente_id)
                ->with('mensaje', 'Historia clínica eliminada correctamente')
                ->with('icono', 'success');
        }

        if ($user->hasRole('asistente')) {

            if ($consulta->signosVitales) {
                $consulta->signosVitales()->delete();
            }

            
            $consulta->delete();

            return redirect()
                ->route($this->getRouteBase().'.consultas.index', $paciente_id)
                ->with('mensaje', 'Asignación médica y Datos clínicos eliminados correctamente')
                ->with('icono', 'success');
        }

        abort(403);
    }

    public function historiaPdf($id)
    {
        $consulta = Consulta::with([
            'paciente',
            'medico',
            'signosVitales'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.consultas.PSCB_Historia_Clinica',
            compact('consulta')
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Historia_Clinica_'.$consulta->paciente->DNI.'.pdf'
        );
    }

    public function recetaPdf($id)
    {
        $consulta = Consulta::with([
            'paciente',
            'medico',
            'signosVitales'
        ])->findOrFail($id);

        if (!$consulta->tratamiento) {
            abort(404);
        }

        $configuracion = Configuracion::first();

        $pdf = Pdf::loadView(
            'admin.consultas.receta_pdf',
            compact('consulta', 'configuracion')
        )->setPaper('a5', 'portrait');

        return $pdf->stream(
            'Receta_Medica_'.$consulta->id.'.pdf'
        );
    }

}
