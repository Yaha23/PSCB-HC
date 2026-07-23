@extends('layouts.Admin')

@section('content')

<div class="row" style="display:flex; align-items:center; gap:10px;">

    <i class="bi bi-eye-fill" style="font-size:28px; color:#5f6b7a;"></i>

    <h1 style="
        margin:0;
        font-size:26px;
        font-weight:500;
        color:#4a5568;
        font-family:'Segoe UI', Tahoma, sans-serif;
    ">

        Información de Horario:
        {{ $horario->user->titulo_profesional ?? '' }}
        {{ $horario->user->name ?? '' }}
        {{ $horario->user->surname ?? '' }}

    </h1>

</div>


<hr>



<div class="row">

<div class="col-md-12">


<div class="card card-outline" 
style="border-top:3px solid #f4d279;">



<div class="card-header">


<h3 class="card-title"
style="
font-size:12px;
color:#6c757d;
font-weight:500;
">

Detalle del horario registrado

<i class="bi bi-calendar-week"
style="margin-left:10px;color:#9aa0a6;">
</i>


</h3>



<div class="card-tools">

<button type="button"
class="btn btn-tool"
data-card-widget="collapse">

<i class="fas fa-minus"></i>

</button>

</div>


</div>




<div class="card-body">


@php

    $esMedico = $horario->user->hasRole('medico');

@endphp



<div class="row">



{{-- PERSONAL --}}

<div class="col-md-4">

<label style="color:#4a5568;">
Personal:
</label>


<input type="text"
disabled

value="
{{ $horario->user->titulo_profesional ?? '' }}
{{ $horario->user->name ?? '' }}
{{ $horario->user->surname ?? '' }}
"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
">


</div>




{{-- ROL --}}

<div class="col-md-4">


<label style="color:#4a5568;">
Rol:
</label>



<input type="text"
disabled

value="{{ $esMedico ? 'Médico' : 'Asistente' }}"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
">


</div>





{{-- ESPECIALIDAD SOLO MEDICO --}}

@if($esMedico)

<div class="col-md-4">

<label style="color:#4a5568;">
Especialidad:
</label>


<input type="text"
disabled 

value="{{ $horario->especialidad ?? '---' }}"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
text-transform:uppercase;
">


</div>

@endif





{{-- DIA --}}

<div class="
@if($esMedico)
col-md-4
@else
col-md-4
@endif
">


<label style="color:#4a5568;">
Día:
</label>


<input type="text"
disabled

value="{{ ucfirst($horario->dia_semana) }}"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
">


</div>





{{-- HORA INICIO --}}

<div class="col-md-4">

<label style="color:#4a5568;">
Hora Inicio:
</label>


<input type="text"
disabled

value="
{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}
"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
">


</div>





{{-- HORA FIN --}}

<div class="col-md-4">

<label style="color:#4a5568;">
Hora Fin:
</label>


<input type="text"
disabled

value="
{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}
"

class="form-control"

style="
background:#f6e48bb1;
border:1px solid #fdde92da;
">


</div>




</div>





<br>


<div class="row">

<div class="col-md-12 text-center">


<a href="{{ url($base.'/horarios') }}"

class="btn btn-secondary"

style="
background:#4a5568;
width:200px;
font-size:16px;
font-family:'Segoe UI';
border-radius:6px;
padding:5px;
">

Volver

</a>


</div>

</div>




</div>


</div>


</div>


</div>


@endsection