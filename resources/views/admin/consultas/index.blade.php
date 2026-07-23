@extends('layouts.Admin')

@section('content')

@php
    $user = auth()->user();

    $base = $user->hasRole('admin') ? 'admin' :
            ($user->hasRole('asistente') ? 'asistente' : 'medico');

    $isAdmin = $user->hasRole('admin');
    $isAsistente = $user->hasRole('asistente');
    $isMedico = $user->hasRole('medico');
@endphp

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

table td {
    vertical-align: middle !important;
    text-align: center;
}

/* =========================
   ESTADOS DE DIAGNÓSTICO
========================= */

/* Diagnóstico registrado */
.estado-completo {
    background-color: #edf7ed !important;
    transition: 0.3s;
  
}

/* Pendiente */
.estado-pendiente {
    background-color: #fff8e6 !important;
    transition: 0.3s;
    
}

/* Observación */
.estado-observacion {
    background-color: #fff1e6 !important;
    transition: 0.3s;
}

/* Crítico */
.estado-critico {
    background-color: #fdecec !important;
    transition: 0.3s;
}

/* Hover elegante */
.estado-completo:hover,
.estado-pendiente:hover,
.estado-observacion:hover,
.estado-critico:hover {
    transform: scale(1.002);
    box-shadow: inset 0 0 0 9999px rgba(255,255,255,0.08);
}

/* Badge estado */
.badge-estado {
    padding: 6px 12px;
     font-size:13px;
   
    font-weight: 600;
    letter-spacing: .3px;
}

.badge-completo {
  
    color: #256b3f;
   
}

.badge-pendiente {
    color:#b78103;
    

  
}

.badge-observacion {
  
    color: #a65300;

}

.badge-critico {
    background: #f8d7da;
    color: #842029;
}
.estado-diagnostico{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:6px 12px;
    

    background:#fff8e6;
    color:#b78103;

    font-size:13px;
    font-weight:600;

    
}


</style>
</head>

<div class="row mb-3">

    <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">

        {{-- TITULO --}}
        <div style="display:flex; align-items:center; gap:10px;">

            <i class="bi bi-clipboard2-pulse-fill"
               style="font-size:28px; color:#5f6b7a;"></i>

            <h1 style="margin:0;
                       font-size:26px;
                       font-weight:500;
                       color:#4a5568;">

                Historias Clinicas

            </h1>

        </div>

        {{-- BOTONES --}}
        <div style="display:flex; gap:10px;">

            <a href="{{ url($base.'/pacientes') }}"
               class="btn"
               style="background:#4a5568; color:white; border-radius:6px;">
                 Volver
            </a>

            @if($isAsistente || $isAdmin)

                <a href="{{ route($base.'.consultas.create', $paciente->id) }}"
                   class="btn"
                   style="background:#f4d279; color:#4a5568; border-radius:6px;">
                    <i class="bi bi-plus-circle-fill"></i> <b>Nuevo Registro </b>
                </a>

            @endif

        </div>

    </div>

</div>

<hr>

<div class="card card-outline" style="border-top:3px solid #f4d279;">

    <div class="card-header">

        <small style="color:#4a5568;font-size:18px">
            <b>Paciente:</b>
            {{ $paciente->nombres }} {{ $paciente->apellidos }}
            | DNI: {{ $paciente->DNI }}
        </small>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover table-sm">

            <thead style="background:#4a5568; color:white;text-align:center;">
                <tr>
                    <th>Nro</th>
                    <th>Fecha</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Diagnóstico</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody style="text-align:center;">

            @forelse($consultas as $consulta)

                @php

                    // ESTADO DEL DIAGNÓSTICO

                    if(!$consulta->diagnostico_principal){

                        $estadoClase = 'estado-pendiente';
                        $badgeClase = 'badge-pendiente';
                        $estadoTexto = 'Pendiente';

                    } else {

                        $estadoClase = 'estado-completo';
                        $badgeClase = 'badge-completo';
                        $estadoTexto = 'Registrado';
                    }

                @endphp

                <tr class="{{ $estadoClase }}">

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}</td>

                    <td>{{$consulta->medico->titulo_profesional ?? ''}} {{$consulta->medico->name ?? ''}} {{$consulta->medico->surname ?? ''}}</td>

                    <td style="text-transform:uppercase;">{{ $consulta->especialidad }}</td>

                 <td class="text-center">

    @if($consulta->diagnostico_principal)

        {{ \Illuminate\Support\Str::limit($consulta->diagnostico_principal, 60, '...') }}

    @else

        <span class="estado-diagnostico">
            Pendiente
        </span>

    @endif

