<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Configuracion;
use App\Models\SignoVital;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\Request;


class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $pacientes = Paciente::with('consultas.medico');


        if($fecha_inicio && $fecha_fin){

            $pacientes->whereBetween('created_at', [
                $fecha_inicio . ' 00:00:00',
                $fecha_fin . ' 23:59:59'
            ]);

        }


        if (auth()->user()->hasRole('medico')) {

            $pacientes->whereHas('consultas', function ($q) {
                $q->where('medico_id', auth()->id());
            });

        }


        $pacientes = $pacientes
            ->when($buscar, function ($query, $buscar) {

                $query->where(function ($q) use ($buscar) {

                    $q->where('nombres', 'like', "%$buscar%")
                    ->orWhere('apellidos', 'like', "%$buscar%")
                    ->orWhere('DNI', 'like', "%$buscar%");

                });

            })
            ->paginate(10)
            ->withQueryString();


        return view('admin.pacientes.index', compact(
            'pacientes',
            'buscar',
            'fecha_inicio',
            'fecha_fin'
        ));
    }

   public function create()
    {
        if(!auth()->user()->hasAnyRole(['admin','asistente'])){
            abort(403);
        }

        $medicos = User::role('medico')->get();

        return view(
            'admin.pacientes.create',
            compact('medicos')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'DNI' => 'required|unique:pacientes,DNI',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required',
            'celular' => 'required',
            'email' => 'required|email|unique:pacientes,email',
            'direccion' => 'required',
            'grupo_sanguineo' => 'required',
        ]);

        if ($request->grupo_sanguineo == 'otros') {

                $request->merge([
                    'grupo_sanguineo' => $request->otro_grupo_sanguineo
                ]);

            }

            Paciente::create($request->all());

        

        return redirect()
            ->route($this->getRouteBase().'.pacientes.index')
            ->with('mensaje', 'Paciente registrado correctamente')
            ->with('icono', 'success');
    }

    
    public function show($id)
{
    $paciente = Paciente::with('consultas.signosVitales')->findOrFail($id);

    return view(
        'admin.pacientes.show',
        compact('paciente')
    );
}

    
    public function edit($id)
    {
            if(auth()->user()->hasRole('medico')){
        abort(403, 'No autorizado');
        }

        $paciente = Paciente::with('consultas.signosVitales')->findOrFail($id);
        $medicos = User::role('medico')->get();
        return view(
            'admin.pacientes.edit',
            compact('paciente','medicos')
        );
    }

   
    public function update(Request $request, $id)
    {
        if(auth()->user()->hasRole('medico')){
            abort(403, 'No autorizado');
        }
        $paciente = Paciente::findOrFail($id);

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'DNI' => 'required|max:20',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required',
            'celular' => 'required',
            'email' => 'required|email|unique:pacientes,email,' . $paciente->id,
            'direccion' => 'required',
            'grupo_sanguineo' => 'required',
        ]);
            $datos = $request->all();

                if ($request->grupo_sanguineo == 'otros') {

                    $datos['grupo_sanguineo'] = $request->otro_grupo_sanguineo;

                }

                $paciente->update($datos);


        return redirect()
            ->route($this->getRouteBase().'.pacientes.index')
            ->with('mensaje', 'Paciente actualizado correctamente')
            ->with('icono', 'success');
    }

    
        public function reportePdf(Request $request)
        {
            $buscar = $request->buscar;
            $fecha_inicio = $request->fecha_inicio;
            $fecha_fin = $request->fecha_fin;

            $pacientes = Paciente::with('consultas.medico');

            if ($fecha_inicio && $fecha_fin) {
                $pacientes->whereBetween('created_at', [
                    $fecha_inicio . ' 00:00:00',
                    $fecha_fin . ' 23:59:59'
                ]);
            }

            if (auth()->user()->hasRole('medico')) {
                $pacientes->whereHas('consultas', function ($q) {
                    $q->where('medico_id', auth()->id());
                });
            }

            $pacientes = $pacientes
                ->when($buscar, function ($query, $buscar) {
                    $query->where(function ($q) use ($buscar) {
                        $q->whereRaw('LOWER(nombres) LIKE ?', [
                            '%' . strtolower($buscar) . '%'
                        ])
                        ->orWhereRaw('LOWER(apellidos) LIKE ?', [
                            '%' . strtolower($buscar) . '%'
                        ])
                        ->orWhereRaw('LOWER(DNI) LIKE ?', [
                            '%' . strtolower($buscar) . '%'
                        ]);
                    });
                })
                ->get();

            // Obtener la configuración actual del establecimiento
            $configuracion = Configuracion::first();

            // Generar el PDF con los pacientes y la configuración
            $pdf = Pdf::loadView(
                'admin.pacientes.reporte',
                compact('pacientes', 'configuracion')
            )->setPaper('a4', 'portrait');

            return $pdf->stream('reporte-pacientes.pdf');
        }




    
public function delete($id)
{
    if (auth()->user()->hasRole('medico')) {
        abort(403, 'No autorizado');
    }

    $paciente = Paciente::findOrFail($id);

    // Verificar si el paciente tiene consultas registradas
    if ($paciente->consultas()->exists()) {
        return redirect()
            ->route($this->getRouteBase().'.pacientes.index')
            ->with('mensaje',
                'No se puede eliminar al paciente porque tiene historias clínicas registradas.')
            ->with('icono', 'warning');
    }

    $base = $this->getRouteBase();

    return view(
        'admin.pacientes.delete',
        compact('paciente', 'base')
    );
}

   
public function destroy($id)
{
    if (auth()->user()->hasRole('medico')) {
        abort(403, 'No autorizado');
    }

    $paciente = Paciente::findOrFail($id);

    // Proteger pacientes que tienen consultas médicas
    if ($paciente->consultas()->exists()) {
        return redirect()
            ->route($this->getRouteBase().'.pacientes.index')
            ->with('mensaje',
                'No se puede eliminar al paciente porque tiene historias clínicas registradas.')
            ->with('icono', 'warning');
    }

    $paciente->delete();

    return redirect()
        ->route($this->getRouteBase().'.pacientes.index')
        ->with('mensaje', 'Paciente eliminado correctamente')
        ->with('icono', 'success');
}



    public function historiaPdf($id)
    {
        $paciente = Paciente::with([
            'consultas.medico',
            'consultas.signosVitales'
        ])->findOrFail($id);

        $consultas = $paciente->consultas->sortByDesc('fecha_atencion');

        $pdf = Pdf::loadView('admin.pacientes.historia_pdf', compact('paciente','consultas'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('historia-'.$paciente->DNI.'.pdf');
    }



    private function getRouteBase()
    {
        if (auth()->user()->hasRole('admin')) return 'admin';
        if (auth()->user()->hasRole('asistente')) return 'asistente';
        if (auth()->user()->hasRole('medico')) return 'medico';

        return '';
    }



    
}
