@extends('layouts.Admin')

@section('content')


@php
 $readonlyStyle = 'background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;';
    $user = auth()->user();

    $isAdmin = $user->hasRole('admin');
    $isAsistente = $user->hasRole('asistente');
    $isMedico = $user->hasRole('medico');

    

    $base = $isAdmin
        ? 'admin'
        : ($isAsistente ? 'asistente' : 'medico');

    $sv = $consulta->signosVitales;
@endphp

{{-- ================= HEADER ================= --}}
<div style="display:flex; justify-content:space-between; align-items:center;">

    <div style="display:flex; align-items:center; gap:10px;">
        <i class="bi bi-clipboard2-pulse-fill"
           style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0; font-size:26px; color:#4a5568;">

            @if($isAsistente)
                Actualizar asignación médica y Datos clínicos
            @else
                Actualizar Historia Clinica
            @endif

        </h1>
    </div>

   

</div>

<hr>
<style>
    .nav-tabs .nav-link{
    color:#4a5568 !important;   /* Color del texto */
    font-weight:600;
}

.nav-tabs .nav-link:hover{
    color:#4a5568 !important;
}

.nav-tabs .nav-link.active{
    color:#4a5568 !important;
    background-color:#f4d279;
    border-color:#f4d279 #f4d279 #fff;
}
</style>
{{-- ================= FORM ================= --}}
<div class="card card-outline"
     style="border-top:3px solid #f4d279;">

<div class="card-body">

<form action="{{ route($base.'.consultas.update', $consulta->id) }}"
      method="POST">

@csrf
@method('PUT')

        <ul class="nav nav-tabs mb-4">

    <li class="nav-item">
        <a class="nav-link active"
        data-toggle="tab"
        href="#paciente">
            Datos Generales
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link"
        data-toggle="tab"
        href="#fisico">
            Evaluación Inicial
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link"
        data-toggle="tab"
        href="#atencion">
            Anamnesis y Evaluación Médica
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link"
        data-toggle="tab"
        href="#diagnostico">
            Diagnóstico y Plan Terapéutico
        </a>
    </li>

</ul>

 <div class="tab-content">
    <div class="tab-pane fade show active" id="paciente">
        {{-- ================= PACIENTE ================= --}}
        <h5 style="font-size:12px; color:#6c757d; font-weight:500;">
            Asignacion Medica

            <i class="bi bi-hospital-fill" style="margin-left:10px; color:#9aa0a6;"></i>
        </h5>

        <div class="row">

            <div class="col-md-3">
                <label style="color: #4a5568" >Nombres del Paciente:</label>

                <input class="form-control"
                    readonly
                    value="{{ $consulta->paciente->nombres }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
            </div>

            <div class="col-md-3">
                <label style="color: #4a5568" >Apellidos del Paciente:</label>

                <input class="form-control"
                    readonly
                    value=" {{ $consulta->paciente->apellidos }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
            </div>

            <div class="col-md-3">
                <label style="color: #4a5568" >DNI:</label>

                <input class="form-control"
                    readonly
                    value="{{ $consulta->paciente->DNI }}" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
            </div>

            <div class="col-md-3">
                <label style="color: #4a5568" >Edad:</label>

                <input class="form-control"
                    readonly
                    value="{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años" style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
            </div>

        </div>

        <hr>



        <div class="row">
            
            <div class="col-md-6">
                <label style="color: #4a5568" >Médico:</label>
                <select name="medico_id" id="medicoSelect"
                        class="form-control"
                        {{ ($isMedico) ? 'readonly' : '' }}
                        style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                    @foreach(App\Models\User::role('medico')->get() as $medico)
                        <option value="{{ $medico->id }}"
                            data-especialidad="{{ $medico->specialty }}"
                            {{ $consulta->medico_id == $medico->id ? 'selected' : '' }}>
                            {{ $medico->titulo_profesional }} {{ $medico->name }} {{ $medico->surname }}
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="col-md-6">
                <label style="color: #4a5568" >Especialidad:</label>
                <input type="text"
                name="especialidad"
                id="especialidad"
                class="form-control"
                value="{{ old('especialidad', $consulta->especialidad) }}"
                readonly
                style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed; text-transform:uppercase;">

            </div>
        </div>
        <hr>

    </div>
    <div class="tab-pane fade" id="fisico">
        {{-- ================= SIGNOS VITALES ================= --}}
        <h5 style="font-size:12px; color:#6c757d; font-weight:500;">
        Ingrese los Signos Vitales

        <i class="bi bi-activity" style="margin-left:10px; color:#9aa0a6;"></i>
        </h5>
        <div class="row">
            @php
                $disableSignos = $isMedico ? 'readonly' : '';
            @endphp

            <div class="col-md-2">
            <label>Peso:</label>

            <div class="input-group">
                <input type="number"
                    step="0.1"
                    name="peso"
                    class="form-control"
                    value="{{ old('peso', $sv->peso ?? '') }}"
                    {{ $disableSignos }}
                    style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                <div class="input-group-append">
                    <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">Kg</span>
                </div>
            </div>
            </div>

                <div class="col-md-2">
                <label>Talla:</label>

                <div class="input-group">
                    <input type="number"
                        step="0.01"
                        name="talla"
                        class="form-control"
                        value="{{ old('talla', $sv->talla ?? '') }}"
                        {{ $disableSignos }}
                        style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                    <div class="input-group-append">
                        <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">m</span>
                    </div>
                </div>
            </div>

                <div class="col-md-2">
                <label>Presión:</label>

                <div class="input-group">
                    <input type="text"
                        name="presion_arterial"
                        class="form-control"
                        value="{{ old('presion_arterial', $sv->presion_arterial ?? '') }}"
                        {{ $disableSignos }}
                        style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                    <div class="input-group-append">
                        <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">mmHg</span>
                    </div>
                </div>
            </div>

                <div class="col-md-2">
                <label>Temperatura:</label>

                <div class="input-group">
                    <input type="number"
                        step="0.1"
                        name="temperatura"
                        class="form-control"
                        value="{{ old('temperatura', $sv->temperatura ?? '') }}"
                        {{ $disableSignos }}
                        style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                    <div class="input-group-append">
                        <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">°C</span>
                    </div>
                </div>
            </div>

                <div class="col-md-2">
                <label>F.C:</label>

                <div class="input-group">
                        <input type="number"
                            step="1"
                            name="frecuencia_cardiaca"
                            class="form-control"
                            value="{{ old('frecuencia_cardiaca', $sv->frecuencia_cardiaca ?? '') }}"
                            {{ $disableSignos }}
                            style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">lpm</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                <label>F.R:</label>

                <div class="input-group">
                    <input type="number"
                        step="1"
                        name="frecuencia_respiratoria"
                        class="form-control"
                        value="{{ old('frecuencia_respiratoria', $sv->frecuencia_respiratoria ?? '') }}"
                        {{ $disableSignos }}
                        style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                    <div class="input-group-append">
                        <span class="input-group-text" style="background-color: #f4d279 ;border: #f4d279">rpm</span>
                    </div>
                </div>
            </div>

        </div>
        <hr>

        {{-- ================= DATOS CONSULTA ================= --}}
        <h5 style="font-size:12px; color:#6c757d; font-weight:500;">
            Ingrese Fecha de Consulta

            <i class="bi bi-calendar2-check-fill" style="margin-left:10px; color:#9aa0a6;"></i>
        </h5>

        <div class="row">

        <div class="col-md-4">
            <label style="color:#4a5568">Fecha_Atención:</label>

            <input type="date"
                name="fecha_atencion"
                class="form-control"
                value="{{ old('fecha_atencion', \Carbon\Carbon::parse($consulta->fecha_atencion)->format('Y-m-d')) }}"
                {{ ($isMedico) ? 'readonly' : '' }} 
                style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

            </div>
            <div class="col-md-4">
            <label style="color:#4a5568">Hora_Atención:</label>

            <input type="time"
                name="hora_atencion"
                class="form-control"
                    value="{{ old('hora_atencion', \Carbon\Carbon::parse($consulta->hora_atencion)->format('H:i')) }}"
                {{ ($isMedico) ? 'disabled' : '' }} 
                style="{{ $isMedico ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

            </div>


        </div>

        <hr>
    </div>
    <div class="tab-pane fade" id="atencion">
        @if(!$isAsistente)

            <h5 style="font-size:12px;color:#6c757d;font-weight:500;">
                Atención Médica
                <i class="bi bi-file-earmark-medical-fill"
                style="margin-left:10px;color:#9aa0a6;"></i>
            </h5>

            <div class="row">

                <div class="col-md-3">
                    <label>Motivo de Consulta:</label>

                    <input type="text"
                        name="motivo_consulta"
                        class="form-control"
                        value="{{ old('motivo_consulta',$consulta->motivo_consulta) }}"
                        {{ $isAsistente ? 'readonly' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">
                </div>

                <div class="col-md-3">
                    <label>Tiempo de Enfermedad:</label>

                <input type="text"
                            name="tiempo_enfermedad"
                            class="form-control"
                            value="{{ old('tiempo_enfermedad',$consulta->tiempo_enfermedad) }}"
                            {{ $isAsistente ? 'readonly' : '' }}
                            style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">
                </div>

                <div class="col-md-3">
                    <label>Apetito:</label>

                <select name="apetito"
                        class="form-control"
                        {{ $isAsistente ? 'disabled' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                        <option value="">Seleccione</option>

                        <option value="Normal"
                            {{ old('apetito',$consulta->apetito)=='Normal'?'selected':'' }}>
                            Normal
                        </option>

                        <option value="Disminuido"
                            {{ old('apetito',$consulta->apetito)=='Disminuido'?'selected':'' }}>
                            Disminuido
                        </option>

                        <option value="Aumentado"
                            {{ old('apetito',$consulta->apetito)=='Aumentado'?'selected':'' }}>
                            Aumentado
                        </option>

                    </select>
                </div>

                <div class="col-md-3">

                    <label>Sed:</label>

                    <select name="sed"
                        class="form-control"
                        {{ $isAsistente ? 'disabled' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                        <option value="">Seleccione</option>

                        <option value="Normal"
                            {{ old('sed',$consulta->sed)=='Normal'?'selected':'' }}>
                            Normal
                        </option>

                        <option value="Aumentada"
                            {{ old('sed',$consulta->sed)=='Aumentada'?'selected':'' }}>
                            Aumentada
                        </option>

                        <option value="Disminuida"
                            {{ old('sed',$consulta->sed)=='Disminuida'?'selected':'' }}>
                            Disminuida
                        </option>

                    </select>

                </div>

            </div>

            <br>

            <div class="row">

                <div class="col-md-3">

                    <label>Sueño:</label>

                    <select name="sueno"
                        class="form-control"
                        {{ $isAsistente ? 'disabled' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                        <option value="">Seleccione</option>

                        <option value="Normal"
                            {{ old('sueno',$consulta->sueno)=='Normal'?'selected':'' }}>
                            Normal
                        </option>

                        <option value="Alterado"
                            {{ old('sueno',$consulta->sueno)=='Alterado'?'selected':'' }}>
                            Alterado
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <label>Estado de Ánimo:</label>

                    <input type="text"
                        name="estado_animo"
                        class="form-control"
                        value="{{ old('estado_animo',$consulta->estado_animo) }}"
                        {{ $isAsistente ? 'readonly' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                </div>

                <div class="col-md-3">

                    <label>Orina:</label>

                    <input type="text"
                        name="orina"
                        class="form-control"
                        value="{{ old('orina',$consulta->orina) }}"
                        {{ $isAsistente ? 'readonly' : '' }}
                        style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                </div>

                <div class="col-md-3">

                    <label>Deposiciones:</label>

                <input type="text"
                    name="deposiciones"
                    class="form-control"
                    value="{{ old('deposiciones',$consulta->deposiciones) }}"
                    {{ $isAsistente ? 'readonly' : '' }}
                    style="{{ $isAsistente ? $readonlyStyle : 'border:1px solid #f4d279;' }}">

                </div>

            </div>
        @endif

    </div>

    <div class="tab-pane fade" id="diagnostico">
        @if(!$isAsistente)

            {{-- ================= SOLO MÉDICO / ADMIN ================= --}}


        
                <div class="row">

                    <div class="col-md-6">

                        <label style="color: #4a5568">Diagnóstico Principal:</label>

                        <textarea name="diagnostico_principal"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('diagnostico_principal', $consulta->diagnostico_principal) }}</textarea>

                    </div>

                    <div class="col-md-6">

                        <label style="color: #4a5568">Tratamiento:</label>

                        <textarea name="tratamiento"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('tratamiento', $consulta->tratamiento) }}</textarea>

                    </div>

                </div>

                <br>

                {{-- ================= ACUERDOS Y EXAMENES ================= --}}
                <div class="row">

                    <div class="col-md-6">

                        <label style="color: #4a5568" >Acuerdos y Compromisos:</label>

                        <textarea name="acuerdos_compromisos"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('acuerdos_compromisos', $consulta->acuerdos_compromisos) }}</textarea>

                    </div>
                    <div class="col-md-6">

                        <label style="color: #4a5568" >Exámenes Auxiliares:</label>

                        <textarea name="examenes_auxiliares"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('examenes_auxiliares', $consulta->examenes_auxiliares) }}</textarea>

                    </div>

                </div>
                {{-- ==================REFERENCIA Y OBSERVACIONES --}}

                <div class="row">

                    <div class="col-md-6">

                        <label style="color: #4a5568" >Referencia:</label>

                        <textarea name="referencia"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('referencia', $consulta->referencia) }}</textarea>

                    </div>
                    <div class="col-md-6">

                        <label style="color: #4a5568" >Observaciones:</label>

                        <textarea name="observaciones"
                                class="form-control"
                                rows="4"
                                required  style="border:1px solid #f4d279;">{{ old('observaciones', $consulta->observaciones) }}</textarea>

                    </div>

                </div>


                <hr>

        @endif
    </div>

 </div>










{{-- ================= BOTONES ================= --}}
<div class="text-center">

    <a href="{{ route($base.'.consultas.index', $consulta->paciente_id) }}"
       class="btn"
       style="background:#4a5568; color:white; width:200px;">

        Cancelar

    </a>

        @php

        if($isAsistente){
            $textoBoton = 'Actualizar Registro';
            $icono = 'bi-heart-pulse-fill';
        }

        elseif($isMedico && !$consulta->diagnostico_principal){
            $textoBoton = 'Completar Atención Médica';
            $icono = 'bi-journal-medical';
        }

        elseif($isMedico && $consulta->diagnostico_principal){
            $textoBoton = 'Guardar Cambios Clínicos';
            $icono = 'bi-clipboard2-check-fill';
        }

        elseif($isAdmin){
            $textoBoton = 'Guardar Cambios Clínicos';
            $icono = 'bi-shield-check';
        }

@endphp

    <button type="submit"
            class="btn"
            style="background:#f4d279; color:#4a5568; width:250px;">

        <b>{{ $textoBoton }}</b>

    </button>

</div>

</form>

</div>
</div>

<script>
function actualizarEspecialidad() {
    let select = document.getElementById('medicoSelect');
    let option = select.options[select.selectedIndex];
    let especialidad = option.getAttribute('data-especialidad');

    document.getElementById('especialidad').value = especialidad ?? '';
}

// al cambiar médico
document.getElementById('medicoSelect')?.addEventListener('change', actualizarEspecialidad);

// al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    actualizarEspecialidad();
});
</script>

@endsection