</td>

                    {{-- ESTADO --}}
                    <td>

                        <span class="badge-estado {{ $badgeClase }}">
                            {{ $estadoTexto }}
                        </span>

                    </td>

                    <td>

    <div class="btn-group">

    {{-- VER --}}
    {{-- VER --}}
<a href="{{ route($base.'.consultas.show', $consulta->id) }}"
   class="btn"
   title="{{ auth()->user()->hasRole('asistente') ? 'Ver registro' : 'Ver historia clínica' }}"
   style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
   onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
   onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">

    <i class="bi bi-eye-fill"></i>
</a>


    {{-- =========================
         ADMINISTRADOR
    ========================== --}}

    @if($isAdmin)

        {{-- Edita TODA la historia clínica --}}
        <a href="{{ route($base.'.consultas.edit', $consulta->id) }}"
           class="btn"
           title="Editar historia clínica"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-pencil-square"></i>
        </a>

        {{-- Elimina TODA la historia --}}
        <a href="{{ route($base.'.consultas.delete', $consulta->id) }}"
           class="btn"
           title="Eliminar historia clínica"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-trash3-fill"></i>
        </a>

    @endif


    {{-- =========================
         ASISTENTE
    ========================== --}}

    @if($isAsistente)

        {{-- Edita únicamente signos vitales --}}
        <a href="{{ route($base.'.consultas.edit', $consulta->id) }}"
           class="btn"
           title="Actualizar Signos y Datos Clinicos"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-heart-pulse-fill"></i>
        </a>

        {{-- Solo elimina cuando está pendiente --}}
        @if(!$consulta->diagnostico_principal)

            <a href="{{ route($base.'.consultas.delete', $consulta->id) }}"
               class="btn"
               title="Eliminar Signos y Datos Clinicos"
               style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
               onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
               onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
                <i class="bi bi-trash3-fill"></i>
            </a>

        @endif

    @endif


    {{-- =========================
         MÉDICO
    ========================== --}}

    @if($isMedico && !$consulta->diagnostico_principal)

        <a href="{{ route($base.'.consultas.edit', $consulta->id) }}"
           class="btn"
           title="Completar historia clínica"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-journal-medical"></i>
        </a>

    @endif


    @if($isMedico && $consulta->diagnostico_principal)

        <a href="{{ route($base.'.consultas.edit', $consulta->id) }}"
           class="btn"
           title="Editar diagnóstico y tratamiento"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-pencil-square"></i>
        </a>

    @endif


    {{-- PDF --}}
    @if($consulta->diagnostico_principal)

        <a href="{{ route($base.'.consultas.pdf', $consulta->id) }}"
           target="_blank"
           class="btn"
           title="Imprimir historia clínica"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-file-earmark-pdf-fill"></i>
        </a>

    @endif


    {{-- RECETA --}}
    @if($consulta->tratamiento)

        <a href="{{ route($base.'.consultas.recetaPdf', $consulta->id) }}"
           target="_blank"
           class="btn"
           title="Imprimir receta"
           style="background:#f4d279;color:#4a5568;border:none;transition:.3s;"
           onmouseover="this.style.backgroundColor='#ffe8a3';this.style.boxShadow='0 0 8px rgba(244,210,121,.7)'"
           onmouseout="this.style.backgroundColor='#f4d279';this.style.boxShadow='none'">
            <i class="bi bi-file-medical-fill"></i>
        </a>

    @endif

</div>

</td>

                </tr>

            @empty

                <tr>
                    <td colspan="7">No hay consultas registradas</td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection