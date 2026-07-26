@extends('layouts.Admin')

@section('content')

@php
    $user = auth()->user();

    $isAdmin = $user->hasRole('admin');
    $isAsistente = $user->hasRole('asistente');
    $isMedico = $user->hasRole('medico');

    $base = $isAdmin
        ? 'admin'
        : ($isAsistente ? 'asistente' : 'medico');

    $sv = $consulta->signosVitales;

    // Estado automático
    $estadoConsulta =
        !empty($consulta->diagnostico_principal) &&
        !empty($consulta->tratamiento)
        ? 'Finalizada'
        : 'Pendiente';
@endphp

{{-- ================= HEADER ================= --}}
<div style="display:flex; justify-content:space-between; align-items:center;">

    <div style="display:flex; align-items:center; gap:10px;">
        <i class="bi bi-clipboard2-pulse-fill"
           style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0; font-size:26px; color:#4a5568;">
    @if($isAsistente)
        Datos Clínicos y Signos Vitales
    @else
        Historia Clínica
    @endif
</h1>
    </div>

  

</div>

<hr>

{{-- ================= CARD PRINCIPAL ================= --}}
<div class="card card-outline"
     style="border-top:3px solid #f4d279;">

<div class="card-body">

{{-- ================= DATOS PACIENTE ================= --}}
<h5 style="font-size:12px; color:#6c757d; font-weight:500;">Datos del Paciente
      <i class="bi bi-person-vcard-fill" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-2">
        <label style="color: #4a5568" >Nombres Completos:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->paciente->nombres }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
    <div class="col-md-2">
        <label style="color: #4a5568" >Apellidos Completos:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->paciente->apellidos }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
    

    <div class="col-md-2">
        <label style="color: #4a5568" >DNI:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->paciente->DNI }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Edad:</label>
        <input class="form-control"
               readonly
               value="{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
    <div class="col-md-2">
                    <label style="color: #4a5568" >Fecha de Consulta:</label>
                    <input class="form-control" readonly value="{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y')}}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
    <div class="col-md-2">
        <label style="color:#4a5568;">Hora de Atención:</label>

        <input class="form-control"
            readonly
            value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $consulta->hora_atencion)->format('h:i a') }}"
            style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
    </div>

    

</div>

<hr>

{{-- ================= MÉDICO ================= --}}
<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Asignacion Medica

     <i class="bi bi-hospital-fill" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-6">
        <label style="color: #4a5568" >Médico Responsable:</label>

        <input class="form-control"
               readonly
               value="{{$consulta->medico->titulo_profesional ?? ''}} {{$consulta->medico->name ?? ''}} {{$consulta->medico->surname ?? ''}}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

    <div class="col-md-6">
        <label style="color: #4a5568" >Especialidad:</label>

        <input class="form-control"
               readonly
               value="{{ $consulta->especialidad }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

</div>

<hr>

{{-- ================= SIGNOS VITALES ================= --}}
<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Ingrese los Signos Vitales

     <i class="bi bi-activity" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-2">
        <label style="color: #4a5568">Peso:</label>

        <div class="input-group">

            <input class="form-control"
                readonly
                value="{{ $sv->peso ?? '' }}"
                style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

            <div class="input-group-append">
                <span class="input-group-text"
                    style="background-color:#f4d279;border:#f4d279;">
                    Kg
                </span>
            </div>

        </div>
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Talla:</label>
        <div class="input-group">
    <input class="form-control"
           readonly
           value="{{ $sv->talla ?? '' }}"
           style="background-color:#f6e48bb1; border:1px solid #fdde92da;">

    <div class="input-group-append">
        <span class="input-group-text"
              style="background-color:#f4d279;border:#f4d279;">
            m
        </span>
    </div>
</div></div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Presión:</label>

        <div class="input-group">
    <input class="form-control"
           readonly
           value="{{ $sv->presion_arterial ?? '' }}"
           style="background-color:#f6e48bb1; border:1px solid #fdde92da;">

    <div class="input-group-append">
        <span class="input-group-text"
              style="background-color:#f4d279;border:#f4d279;">
            mmHg
        </span>
    </div>
