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

            <!-- HEADER -->
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

            <!-- BODY -->
            <div class="card-body">

                @php
                    $contador = ($usuarios->currentPage() - 1) * $usuarios->perPage() + 1;
                @endphp

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Nombres</b></td>
                            <td class="text-center"><b>Apellidos</b></td>
                            <td class="text-center"><b>Correo</b></td>
                            <td class="text-center"><b>Estado</b></td>
                            <td class="text-center"><b>Roles</b></td>


                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($usuarios as $usuario)
                        <tr>
                            <td class="text-center">{{ $contador++ }}</td>
                            <td class="text-center">{{ $usuario->name }}</td>
                            <td class="text-center">{{ $usuario->surname }}</td>
                            <td class="text-center">{{ $usuario->email }}</td>
                            <td class="text-center">{{ $usuario->status }}</td>
                            <td class="text-center">

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
                                        {{ ucfirst($rol) }}

                                @endswitch

                            </td>
                            

                            <td style="text-align:center">
                                <div class="btn-group" role="group">
                             @can('admin.usuarios.edit')
                                    {{-- VER PACIENTE --}}
                                <a href="{{ url($base.'/usuarios/'.$usuario->id) }}"
                               class="btn"  title="Ver usuario" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            @endcan

  
                            @can('admin.usuarios.edit')
                                <a href="{{ url($base.'/usuarios/'.$usuario->id.'/edit') }}" 
                                class="btn"
                                style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endcan
                            
                            @can('admin.usuarios.destroy')

                                <a href="{{ url($base.'/usuarios/'.$usuario->id.'/confirm-delete') }}" 
                                class="btn"
                                style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            @endcan

                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No hay usuarios registrados</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- PAGINACIÓN -->
                                        <div class="d-flex justify-content-end mt-2 ">
                                            {{ $usuarios->links() }}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

@endsection