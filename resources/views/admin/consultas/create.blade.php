@extends('layouts.Admin')

@section('content')

@php
    $user = auth()->user();

    $isAdmin = $user->hasRole('admin');
    $isAsistente = $user->hasRole('asistente');
    $isMedico = $user->hasRole('medico');

    $base = $isAdmin ? 'admin' : ($isAsistente ? 'asistente' : 'medico');
@endphp

<div style="display:flex; align-items:center; gap:10px;">
    <i class="bi bi-clipboard2-plus" style="font-size:28px; color:#5f6b7a;"></i>

    <h1 style="margin:0; font-size:26px; color:#4a5568;">

            @if($isAsistente)
                 Registro de Asignación Médica y Datos clínicos
            @else
                Registro de Historia Clinica
            @endif

        </h1>

   
</div>

<hr>

<div class="card card-outline" style="border-top:3px solid #f4d279;">

<div class="card-body">

<form action="{{ route($base.'.consultas.store') }}" method="POST">
@csrf

<input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

{{-- ================= PACIENTE ================= --}}
<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Ingrese los datos requeridos 

     <i class="bi bi-pen-fill" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-6">
        <label style="color: #4a5568" >Paciente:</label>
        <input type="text" class="form-control"
               value="{{ $paciente->nombres }} {{ $paciente->apellidos }}" readonly style=" border:1px solid #fdde92da;background-color:#fdde92da" >
    </div>

    <div class="col-md-3">
        <label style="color: #4a5568" >DNI:</label>
        <input type="text" class="form-control" value="{{ $paciente->DNI }}" readonly style=" border:1px solid #fdde92da;background-color:#fdde92da" >
    </div>

    <div class="col-md-3">
        <label style="color: #4a5568" >Edad:</label>
        <input type="text" class="form-control"
               value="{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años"
               readonly style=" border:1px solid #fdde92da;background-color:#fdde92da" >
    </div>

</div>

<hr>

{{-- ================= MÉDICO (ASISTENTE/ADMIN) ================= --}}
@if($isAsistente || $isAdmin)

<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Asignacion Medica

     <i class="bi bi-hospital-fill" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-6">
        <label style="color: #4a5568" >Médico Responsable:</label>

        <select name="medico_id" id="medicoSelect" class="form-control" required style=" border:1px solid #fdde92da;" >
            <option value="">Seleccione médico</option>

            @foreach(App\Models\User::role('medico')->get() as $medico)
                <option value="{{ $medico->id }}"
                        data-especialidad="{{ $medico->specialty }}">
                    {{ $medico->titulo_profesional }} {{ $medico->name }} {{ $medico->surname }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-6">
        <label style="color:#4a5568;">Especialidad:</label>

        <input
            type="text"
            name="especialidad"
            id="especialidad"
            class="form-control"
            readonly
            style="border:1px solid #fdde92da;
                background-color:#fdde92da;
                text-transform:uppercase;">
    </div>

</div>

@endif

{{-- ================= SIGNOS VITALES ================= --}}
<hr>

<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Ingrese los Signos Vitales( Examen Físico)

     <i class="bi bi-activity" style="margin-left:10px; color:#9aa0a6;"></i>
</h5>

<div class="row">

    <div class="col-md-2">
        <label style="color: #4a5568" >Peso:</label>
        <input type="number" step="0.01" name="peso" class="form-control"  placeholder="Kg" required style=" border:1px solid #fdde92da;" >
        
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Talla:</label>
        <input type="number" step="0.01" name="talla" class="form-control"  placeholder="m" required style=" border:1px solid #fdde92da;" >
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Presión:</label>
        <input type="text" name="presion_arterial" class="form-control" placeholder="120/80 mmHg" required style=" border:1px solid #fdde92da;" >
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >Temp:</label>
        <input type="number" step="0.1" name="temperatura" class="form-control" placeholder="°C" required style=" border:1px solid #fdde92da;" >
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >F.C:</label>
        <input type="number" name="frecuencia_cardiaca" class="form-control" placeholder="lpm" required style=" border:1px solid #fdde92da;" >
    </div>

    <div class="col-md-2">
        <label style="color: #4a5568" >F.R:</label>
        <input type="number" name="frecuencia_respiratoria" class="form-control" placeholder="rpm" required style=" border:1px solid #fdde92da;" >
    </div>

</div>

{{-- ================= CONSULTA ================= --}}
<hr>

<h5 style="font-size:12px; color:#6c757d; font-weight:500;">
    Ingrese Fecha de Consulta

     <i class="bi bi-calendar2-check-fill" style="margin-left:10px; color:#9aa0a6;"  ></i>
</h5>

<div class="row">

    <div class="col-md-4">
        <label style="color:#4a5568;">Fecha_Atención:</label>
        <input type="date"
               name="fecha_atencion"
               class="form-control"
               required
               style="border:1px solid #fdde92da;">
    </div>

    <div class="col-md-4">
        <label style="color:#4a5568;">Hora_Atención:</label>
        <input type="time"
               name="hora_atencion"
               class="form-control"
               style="border:1px solid #fdde92da;">
    </div>

    {{-- ================= PRÓXIMA CITA ================= --}}




</div>

<br>

{{-- ================= SOLO MÉDICO ================= --}}
@if($isMedico || $isAdmin)

<hr>

<h5 style="font-size:12px;color:#6c757d;font-weight:500;">
    Atención Médica
    <i class="bi bi-file-earmark-medical-fill"
       style="margin-left:10px;color:#9aa0a6;"></i>
</h5>

{{-- ================= MOTIVO ================= --}}

<div class="row">

    <div class="col-md-3">
        <label style="color:#4a5568;">Motivo de Consulta:</label>
        <input type="text"
               name="motivo_consulta"
               class="form-control"
               placeholder="consulta..."
               style="border:1px solid #fdde92da;">
        
    </div>

    {{-- ================= TIEMPO ================= --}}

     <div class="col-md-3">
        <label style="color:#4a5568;">Tiempo de Enfermedad:</label>

        <input type="text"
               name="tiempo_enfermedad"
               class="form-control"
               placeholder="Ej. 3 días"
               style="border:1px solid #fdde92da;">
    </div>

    <div class="col-md-3">
        <label style="color: #4a5568 ">Apetito:</label>

        <select name="apetito"
                class="form-control"
                style="border:1px solid #fdde92da;">

            <option value="">Seleccione</option>
            <option>Normal</option>
            <option>Disminuido</option>
            <option>Aumentado</option>

        </select>
    </div>
    <div class="col-md-3">

        <label style="color: #4a5568 "  >Sed:</label>

        <select name="sed"
                class="form-control"
                style="border:1px solid #fdde92da;">

            <option value="">Seleccione</option>
            <option>Normal</option>
            <option>Aumentada</option>
            <option>Disminuida</option>

        </select>

    </div>



</div>

<br>



{{-- ================= ANAMNESIS ================= --}}

<div class="row">

    
     <div class="col-md-3">

        <label style="color: #4a5568 " >Sueño:</label>

        <select name="sueno"
                class="form-control"
                style="border:1px solid #fdde92da;">

            <option value="">Seleccione</option>
            <option>Normal</option>
            <option>Alterado</option>

        </select>

    </div>

    <div class="col-md-3">

        <label style="color: #4a5568 "  >Estado de Ánimo:</label>

        <input type="text"
               name="estado_animo"
               class="form-control"
               style="border:1px solid #fdde92da;">

    </div>

    <div class="col-md-3">

        <label style="color: #4a5568 "  >Orina:</label>

        <input type="text"
               name="orina"
               class="form-control"
               style="border:1px solid #fdde92da;">

    </div>

    <div class="col-md-3">

        <label style="color: #4a5568 " >Deposiciones:</label>

        <input type="text"
               name="deposiciones"
               class="form-control"
               style="border:1px solid #fdde92da;">

    </div>

</div>

<br>



{{-- ================= DIAGNÓSTICO ================= --}}

<div class="row">

    <div class="col-md-6">

        <label style="color:#4a5568;">
            Diagnóstico
        </label>

        <textarea
            name="diagnostico_principal"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>
{{-- ================= TRATAMIENTO ================= --}}
    <div class="col-md-6">

        <label style="color:#4a5568;">
            Tratamiento
        </label>

        <textarea
            name="tratamiento"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>
</div>




<br>

{{-- ================= ACUERDOS ================= --}}

<div class="row">

    <div class="col-md-6">

         <label style="color: #4a5568" >Acuerdos y Compromisos:</label>

        <textarea
            name="acuerdos_compromisos"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>

    {{-- ================= EXÁMENES ================= --}}

    <div class="col-md-6">

       <label style="color: #4a5568" >Exámenes Auxiliares:</label>

        <textarea
            name="examenes_auxiliares"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>

</div>

<br>


{{-- ================= REFERENCIA ================= --}}

<div class="row">

    <div class="col-md-6">

        <label style="color: #4a5568" >Referencia:</label>

        <textarea
            name="referencia"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>

    {{-- ================= OBSERVACIONES ================= --}}

    <div class="col-md-6">

        <label style="color: #4a5568" >Observaciones:</label>

        <textarea
            name="observaciones"
            rows="3"
            class="form-control"
            style="border:1px solid #fdde92da;"></textarea>

    </div>

</div>


<br>





@endif

<hr>

{{-- ================= BOTONES ================= --}}
<div class="text-center">

    <a href="{{ route($base.'.consultas.index', $paciente->id) }}"
       class="btn"
       style="background:#4a5568; color:white; width:200px;">
        Cancelar
    </a>

    @if($isAsistente)
        <button type="submit"
                class="btn"
                style="background:#f4d279; color:#4a5568; width:250px;">
            <b>Guardar y Enviar al Médico</b>
        </button>
    @else
        <button type="submit"
                class="btn"
                style="background:#f4d279; color:#4a5568; width:250px;">
            <b>Registrar Historia Clínica</b>
        </button>
    @endif

</div>

</form>

</div>
</div>

{{-- ================= SCRIPT ESPECIALIDAD ================= --}}
<script>
document.getElementById('medicoSelect')?.addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];
    let especialidad = selected.getAttribute('data-especialidad');

    document.getElementById('especialidad').value = especialidad ?? '';
});


</script>

<script>
document.querySelectorAll('textarea').forEach(textarea => {

    textarea.addEventListener('keydown', function(e){

        if(e.key === 'Enter'){

            e.preventDefault();

            let start = this.selectionStart;
            let end = this.selectionEnd;

            let text = this.value;

            this.value =
                text.substring(0, start) +
                '\n- ' +
                text.substring(end);

            this.selectionStart =
            this.selectionEnd =
                start + 3;
        }

    });

});
</script>

@endsection