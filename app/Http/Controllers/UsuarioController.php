<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
class UsuarioController extends Controller
{
    public function index(){
         $usuarios = User::paginate(10);

        return view('admin.usuarios.index',compact('usuarios'));
    }

    public function create(){
      
        return view('admin.usuarios.create');
    }

    

    public function store(Request $request){

        $request->validate([ 
            'username'=>'required|unique:users,username',
            'name'=>'required|max:250',
            'surname'=>'required|max:250',
            'email'=>'required|max:250|unique:users',
            'phone'=>'required|max:9',
            'password'=>'required|max:250|confirmed',
            'status'=>'required',  
            'role'=>'required',   
            'specialty'=>'required_if:role,medico',
            'titulo_profesional'=>'nullable|string|max:50',
            'colegio_profesional' => 'nullable|string|max:100',

        ]);

        $usuario = new User();
        $usuario->username = $request->username;
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->password = Hash::make($request['password']); 
        $usuario->status = $request->status;
        $usuario->specialty = $request->specialty ?? null; 

          if ($request->titulo_profesional == 'otros') {
            $usuario->titulo_profesional = $request->otro_titulo;
        } else {
            $usuario->titulo_profesional = $request->titulo_profesional;
        }
        $usuario->colegio_profesional = $request->colegio_profesional;
    
        $usuario->save();
        $usuario->assignRole($request->role);

        return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Usuario creado correctamente')
        ->with('icono', 'success');


    }

    public function show($id){
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.show',compact('usuario'));

    }

    

    public function edit($id){
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit',compact('usuario'));

    }

    public function update(Request $request, $id){

         $request->validate([

            'username'=>['required',Rule::unique('users','username')->ignore($id)],

            'name'=>'required|max:250',
            'surname'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email,'.$id,
            'phone'=>'required|max:9',
            'password'=>'nullable|max:250|confirmed',
            'status'=>'required',
            'role'=>'required',
            'specialty'=>'required_if:role,medico',
            'titulo_profesional'=>'nullable|string|max:50',
            'colegio_profesional' => 'nullable|string|max:100',

        ]);

        $usuario = User::find($id);
         $usuario->username = $request->username;
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;

        if($request->filled('password')){
                $usuario->password = Hash::make($request['password']);
            }
        
        $usuario->status = $request->status;
        $usuario->specialty = $request->specialty ?? null; 

            if ($request->titulo_profesional == 'otros') {
                $usuario->titulo_profesional = $request->otro_titulo;
            } else {
                $usuario->titulo_profesional = $request->titulo_profesional;
            }
            $usuario->colegio_profesional = $request->colegio_profesional;
            
        $usuario->save();
        $usuario->syncRoles([$request->role]);

        return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Usuario actualizado correctamente.')
        ->with('icono', 'success');


    }

    public function confirmDelete($id){
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.delete', compact('usuario'));
    }

    public function destroy($id){
        User::destroy($id);

         return redirect()->route($this->getRouteBase().'.usuarios.index')
        ->with('mensaje', 'Usuario eliminado correctamente.')
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
