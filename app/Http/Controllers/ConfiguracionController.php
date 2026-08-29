<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
   
    public function index(){
   
        $configuracion = Configuracion::first();

      
        if (!$configuracion) {

            $configuracion = Configuracion::create([
                'nombre_puestosalud' => 'PUESTO DE SALUD CRUZ BLANCA',
                'direccion' => ' Avenida Av. Alva Maurtua Mz. 1 Lt. 6 Chincha Alta - Chincha - Ica',
                'telefono' => '  956562272',
                'facebook' => 'Puesto SALUD CRUZ Blanca',
                'logo' => 'image/PSCB.png'
            ]);
        }

        
        return redirect()->route(
            $this->getRouteBase().'.configuraciones.edit',
            $configuracion->id
        );

        
    }
   
    public function create()
    {
        return view('admin.configuraciones.create');
    }

   
  public function store(Request $request)
    {
        $request->validate([
            'nombre_puestosalud' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'facebook' => 'required',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $configuracion = new Configuracion();
        $configuracion->nombre_puestosalud = $request->nombre_puestosalud;
        $configuracion->direccion = $request->direccion;
        $configuracion->telefono = $request->telefono;
        $configuracion->facebook = $request->facebook;

    
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

        
            $nombre = time().'_'.$file->getClientOriginalName();

            
            $ruta = $file->storeAs('configuraciones', $nombre, 'public');

            $configuracion->logo = $ruta;
        }

        $configuracion->save();

        return redirect()->route(
            $this->getRouteBase().'.configuraciones.edit',
            $configuracion->id
        )
            ->with('mensaje', 'Configuración registrada correctamente')
            ->with('icono', 'success');
    }

   
    public function show($id)
    {
        $configuracion = Configuracion::findOrFail($id);

        return view('admin.configuraciones.show', compact('configuracion'));
    }

   
    public function edit($id)
    {
        $configuracion = Configuracion::findOrFail($id);

        return view('admin.configuraciones.edit', compact('configuracion'));
    }


   public function update(Request $request, $id)
    {
        $configuracion = Configuracion::findOrFail($id);

        $request->validate([
            'nombre_puestosalud' => 'required|string|filled',
            'direccion' => 'required|string|filled',
            'telefono' => 'required|string|filled',
            'facebook' => 'required|string|filled',
        ]);

        $configuracion->nombre_puestosalud = trim($request->nombre_puestosalud);
        $configuracion->direccion = trim($request->direccion);
        $configuracion->telefono = trim($request->telefono);
        $configuracion->facebook = trim($request->facebook);

        if ($request->hasFile('logo')) {

            // eliminar anterior si existe
            if ($configuracion->logo && file_exists(storage_path('app/public/' . $configuracion->logo))) {
                unlink(storage_path('app/public/' . $configuracion->logo));
            }

            $file = $request->file('logo');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $ruta = $file->storeAs('configuraciones', $nombre, 'public');

            $configuracion->logo = $ruta;
        }

            $configuracion->save();

                return redirect()->route(
                $this->getRouteBase().'.configuraciones.edit',
                $configuracion->id
            )
            ->with('mensaje', 'Configuración actualizada correctamente')
            ->with('icono', 'success');
    }

   
    public function confirmDelete($id){
        $configuracion = Configuracion::findOrFail($id);

        return view('admin.configuraciones.delete', compact('configuracion'));
    }

    public function destroy($id)
    {
        $configuracion = Configuracion::findOrFail($id);

        // eliminar imagen correctamente
        if ($configuracion->logo) {
            Storage::disk('public')->delete($configuracion->logo);
        }

        $configuracion->delete();

        return redirect()->route($this->getRouteBase().'.configuraciones.index')
            ->with('mensaje', 'Configuración eliminada correctamente')
            ->with('icono', 'success');
    }

    private function getRouteBase(){
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return 'admin';
        }

        if ($user->hasRole('asistente')) {
            return 'asistente';
        }

        if ($user->hasRole('medico')) {
            return 'medico';
        }

        return 'admin';
    }
   
}
