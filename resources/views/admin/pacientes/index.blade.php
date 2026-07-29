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
            Pacientes
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
                    Pacientes registrados en el sistema
                    <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                </h3>


                @php
                    $user = auth()->user();

                    $ruta = $user->hasRole('admin') 
                        ? 'admin' 
                        : ($user->hasRole('asistente') 
                            ? 'asistente' 
                            : 'medico');
                @endphp


                @if($user->hasRole('admin') || $user->hasRole('asistente'))


              
                            <div class="card-tools">
                            
                                <a href="{{ url($ruta.'/pacientes/create') }}" class="btn btn-primary"
                                    style="background-color: #f4d279; width: 150px;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568;">
                                    <b>Nuevo Paciente</b>
                                </a>
                            </div>
                @endif
                   
            </div>

            <!-- BODY -->
            <div class="card-body">
                @php
                    $base = $ruta;
                @endphp

                @php
                    $contador = ($pacientes->currentPage() - 1) * $pacientes->perPage() + 1;
                @endphp
                <form method="GET" action="{{ url($base.'/pacientes') }}">

    <div style="
        display:flex;
        justify-content:center;
        gap:10px;
        align-items:center;
        flex-wrap:wrap;
    ">

        


        <!-- Fecha desde -->
        <div style="display:flex; align-items:center; gap:5px;">
            <label style="margin:0; color:#4a5568; font-size:14px;">
                Desde:
            </label>

            <input 
                type="date"
                name="fecha_inicio"
                value="{{ request('fecha_inicio') }}"
                class="form-control"
                style="
                    border:1px solid #f4d279;
                    width:160px;
                "
            >
        </div>


        <!-- Fecha hasta -->
        <div style="display:flex; align-items:center; gap:5px;">
            <label style="margin:0; color:#4a5568; font-size:14px;">
                Hasta:
            </label>

            <input 
                type="date"
                name="fecha_fin"
                value="{{ request('fecha_fin') }}"
                class="form-control"
                style="
                    border:1px solid #f4d279;
                    width:160px;
                "
            >
        </div>

        <!-- Buscar nombre -->
        <input 
            type="text" 
            name="buscar" 
            value="{{ $buscar ?? '' }}"
            class="form-control"
            placeholder="Buscar por Nombre , Apellido o DNI"
            style="
                border:1px solid #f4d279;
                width:300px;
            "
        >


        <!-- Buscar -->
        <button type="submit" 
            class="btn"
            style="
                background-color:#f4d279;
                color:#4a5568;
            ">
            <i class="bi bi-search"></i> Buscar
        </button>


        <!-- Limpiar -->
        <a href="{{ url($base.'/pacientes') }}" 
            class="btn btn-secondary">
            Limpiar
        </a>


        <!-- Reporte -->
        <a href="{{ route($ruta.'.pacientes.reportePdf', [
            'buscar' => request('buscar'),
            'fecha_inicio'=>request('fecha_inicio'),
            'fecha_fin'=>request('fecha_fin')
            ]) }}" 
            target="_blank" 
            class="btn"
            style="background-color:#4a5568;color:white;">
                <i class="bi bi-file-earmark-pdf"></i> Reporte
        </a>

    </div>

</form>
<br>

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Paciente</b></td>
                            <td class="text-center"><b>DNI</b></td>
                            <td class="text-center"><b>Genero</b></td>
                            <td class="text-center"><b>Celular</b></td>
                            <td class="text-center"><b>Fecha</b></td>
                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse ($pacientes as $paciente)

                    <tr>

                        <td class="text-center">
                            {{ $contador++ }}
                        </td>

                        <td class="text-center">
                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                        </td>

                        <td class="text-center">
                            {{ $paciente->DNI }}
                        </td>

                        <td class="text-center">
                            {{ ucfirst($paciente->genero) }}
                        </td>

                        <td class="text-center">
                            {{ $paciente->celular }}
                        </td>

                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($paciente->created_at)->format('d/m/Y') }}
                        </td>

                        <td class="text-center">

                            <div class="btn-group">

                                {{-- VER PACIENTE --}}
                                <a href="{{ url($base.'/pacientes/'.$paciente->id) }}"
                               class="btn"  title="Ver Paciente" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                               
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('asistente'))
                                    {{-- EDITAR --}}
                                    <a href="{{ url($base.'/pacientes/'.$paciente->id.'/edit') }}"
                                    class="btn"  title="Editar Paciente" style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                    onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                    onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                

                                    {{-- ELIMINAR --}}
                                    <a href="{{ route($base.'.pacientes.delete', $paciente->id) }}"
                                    class="btn"
                                    title="Eliminar Paciente"
                                    style="background-color: #f4d279; color: #4a5568; border: none; transition:0.3s;"
                                    onmouseover="this.style.backgroundColor='#ffe8a3'; this.style.boxShadow='0 0 8px rgba(244,210,121,0.7)'"
                                    onmouseout="this.style.backgroundColor='#f4d279'; this.style.boxShadow='none'">

                                        <i class="bi bi-trash-fill"></i>

                                    </a>
                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            No hay pacientes registrados
                        </td>
                    </tr>

                    @endforelse

</tbody>
                </table>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-end mt-2 ">
                    {{ $pacientes->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection