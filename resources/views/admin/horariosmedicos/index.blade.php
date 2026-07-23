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
        
        <i class="nav-icon bi bi-people-fill" style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
            Horarios de Medicos
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
                    Horarios registrados en el sistema
                    <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                </h3>

                @can('admin.horariosmedicos.create')

                     <div  class="card-tools">
                        <a href="{{url($base.'/horariosmedicos/create')}}" class="btn btn-primary"  style="background-color: #f4d279; width: 150px;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568";" >
                            <b>Nuevo Horario</b>
                        </a>
                    </div>


                @endcan

               
            </div>

            <!-- BODY -->
            <div class="card-body">

                @php
                    $contador = ($horariosmedicos->currentPage() - 1) * $horariosmedicos->perPage() + 1;
                @endphp

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Medico</b></td>
                            <td class="text-center"><b>Hora de Inicio</b></td>
                            <td class="text-center"><b>Hora de Salida</b></td>
                            


                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody style="text-align:center;">
                        @forelse ($horariosmedicos as $horariosmedico)
                        <tr>
                            <td class="text-center">{{ $contador++ }}</td>

                            <!-- Médico -->
                           <td class="text-center">
                                {{$horariosmedico->medico->titulo_profesional ?? ''}}
                                {{ $horariosmedico->medico->name ?? '---' }} 
                                {{ $horariosmedico->medico->surname ?? '' }}
                            </td>

                            <!-- Hora inicio -->
                            <td class="text-center">{{ \Carbon\Carbon::parse($horariosmedico->hora_inicio)->format('g:i a') }}</td>

                            <!-- Hora fin -->
                            <td class="text-center">{{ \Carbon\Carbon::parse($horariosmedico->hora_fin)->format('g:i a') }}</td>

                         

                            <td style="text-align:center">
                                <div class="btn-group" role="group"> 
                                    
                                @can('admin.horariosmedicos.show')

                                <a href="{{ url($base.'/horariosmedicos/'.$horariosmedico->id) }}" 
                                    class="btn"
                                    title="Ver Horario"
                                    style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                    onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                    onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-eye-fill"></i>
                                </a>

                                @endcan

                                @can('admin.horariosmedicos.edit')

                                    <a href="{{ url($base.'/horariosmedicos/'.$horariosmedico->id.'/edit') }}" 
                                        class="btn"
                                        title="Editar Horario"
                                        style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                        onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                        onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                            <i class="bi bi-pencil-square"></i>
                                    </a>

                                @endcan

                                @can('admin.horariosmedicos.destroy')

                                    <a href="{{ route($base.'.horariosmedicos.confirmDelete', $horariosmedico->id) }}"
                                    class="btn"
                                    title="Eliminar Horario"
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
                            <td colspan="12" class="text-center">No hay horarios medicos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-end mt-2 ">
                    {{ $horariosmedicos->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection