@extends('layouts.Admin')

@section('content')

<head>
    <style>

        .estado-wrapper {
    display: flex;
    justify-content: center;
}

/* SELECT estilo badge */
.estado-select {
    width: auto;
    min-width: 110px;
    height: 32px;

    border-radius: 5px;
    border: none;

    font-size: 13px;
    font-weight: 500;
    text-align: center;

    cursor: pointer;

    /* 🔥 quitar flecha */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    text-align-last: center;
}

/* COLORES BONITOS (no chillones) */
.estado-pendiente {
    background-color: #fff3cd;
    color: #856404;
}

.estado-atendida {
    background-color: #d4edda;
    color: #155724;
}

.estado-cancelada {
    background-color: #f8d7da;
    color: #721c24;
}

/* hover suave */
.estado-select:hover {
    opacity: 0.85;
}
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
        
        <i class="nav-icon bi bi-people-fill" style="font-size:28px; color:#5f6b7a;"></i>

         

            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
                Citas Medicas
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
                    Citas registradas en el sistema
                    <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                </h3>
                @can('admin.citas.create')
                 <div  class="card-tools">
                    <a href="{{url($base.'/citas/create')}}" class="btn btn-primary"  style="background-color: #f4d279; width: 150px;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568";" >
                        <b>Nueva Cita</b>
                    </a>
                </div>
                @endcan
               
            </div>

            <!-- BODY -->
            <div class="card-body">

                @php
                    $contador = ($citas->currentPage() - 1) * $citas->perPage() + 1;
                @endphp

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Paciente</b></td>
                            <td class="text-center"><b>Medico</b></td>
                            <td class="text-center"><b>Fecha de Cita</b></td>
                            <td class="text-center"><b>Hora</b></td>
                            <td class="text-center"><b>Estado</b></td>
                            


                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($citas as $cita)
                        <tr>
                            <td class="text-center">{{ $contador++ }}</td>

                            <!-- Paciente -->
                            <td class="text-center">
                                {{ $cita->paciente->nombres ?? '---' }} 
                                {{ $cita->paciente->apellidos ?? '' }}
                            </td>
                             <!-- Médico -->
                            <td class="text-center">
                                {{$cita->medico->titulo_profesional ?? ''}} 
                                {{ $cita->medico->name ?? '---' }} 
                                {{ $cita->medico->surname ?? '' }}
                            </td>

                            <!-- Fecha -->
                            <td class="text-center">
                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            </td>

                            <!-- Hora -->
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($cita->hora)->format('g:i a') }}
                            </td>

                            <!-- Estado -->
                            <td class="text-center">
                                <form action="{{  route('citas.estado', $cita->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="estado-wrapper">
                                    <select name="estado" 
                                        onchange="this.form.submit()"
                                        {{ auth()->user()->hasRole('asistente') ? 'disabled' : '' }} 
                                    class="estado-select
                                    {{ $cita->estado == 'pendiente' ? 'estado-pendiente' : '' }}
                                    {{ $cita->estado == 'atendida' ? 'estado-atendida' : '' }}
                                    {{ $cita->estado == 'cancelada' ? 'estado-cancelada' : '' }}">

                                        <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="atendida" {{ $cita->estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                                        <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>

                                    </select>
                                </div>
                                                                </form>
                            </td>

                           

                            <td style="text-align:center">
                                <div class="btn-group" role="group">  
                                    
                                @can('admin.citas.show')

                                   
                                    <a href="{{ url($base.'/citas/'.$cita->id) }}" class="btn" title="Ver Citas" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    
                                @endcan

                                @can('admin.citas.edit')

                                    <a href="{{ url($base.'/citas/'.$cita->id.'/edit') }}" class="btn" title="Editar Citas" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcan

                                @can('admin.citas.destroy')

                                    <a href="{{ url($base.'/citas/'.$cita->id.'/confirm-delete') }}" class="btn" title="Eliminar Citas" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
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
                            <td colspan="12" class="text-center">No hay citas medicas registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-end mt-2 ">
                    {{ $citas->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection