<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:admin.usuarios.index')
            ->only('index');

        $this->middleware('permission:admin.usuarios.create')
            ->only(['create', 'store']);

        $this->middleware('permission:admin.usuarios.edit')
            ->only(['edit', 'update']);

        $this->middleware('permission:admin.usuarios.destroy')
            ->only(['destroy']);
    }

    /**
     * Determinar el prefijo según el rol.
     */
    private function getRouteBase(): string
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

    /**
     * Listar usuarios.
     */
    public function index()
    {
        $usuarios = User::paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Formulario para crear usuario.
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Guardar usuario.
     */
    public function store(Request $request)
    {
        $request->validate([

            'username' => [
                'required',
                'string',
                'max:250',
                'unique:users,username',
            ],

            'name' => [
                'required',
                'string',
                'max:250',
            ],

            'surname' => [
                'required',
                'string',
                'max:250',
            ],

            'email' => [
                'required',
                'email',
                'max:250',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'digits:9',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:250',
                'confirmed',
            ],

            'status' => [
                'required',
                Rule::in(['activo', 'inactivo']),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'asistente',
                    'medico'
                ]),
            ],

            'specialty' => [
                'nullable',
                'required_if:role,medico',
                Rule::in([
                    'Medicina general',
                    'Obstetricia',
                ]),
            ],

            'titulo_profesional' => [
                'nullable',
                'string',
                'max:50',
            ],

            'otro_titulo' => [
                'nullable',
                'string',
                'max:100',
            ],

            'colegio_profesional' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $usuario = new User();

        $usuario->username = $request->username;
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->password = Hash::make($request->password);
        $usuario->status = $request->status;

        /*
         * Especialidad solamente para médicos.
         */
        if ($request->role === 'medico') {
            $usuario->specialty = $request->specialty;
        } else {
            $usuario->specialty = null;
        }

        /*
         * Título profesional.
         */
        if ($request->titulo_profesional === 'otros') {
            $usuario->titulo_profesional = $request->otro_titulo;
        } else {
            $usuario->titulo_profesional = $request->titulo_profesional;
        }

        $usuario->colegio_profesional = $request->colegio_profesional;

        $usuario->save();

        /*
         * Asignar rol mediante Spatie.
         */
        $usuario->assignRole($request->role);

        return redirect()
            ->route($this->getRouteBase() . '.usuarios.index')
            ->with('mensaje', 'Usuario creado correctamente.')
            ->with('icono', 'success');
    }

    /**
     * Mostrar usuario.
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return view(
            'admin.usuarios.show',
            compact('usuario')
        );
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view(
            'admin.usuarios.edit',
            compact('usuario')
        );
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([

            'username' => [
                'required',
                'string',
                'max:250',
                Rule::unique('users', 'username')
                    ->ignore($usuario->id),
            ],

            'name' => [
                'required',
                'string',
                'max:250',
            ],

            'surname' => [
                'required',
                'string',
                'max:250',
            ],

            'email' => [
                'required',
                'email',
                'max:250',
                Rule::unique('users', 'email')
                    ->ignore($usuario->id),
            ],

            'phone' => [
                'required',
                'digits:9',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:250',
                'confirmed',
            ],

            'status' => [
                'required',
                Rule::in([
                    'activo',
                    'inactivo'
                ]),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'asistente',
                    'medico'
                ]),
            ],

            'specialty' => [
                'nullable',
                'required_if:role,medico',
                Rule::in([
                    'Medicina general',
                    'Obstetricia',
                ]),
            ],

            'titulo_profesional' => [
                'nullable',
                'string',
                'max:50',
            ],

            'otro_titulo' => [
                'nullable',
                'string',
                'max:100',
            ],

            'colegio_profesional' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $usuario->username = $request->username;
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->status = $request->status;

        /*
         * Cambiar contraseña solamente si se escribió.
         */
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        /*
         * Especialidad solamente para médicos.
         */
        if ($request->role === 'medico') {
            $usuario->specialty = $request->specialty;
        } else {
            $usuario->specialty = null;
        }

        /*
         * Título profesional.
         */
        if ($request->titulo_profesional === 'otros') {
            $usuario->titulo_profesional = $request->otro_titulo;
        } else {
            $usuario->titulo_profesional = $request->titulo_profesional;
        }

        $usuario->colegio_profesional = $request->colegio_profesional;

        $usuario->save();

        /*
         * Actualizar rol.
         */
        $usuario->syncRoles([
            $request->role
        ]);

        return redirect()
            ->route($this->getRouteBase() . '.usuarios.index')
            ->with('mensaje', 'Usuario actualizado correctamente.')
            ->with('icono', 'success');
    }

    /**
     * Confirmar eliminación.
     */
    public function confirmDelete($id)
    {
        $usuario = User::findOrFail($id);

        return view(
            'admin.usuarios.delete',
            compact('usuario')
        );
    }

    /**
     * Eliminar usuario.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->delete();

        return redirect()
            ->route($this->getRouteBase() . '.usuarios.index')
            ->with('mensaje', 'Usuario eliminado correctamente.')
            ->with('icono', 'success');
    }
}