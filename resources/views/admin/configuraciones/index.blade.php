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
    table td {
    vertical-align: middle !important;
    text-align: center;
}
</style>
</head>

<div class="row" style="margin-bottom:15px;">
    <div style="display:flex; align-items:center; gap:10px;">
        
        <i class="nav-icon bi bi-person-fill-gear" style="font-size:28px; color:#5f6b7a;"></i>

         

            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
                Configuración
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
                    Configuracion del sistema
                    <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                </h3>
                @can('admin.configuraciones.create')
                 <div  class="card-tools">
                    <a href="{{url($base.'/configuraciones/create')}}" class="btn btn-primary"  style="background-color: #f4d279; width: 200;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568;" >
                        <b>Nueva Configuracion</b>
                    </a>
                </div>
                @endcan
               
            </div>

            <!-- BODY -->
            <div class="card-body">

                @php
                    $contador = ($configuraciones->currentPage() - 1) * $configuraciones->perPage() + 1;
                @endphp

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Nombre del Hospital</b></td>
                            <td class="text-center"><b>Dirección</b></td>
                            <td class="text-center"><b>Telefono</b></td>
                            <td class="text-center"><b>Red Social</b></td>
                            <td class="text-center"><b>Logo</b></td>
                            


                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($configuraciones as $configuracion)
                        <tr>
                            <td class="text-center">{{ $contador++ }}</td>

                            <td class="text-center">
                                {{ $configuracion->nombre_puestosalud ?? '---' }} 
                               
                            </td>
                           
                            <td class="text-center">
                                {{ $configuracion->direccion ?? '---' }} 
                             
                            </td>

                        
                            <td class="text-center">
                                {{ $configuracion->telefono ?? '---' }} 
                            </td>

                            <!-- Hora -->
                            <td class="text-center">
                                {{ $configuracion->facebook ?? '---' }} 
                            </td>

                             <td class="text-center">
                                <img src="{{ asset('storage/'.$configuracion->logo) }}" style="width:80px; height:80px; object-fit:contain; border-radius:6px;">
                            </td>
                           

                            <td style="text-align:center">
                                <div class="btn-group" role="group">  
                                    
                                @can('admin.configuraciones.show')

                                   
                                    <a href="{{ url($base.'/configuraciones/'.$configuracion->id) }}" class="btn"style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    
                                @endcan

                                @can('admin.configuraciones.edit')

                                    <a href="{{ url($base.'/configuraciones/'.$configuracion->id.'/edit') }}" class="btn"style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcan

                                @can('admin.configuraciones.destroy')

                                    <a href="{{ url($base.'/configuraciones/'.$configuracion->id.'/confirm-delete') }}" class="btn"style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
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
                            <td colspan="12" class="text-center">No hay configuraciones registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-end mt-2 ">
                    {{ $configuraciones->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection