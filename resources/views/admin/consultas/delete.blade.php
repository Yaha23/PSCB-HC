@extends('layouts.Admin')

@section('content')

@php
    $user = auth()->user();

    $isAdmin = $user->hasRole('admin');
    $isAsistente = $user->hasRole('asistente');
    $isMedico = $user->hasRole('medico');

    $base = $isAdmin ? 'admin' : ($isAsistente ? 'asistente' : 'medico');

    $sv = $consulta->signosVitales ?? null;
@endphp

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-trash3-fill" style="font-size:28px; color:#4a5568;"></i>

        <h1 style="margin:0; font-size:26px; color:#4a5568;">
            @if($isAsistente)
                Confirmar Eliminación de Datos Clínicos:{{ $consulta->paciente->nombres }}
            @else
                Confirmar Eliminación de Historia Clínica
            @endif
        </h1>
    </div>


</div>

<hr>



{{-- ================= CARD ================= --}}
<div class="card card-outline" style="border-top:3px solid #f4d279;">

    <div class="card-body">
        <form action="{{ route($base.'.consultas.destroy', $consulta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('DELETE')

            {{-- ================= PACIENTE ================= --}}
            <h5 style="color:#4a5568;">Datos del Paciente</h5>

            <div class="row">

                <div class="col-md-4">
                    <label style="color: #4a5568" >Paciente:</label>
                    <input class="form-control" readonly
                        value="{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}"style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                </div>

                <div class="col-md-2">
                    <label style="color: #4a5568" >DNI:</label>
                    <input class="form-control" readonly value="{{ $consulta->paciente->DNI }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                </div>

                <div class="col-md-2">
                    <label style="color: #4a5568" >Edad:</label>
                    <input class="form-control" readonly
                        value="{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                </div>

                <div class="col-md-4">
                    <label style="color: #4a5568" >Fecha de Consulta:</label>
                    <input class="form-control" readonly value="{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
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
                    <input class="form-control" readonly
                        value="{{$consulta->medico->titulo_profesional ?? ''}} {{$consulta->medico->name ?? ''}} {{$consulta->medico->surname ?? ''}}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                </div>

                <div class="col-md-6">
                    <label style="color: #4a5568" >Especialidad:</label>
                    <input class="form-control" readonly value="{{ $consulta->especialidad }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                </div>

            </div>

            <hr>
{{-- ================= SIGNOS VITALES ================= --}}
<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Signos Vitales

    <i class="bi bi-activity" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-2">
        <label style="color:#4a5568">Peso:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->peso ?? '-' }}"
                   style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

            <div class="input-group-append">
                <span class="input-group-text"
                      style="background-color:#f4d279; border:#f4d279;">
                    Kg
                </span>
            </div>
        </div>
    </div>


    <div class="col-md-2">
        <label style="color:#4a5568">Talla:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->talla ?? '-' }}"
                   style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

            <div class="input-group-append">
                <span class="input-group-text"
                      style="background-color:#f4d279; border:#f4d279;">
                    m
                </span>
            </div>
        </div>
    </div>


    <div class="col-md-2">
        <label style="color:#4a5568">Presión:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->presion_arterial ?? '-' }}"
                   style="background-color:#f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">

            <div class="input-group-append">
                <span class="input-group-text"
                      style="background-color:#f4d279; border:#f4d279;">
                    mmHg
                </span>
            </div>
        </div>
    </div>


    <div class="col-md-2">
        <label style="color:#4a5568">Temperatura:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->temperatura ?? '-' }}"
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
        <label style="color:#4a5568">F.C:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->frecuencia_cardiaca ?? '-' }}"
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
        <label style="color:#4a5568">F.R:</label>

        <div class="input-group">
            <input class="form-control"
                   readonly
                   value="{{ $sv->frecuencia_respiratoria ?? '-' }}"
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

            <hr>
            @if($isAdmin)
                {{-- ================= DIAGNÓSTICO ================= --}}
                <h5 style="color:#4a5568;">Diagnóstico:</h5>

                <textarea class="form-control" rows="3" readonly style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">{{ $consulta->diagnostico_principal ?? 'Sin diagnóstico registrado' }}</textarea>

                <hr>

                {{-- ================= TRATAMIENTO ================= --}}
                <h5 style="color:#4a5568;">Tratamiento:</h5>

                <textarea class="form-control" rows="3" readonly style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">{{ $consulta->tratamiento ?? 'Sin tratamiento registrado' }}</textarea>
            @endif
           <br>
        

             {{-- BOTONES --}}
                    <!--Boton cancelar y Guardar datos-->
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-ground">
                                                    <a href="{{ route($base.'.consultas.index', $consulta->paciente_id) }}"
   class="btn btn-secondary"
   style="background-color: #4a5568;
          width: 200px;
          font-size: 16px;
          font-weight: 400;
          font-family: 'Segoe UI';
          letter-spacing: 0.5px;
          border-radius: 6px;
          padding: 5px;">
    Cancelar
</a>

                                                        @if($isAsistente)

                                                            <button type="submit" class="btn ..." style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                                <b>Eliminar Registro</b>
                                                            </button>

                                                            @else

                                                            <button type="submit" class="btn ..."style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                                <b>Eliminar Registro</b>
                                                            </button>

                                                            @endif
                                                        
                                            </div>
                                        </div>
                                    </div>

            

            
        </form>
    
    </div>
</div>

@endsection