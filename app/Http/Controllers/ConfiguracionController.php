<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buscar la única configuración
        $configuracion = Configuracion::first();

        // si no existe la crea automáticamente
        if (!$configuracion) {

            $configuracion = Configuracion::create([
                'nombre_puestosalud' => 'PUESTO DE SALUD CRUZ BLANCA',
                'direccion' => 'C. Alva Maurtua 245',
                'telefono' => ' 970 883 057',
                'facebook' => 'Puesto SALUD CRUZ Blanca',
                'logo' => 'image/PSCB.png'
            ]);
        }

        // redirecciona directo a editar
        return redirect()->route(
            $this->getRouteBase().'.configuraciones.edit',
            $configuracion->id
        );

        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.configuraciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    // 🔥 GUARDAR IMAGEN
    if ($request->hasFile('logo')) {

        $file = $request->file('logo');

        // nombre único
        $nombre = time().'_'.$file->getClientOriginalName();

        // guardar en storage/app/public/configuraciones
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $configuracion = Configuracion::findOrFail($id);

        return view('admin.configuraciones.show', compact('configuracion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $configuracion = Configuracion::findOrFail($id);

        return view('admin.configuraciones.edit', compact('configuracion'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    // 🔥 SI HAY NUEVA IMAGEN
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

    /**
     * Remove the specified resource from storage.
     */
    public function confirmDelete($id)
{
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

 private function getRouteBase()
    {
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
