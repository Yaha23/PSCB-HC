@extends('layouts.Admin')

@section('content')

    <head>
        <style>
    .pagination .page-link {
        color: #2c3e50 !important;
        font-weight: 500;
        transition: 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #fff8dc !important;
        color: #2c3e50 !important;
        border-color: #f4d279;
    }

    .pagination .active .page-link {
        background-color: #2c3e50 !important;
        border-color: #85a2c5 !important;
        color: white !important;
    }

    /* Tabla contenida dentro de la tarjeta */
    .tabla-usuarios {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0;
    }

    .tabla-usuarios th,
    .tabla-usuarios td {
        text-align: center;
        vertical-align: middle !important;
    }

    /* Columna Acciones */
    .tabla-usuarios th:last-child,
    .tabla-usuarios td:last-child {
        min-width: 125px;
        white-space: nowrap;
    }

    .tabla-usuarios .btn-group {
        display: inline-flex;
        flex-wrap: nowrap;
        justify-content: center;
        vertical-align: middle;
    }

    .tabla-usuarios .btn-group .btn {
        padding: 6px 10px;
    }

    .tabla-usuarios-contenedor {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }
</style>
    </head>

    <div class="row" style="margin-bottom:15px;">
        <div style="display:flex; align-items:center; gap:10px;">
            
            <i class="nav-icon fas bi bi-people" style="font-size:28px; color:#5f6b7a;"></i>

            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
                Usuarios
            </h1>

        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
                <div class="card card-outline" style="border-top: 3px solid #f4d279;">

                    <div class="card-header">
                        <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;"> 
                            Usuarios registrados en el sistema
                            <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                        </h3>

                        <div  class="card-tools">
                            @can('admin.usuarios.create')
                                <a href="{{url($base.'/usuarios/create')}}" class="btn btn-primary"  style="background-color: #f4d279; width: 150px;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568";" >
                                    <b>Nuevo usuario</b>
                                </a>
                            @endcan
                        </div>
                    </div>


                    <div class="card-body">

                        @php
                            $contador = ($usuarios->currentPage() - 1) * $usuarios->perPage() + 1;
                        @endphp

        

                        <!-- BUSCADOR DE USUARIOS -->
                        <form method="GET" action="{{ url($base . '/usuarios') }}">

                            <div style="
                                display:flex;
                                justify-content:center;
                                gap:10px;
                                align-items:center;
                                flex-wrap:wrap;
                            ">

                                <!-- CAMPO DE BÚSQUEDA -->
                                <input
                                    type="text"
                                    name="buscar"
                                    value="{{ $buscar ?? '' }}"
                                    class="form-control"
                                    placeholder="Buscar por Nombre, Apellido o Usuario "
                                    style="
                                        border:1px solid #f4d279;
                                        width:350px;
                                    "
                                >

                                <!-- BOTÓN BUSCAR -->
                                <button
                                    type="submit"
                                    class="btn"
                                    style="
                                        background-color:#f4d279;
                                        color:#4a5568;
                                        border:1px solid #f4d279;
                                        border-radius:6px;
                                    "
                                >
                                    <i class="bi bi-search"></i>
                                    Buscar
                                </button>

                                <!-- BOTÓN LIMPIAR -->
                                <a
                                    href="{{ url($base . '/usuarios') }}"
                                    class="btn btn-secondary"
                                    style="border-radius:6px;"
                                >
                                   
                                    Limpiar
                                </a>

                            </div>

                        </form>

                        <br>

                        
<div class="tabla-usuarios-contenedor">
    <table id="example1"
           class="table table-bordered table-hover table-sm tabla-usuarios">

        <thead style="background-color:#4a5568; color:white">
            <tr>
                <th class="text-center">Nro</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">Usuario</th>
                <th class="text-center">Correo</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Roles</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->surname }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->email }}</td>

                    <td style="text-transform:uppercase;">
                        {{ $usuario->status }}
                    </td>

                    <td>
                        @php
                            $rol = $usuario->getRoleNames()->first();
                        @endphp

                        @switch($rol)
                            @case('admin')
                                Administrador
                                @break

                            @case('medico')
                                Médico
                                @break

                            @case('asistente')
                                Asistente
                                @break

                            @default
                                {{ ucfirst($rol ?? '') }}
                        @endswitch
                    </td>

                    <td>
                        <div class="btn-group" role="group">

                            @can('admin.usuarios.edit')
                                <a href="{{ url($base.'/usuarios/'.$usuario->id) }}"
                                   class="btn"
                                   title="Ver usuario"
                                   style="background-color:#f4d279;color:#4a5568;border:none;">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ url($base.'/usuarios/'.$usuario->id.'/edit') }}"
                                   class="btn"
                                   title="Editar usuario"
                                   style="background-color:#f4d279;color:#4a5568;border:none;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endcan

                            @can('admin.usuarios.destroy')
                                <a href="{{ url($base.'/usuarios/'.$usuario->id.'/confirm-delete') }}"
                                   class="btn"
                                   title="Eliminar usuario"
                                   style="background-color:#f4d279;color:#4a5568;border:none;">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            @endcan

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        No hay usuarios registrados
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>


                                                
                        <div class="d-flex justify-content-end mt-2 ">
                            {{ $usuarios->links() }}
                        </div>

                    </div>

                </div>
        </div>
    </div>
</div>

@endsection