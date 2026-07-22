<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // ← Esto es importante
use Spatie\Permission\Models\Role;
class UsuarioController extends Controller
{
    public function index(){
         $usuarios = User::paginate(10);

        return view('admin.usuarios.index',compact('usuarios'));
    }

    public function create(){
        //retornar la vista
        return view('admin.usuarios.create');
    }

    //almacenar los datos que registramos

    public function store(Request $request){
        
        //$datos = $request->all();
        //return response()->json($datos);

        

        $request->validate([ //permite que cada campo llenado no sea modificado y este protegido ya que se requiere asi.
            'name'=>'required|max:250',
            'surname'=>'required|max:250',//apellidos
            'email'=>'required|max:250|unique:users',//correo electronico
            'phone'=>'required|max:9',//celular
            'password'=>'required|max:250|confirmed',//contraseña y en confirmed ,estoy diciendo que necesita ser confirmada.
            'status'=>'required',   // Estado
            'role'=>'required',     // Rol
            'specialty'=>'required_if:role,medico', // Especialidad solo si rol = medico
            'titulo_profesional'=>'nullable|string|max:50',

        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->password = Hash::make($request['password']); // encriptar contraseña
        $usuario->status = $request->status;
        $usuario->specialty = $request->specialty ?? null; // si no es médico, queda null

          if ($request->titulo_profesional == 'otros') {
            $usuario->titulo_profesional = $request->otro_titulo;
        } else {
            $usuario->titulo_profesional = $request->titulo_profesional;
        }
        // Guardar en la base de datos
        $usuario->save();
    // 🔥 ASIGNAR ROL CORRECTAMENTE
        $usuario->assignRole($request->role);

        


        

        
        return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Usuario creado correctamente')
        ->with('icono', 'success');


    }

    public function show($id){
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.show',compact('usuario'));

    }

    //funciones que nos ayudaran a editar(edit) y a modificar(uptade) nuestros datos en el sistema

    public function edit($id){
        $usuario = User::findOrFail($id);
       
        return view('admin.usuarios.edit',compact('usuario'));

    }

    public function update(Request $request, $id){

         $request->validate([ //permite que cada campo llenado no sea modificado y este protegido ya que se requiere asi.
            'name'=>'required|max:250',
            'surname'=>'required|max:250',//apellidos
            'email'=>'required|max:250|unique:users,email,'.$id,//correo electronico
            'phone'=>'required|max:9',//celular
            'password'=>'nullable|max:250|confirmed',//contraseña y en confirmed ,estoy diciendo que necesita ser confirmada.
            'status'=>'required',   // Estado
            'role'=>'required',     // Rol
            'specialty'=>'required_if:role,medico', // Especialidad solo si rol = medico
            'titulo_profesional'=>'nullable|string|max:50',

        ]);

        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;

        if($request->filled('password')){
                $usuario->password = Hash::make($request['password']);
            }
        



        $usuario->status = $request->status;
       
        $usuario->specialty = $request->specialty ?? null; // si no es médico, queda null

        if ($request->titulo_profesional == 'otros') {
            $usuario->titulo_profesional = $request->otro_titulo;
        } else {
            $usuario->titulo_profesional = $request->titulo_profesional;
        }

        // Guardar en la base de datos modificada
        $usuario->save();
        // 🔥 ACTUALIZAR ROL
        $usuario->syncRoles([$request->role]);

        return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Datos del usuario actualizados correctamente.')
        ->with('icono', 'success');


    }

    public function confirmDelete($id){
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.delete', compact('usuario'));
    }

    public function destroy($id){
        User::destroy($id);

         return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Datos del usuario eliminados correctamente.')
        ->with('icono', 'success');

    }

        public function __construct()
    {
        $this->middleware('permission:admin.usuarios.index')->only('index');
        $this->middleware('permission:admin.usuarios.create')->only('create','store');
        $this->middleware('permission:admin.usuarios.edit')->only('edit','update');
        $this->middleware('permission:admin.usuarios.destroy')->only('destroy');
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
