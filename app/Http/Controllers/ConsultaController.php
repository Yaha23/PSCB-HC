<?php

namespace App\Http\Controllers;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\SignoVital;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);

        $query = Consulta::with('medico','signosVitales')
            ->where('paciente_id', $paciente_id);

        // 🔥 médico solo ve consultas asignadas o todas según regla
        if (auth()->user()->hasRole('medico')) {
            $query->where('medico_id', auth()->id());
        }

        $consultas = $query->orderBy('fecha_atencion','desc')->get();

        $base = $this->getRouteBase();

        return view('admin.consultas.index', compact('paciente','consultas','base'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{

    $request->validate([
        'paciente_id' => 'required',
        'medico_id' => 'required',
        'especialidad' => 'required',
        'fecha_atencion' => 'required',

        'peso' => 'required',
        'talla' => 'required',
        'presion_arterial' => 'required',
        'frecuencia_cardiaca' => 'required',
        'temperatura' => 'required',
        'frecuencia_respiratoria' => 'required',
    ]);

    if(auth()->user()->hasRole('admin')){

        $request->validate([
            'diagnostico_principal' => 'required',
            'tratamiento' => 'required',
        ]);

    }

    // 🔥 SOLO ASISTENTE CREA CONSULTA PENDIENTE
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

    'diagnostico_principal' =>
        auth()->user()->hasRole('admin')
            ? $request->diagnostico_principal
            : null,

    'tratamiento' =>
        auth()->user()->hasRole('admin')
            ? $request->tratamiento
            : null,

    'acuerdos_compromisos' =>
        auth()->user()->hasRole('admin')
            ? $request->acuerdos_compromisos
            : null,

    'examenes_auxiliares' =>
        auth()->user()->hasRole('admin')
            ? $request->examenes_auxiliares
            : null,

    'referencia' =>
        auth()->user()->hasRole('admin')
            ? $request->referencia
            : null,

    'observaciones' =>
        auth()->user()->hasRole('admin')
            ? $request->observaciones
            : null,

    'estado' => auth()->user()->hasRole('admin')
        ? 'finalizada'
        : 'pendiente'

]);

    SignoVital::create([
        'consulta_id' => $consulta->id,
        'peso' => $request->peso,
        'talla' => $request->talla,
        'presion_arterial' => $request->presion_arterial,
        'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
        'temperatura' => $request->temperatura,
        'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
    ]);

    

        $mensaje = auth()->user()->hasRole('asistente')
    ? 'Atención registrada y enviada al médico correctamente'
    : 'Historia clínica registrada correctamente';

        return redirect()->route(
            $this->getRouteBase().'.consultas.index',
            $request->paciente_id
        )
        ->with('mensaje', $mensaje)
        ->with('icono', 'success');
}

    /**
     * Display the specified resource.
     */
    /**
     * VER UNA CONSULTA
     */
    public function show($id)
    
    {

    
        $consulta = Consulta::with(
            'paciente',
            'medico',
            'signosVitales'
        )->findOrFail($id);

        $base = $this->getRouteBase();

        return view(
            'admin.consultas.show',
            compact('consulta','base')
        );
    }

    /**
     * OBTENER RUTA SEGÚN ROL
     */
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

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $consulta = Consulta::with([
        'paciente',
        'medico',
        'signosVitales'
    ])->findOrFail($id);


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

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $consulta = Consulta::with('signosVitales')
        ->findOrFail($id);


    /*
    |--------------------------------------------------------------------------
    | ASISTENTE
    |--------------------------------------------------------------------------
    */

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


        // Actualizar asignación médica

        $consulta->update([
            'medico_id'=>$request->medico_id,
            'especialidad'=>$request->especialidad,
            'fecha_atencion'=>$request->fecha_atencion,

            'diagnostico_principal'=>$request->diagnostico_principal,

            'tratamiento'=>$request->tratamiento,

            'motivo_consulta'=>$request->motivo_consulta,

            'tiempo_enfermedad'=>$request->tiempo_enfermedad,

            'apetito'=>$request->apetito,

            'sed'=>$request->sed,

            'sueno'=>$request->sueno,

            'estado_animo'=>$request->estado_animo,

            'orina'=>$request->orina,

            'deposiciones'=>$request->deposiciones,

            'acuerdos_compromisos'=>$request->acuerdos_compromisos,

            'examenes_auxiliares'=>$request->examenes_auxiliares,

            'referencia'=>$request->referencia,

            'observaciones'=>$request->observaciones,

            'estado'=>'finalizada'

            ]);



        // Actualizar signos vitales

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
            'mensaje'=>'Datos clínicos actualizados correctamente',
            'icono'=>'success'
        ]);

    }



    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADOR
    |--------------------------------------------------------------------------
    */


    if(auth()->user()->hasRole('admin')){


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

            'diagnostico_principal'=>'required',
            'tratamiento'=>'required',

        ]);



       
        $consulta->update([
            'medico_id'=>$request->medico_id,
            'especialidad'=>$request->especialidad,
            'fecha_atencion'=>$request->fecha_atencion,

            'diagnostico_principal'=>$request->diagnostico_principal,

            'tratamiento'=>$request->tratamiento,

            'motivo_consulta'=>$request->motivo_consulta,

            'tiempo_enfermedad'=>$request->tiempo_enfermedad,

            'apetito'=>$request->apetito,

            'sed'=>$request->sed,

            'sueno'=>$request->sueno,

            'estado_animo'=>$request->estado_animo,

            'orina'=>$request->orina,

            'deposiciones'=>$request->deposiciones,

            'acuerdos_compromisos'=>$request->acuerdos_compromisos,

            'examenes_auxiliares'=>$request->examenes_auxiliares,

            'referencia'=>$request->referencia,

            'observaciones'=>$request->observaciones,

            'estado'=>'finalizada'

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
            'mensaje'=>'Historia clínica actualizada correctamente',
            'icono'=>'success'
        ]);

    }



    /*
    |--------------------------------------------------------------------------
    | MÉDICO
    |--------------------------------------------------------------------------
    */


    if(auth()->user()->hasRole('medico')){


$request->validate([

    'diagnostico_principal'=>'required',
    'tratamiento'=>'required',
    'acuerdos_compromisos'=>'required',
    'examenes_auxiliares'=>'required',
    'referencia'=>'required',
    'observaciones'=>'required',

]);



$consulta->update([


    'diagnostico_principal'=>$request->diagnostico_principal,

    'tratamiento'=>$request->tratamiento,


    'acuerdos_compromisos'=>$request->acuerdos_compromisos,


    'examenes_auxiliares'=>$request->examenes_auxiliares,


    'referencia'=>$request->referencia,


    'observaciones'=>$request->observaciones,


    'estado'=>'finalizada'


]);



return redirect()
->route(
    $this->getRouteBase().'.consultas.index',
    $consulta->paciente_id
)
->with([
    'mensaje'=>'Atención médica actualizada correctamente',
    'icono'=>'success'
]);

}



    abort(403);

}

    public function delete($id)
    {
        $consulta = Consulta::with([
            'paciente',
            'medico',
            'signosVitales'
        ])->findOrFail($id);

        $base = $this->getRouteBase();

        return view(
            'admin.consultas.delete',
            compact('consulta', 'base')
        );
    }
    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $user = auth()->user();

    $consulta = Consulta::with('signosVitales')->findOrFail($id);

    $paciente_id = $consulta->paciente_id;

    //======================
    // ADMIN
    //======================
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

    //======================
    // ASISTENTE
    //======================
    if ($user->hasRole('asistente')) {

        if ($consulta->signosVitales) {
            $consulta->signosVitales()->delete();
        }

        // Elimina también la consulta
        $consulta->delete();

        return redirect()
            ->route($this->getRouteBase().'.consultas.index', $paciente_id)
            ->with('mensaje', 'Signos y Datos Clinicos eliminados correctamente')
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

    // 🔒 SOLO SI HAY TRATAMIENTO
    if (!$consulta->tratamiento) {
        abort(404);
    }

    $pdf = Pdf::loadView(
        'admin.consultas.receta_pdf',
        compact('consulta')
    )->setPaper('a5', 'portrait');

    return $pdf->stream(
        'Receta_Medica_'.$consulta->id.'.pdf'
    );
}

}
