<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 LIMPIAR CACHE
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ✅ ROLES
        $adminRole = Role::create(['name' => 'admin']);
        $asistenteRole = Role::create(['name' => 'asistente']);
        $medicoRole = Role::create(['name' => 'medico']);

        // ✅ USUARIOS
        $admin = User::create([
            'name' => 'Yahaira',
            'surname' => 'Tipian Mesias',
            'username' => 'YAHAIRA.TIPIAN',
            'email' => 'yahairatipian23@gmail.com',
            'phone' => '999999999',
            'status' => 'activo',
            'password' => Hash::make('12345678'),
        ]);

        $admin->assignRole('admin');

       

        // PERMISOS DEFINIDOS EN EL SISTEMA
        $permisos = [

            //  USUARIOS (solo admin)
            'usuarios' => [
                'index' => ['admin'],
                'create' => ['admin'],
                'store' => ['admin'],
                'show' => ['admin'],
                'edit' => ['admin'],
                'update' => ['admin'],
                'confirm-delete' => ['admin'],
                'destroy' => ['admin'],
            ],

            //  PACIENTES
            'pacientes' => [
                'index' => ['admin','asistente','medico'],
                'create' => ['admin','asistente'],
                'store' => ['admin','asistente'],
                'show' => ['admin','asistente','medico'],
                'edit' => ['admin','asistente','medico'],
                'update' => ['admin','asistente','medico'],
                'confirm-delete' => ['admin'],
                'destroy' => ['admin'],
            ],

            //  HORARIOS
           // HORARIOS
                'horarios' => [

                    // Ver horarios
                    'index' => [
                        'admin',
                        'asistente',
                        'medico'
                    ],


                    // Registrar horario
                    // Solo admin y asistente organizan horarios
                    'create' => [
                        'admin',
                        'asistente'
                    ],

                    'store' => [
                        'admin',
                        'asistente'
                    ],



                    // Ver detalle horario
                    'show' => [
                        'admin',
                        'asistente',
                        'medico'
                    ],



                    // Editar horario
                    'edit' => [
                        'admin',
                        'asistente'
                    ],

                    'update' => [
                        'admin',
                        'asistente'
                    ],



                    // Eliminar horario
                    'confirm-delete' => [
                        'admin',
                        'asistente'
                    ],

                    'destroy' => [
                        'admin',
                        'asistente'
                    ],

                ],

            // CITAS
            'citas' => [
                'index' => ['admin','asistente','medico'],
                'create' => ['admin','asistente'],
                'store' => ['admin','asistente'],
                'show' => ['admin','asistente','medico'],
                'edit' => ['admin','asistente'],
                'update' => ['admin','asistente'],
                'confirm-delete' => ['admin','asistente'],
                'destroy' => ['admin','asistente'],
            ],

            ///CONFIGURACION

            'configuraciones' => [
                'index' => ['admin'],
                'create' => ['admin'],
                'store' => ['admin'],
                'show' => ['admin'],
                'edit' => ['admin'],
                'update' => ['admin'],
                'confirm-delete' => ['admin'],
                'destroy' => ['admin'],
            ],
        ];

        // 🔥 CREAR PERMISOS
        foreach ($permisos as $modulo => $acciones) {
            foreach ($acciones as $accion => $roles) {

                $permiso = Permission::create([
                    'name' => "admin.$modulo.$accion"
                ]);

                foreach ($roles as $roleName) {
    $role = Role::findByName($roleName);
    $role->givePermissionTo($permiso);
}
            }
        }

        Permission::create(['name' => 'admin.dashboard'])
        ->syncRoles(['admin','asistente','medico']);

    }
}