</div>
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Temperatura:</label>
         <div class="input-group">

        <input class="form-control"
               readonly
               value="{{ $sv->temperatura ?? '' }}"
               style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

        <div class="input-group-append">
            <span class="input-group-text"
                  style="background-color:#f4d279; border:#f4d279;">
                °C
            </span>
        </div>

    </div>
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >F.C:</label>
        <div class="input-group">

            <input class="form-control"
                readonly
                value="{{ $sv->frecuencia_cardiaca ?? '' }}"
                style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

            <div class="input-group-append">
                <span class="input-group-text"
                    style="background-color:#f4d279; border:#f4d279;">
                    lpm
                </span>
            </div>

        </div>
        </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >F.R:</label>
         <div class="input-group">

        <input class="form-control"
               readonly
               value="{{ $sv->frecuencia_respiratoria ?? '' }}"
               style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

        <div class="input-group-append">
            <span class="input-group-text"
                  style="background-color:#f4d279; border:#f4d279;">
                rpm
            </span>
        </div>

    </div>
    </div>

</div>

{{-- ========================================================= --}}
{{-- SOLO MÉDICO Y ADMIN VEN DIAGNÓSTICO Y TRATAMIENTO --}}
{{-- ========================================================= --}}
@if($isMedico || $isAdmin)

<hr>
<h5 style="font-size:12px;color:#6c757d;font-weight:500;">
    Atención Médica
    <i class="bi bi-file-earmark-medical-fill"
       style="margin-left:10px;color:#9aa0a6;"></i>
</h5>

<div class="row">
      <div class="col-md-3">
         <label style="color:#4a5568;">Motivo de Consulta:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->motivo_consulta }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

    <div class="col-md-3">
         <label style="color:#4a5568;">Tiempo de Enfermedad:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->tiempo_enfermedad }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
      <div class="col-md-3">
         <label style="color:#4a5568;">Apetito:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->apetito }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

    <div class="col-md-3">
         <label style="color:#4a5568;">Sed:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->sed }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

    
     


    

</div>
<div class="row">
     <div class="col-md-3">
         <label style="color:#4a5568;">Sueño:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->sueno }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
     <div class="col-md-3">
         <label style="color:#4a5568;">Estado de Ánimo:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->estado_animo }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
     <div class="col-md-3">
         <label style="color:#4a5568;">Orina:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->orina }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>
     <div class="col-md-3">
         <label style="color:#4a5568;">Deposiciones:</label>
        <input class="form-control"
               readonly
               value="{{ $consulta->deposiciones }}"  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
    </div>

</div>



<br>

<div class="row">


    <div class="col-md-6">

         <label style="color: #4a5568" >Diagnostico:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->diagnostico_principal) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->diagnostico_principal ?? 'Pendiente de evaluación médica' }}</textarea>
        </div>
    </div>

     <div class="col-md-6">

         <label style="color: #4a5568" >Tratamiento:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->tratamiento) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->tratamiento?? 'Pendiente registro' }}</textarea>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">

         <label style="color: #4a5568" >Acuerdos y Compromisos:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->acuerdos_compromisos) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->acuerdos_compromisos ?? 'Pendiente registro' }}</textarea>
        </div>
    </div>

     <div class="col-md-6">

         <label style="color: #4a5568" >Exámenes Auxiliares:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->examenes_auxiliares) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->examenes_auxiliares?? 'Pendiente registro' }}</textarea>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">

         <label style="color: #4a5568" >Referencia:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->referencia) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->referencia ?? 'Pendiente registro' }}</textarea>
        </div>
    </div>

     <div class="col-md-6">

         <label style="color: #4a5568" >Observaciones:</label>

        <div class="input-group">

                <textarea class="form-control"
                rows="4"
                readonly
                style="background-color:#f6e48bb1;
                        color:{{ empty($consulta->observaciones) ? 'red' : '#000' }};
                        font-size:13px;
                        border:1px solid #fdde92da;
                        cursor:not-allowed;">{{ $consulta->observaciones?? 'Pendiente registro' }}</textarea>
        </div>
    </div>

</div>




@endif

<hr>

{{-- ================= BOTONES ================= --}}
<div class="text-center">

    <a href="{{ route($base.'.consultas.index', $consulta->paciente_id) }}"
       class="btn"
       style="background:#4a5568;
              color:white;
              width:200px;">
        Volver
    </a>

</div>

</div>
</div>

@endsection