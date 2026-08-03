<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:10px;
    color:#2c3e50;
    margin:25px;
}

/*==================================
ENCABEZADO
==================================*/

.header{
    width:100%;
    border:none;
    margin-bottom:8px;
}

.header td{
    border:none;
    vertical-align:middle;
}

.logo{
    width:60px;
}

.titulo{
    text-align:center;
}

.titulo h2{
    margin:0;
    font-size:16px;
    font-weight:bold;
    color:#2c3e50;
    letter-spacing:.5px;
}

.titulo h3{
    margin-top:3px;
    margin-bottom:0;
    font-size:12px;
    font-weight:normal;
    color:#6c757d;
}

.fecha{
    text-align:right;
    font-size:10px;
    line-height:16px;
}

.linea{
    border-bottom:2px solid #f4d279;
    margin-top:8px;
    margin-bottom:14px;
}

/*==================================
TABLA
==================================*/

.tabla{
    width:100%;
    border-collapse:collapse;
}

.tabla thead{
    background:#4a5568;
    color:white;
}

.tabla th{
    border:1px solid #bfc7ce;
    padding:7px 5px;
    font-size:10px;
    font-weight:bold;
    text-transform:uppercase;
    text-align:center;
}

.tabla td{
    border:1px solid #d9d9d9;
    padding:6px 5px;
    font-size:10px;
    vertical-align:middle;
}

.tabla tbody tr:nth-child(even){
    background:#fffdf6;
}

/* Alineaciones */

.numero{
    text-align:center;
}

.personal{
    text-align:left;
}

.centro{
    text-align:center;
}

.especialidad{
    text-align:center;
    text-transform:uppercase;
}

/*==================================
PIE DE PÁGINA
==================================*/

.footer{

    position:fixed;

    bottom:10px;

    left:0;

    right:0;

    text-align:center;

    font-size:9px;

    color:#777;

    border-top:1px solid #d8d8d8;

    padding-top:5px;

}

</style>

</head>

<body>

@php
    $fechaReporte = \Carbon\Carbon::now('America/Lima');
@endphp

<table class="header">

<tr>

    <td width="15%">
        
        {{-- Si tienes logo --}}
        <img src="{{ public_path('image/PSCB.png') }}" class="logo">
    </td>

    <td width="70%" style="text-align:center;">

        <h2 style="margin:0;font-size:16px;font-weight:bold;">
            PUESTO DE SALUD CRUZ BLANCA
        </h2>

        <h3 style="margin-top:3px;font-size:12px;font-weight:normal;color:#6c757d;">
            Reporte de Horarios del Personal
        </h3>

    </td>

    <td width="15%" class="fecha">

        <strong>Fecha:</strong>
        {{ $fechaReporte->format('d/m/Y') }}
        <br>

        <strong>Hora:</strong>
        {{ $fechaReporte->format('h:i A') }}

    </td>

</tr>

</table>



<div class="linea"></div>

<table class="tabla">

<thead>

<tr>

<th width="6%">N°</th>

<th width="29%">Personal</th>

<th width="14%">Cargo</th>

<th width="20%">Especialidad</th>

<th width="11%">Día</th>

<th width="20%">Horario</th>

</tr>

</thead>

<tbody>

@forelse($horarios as $key=>$horario)

<tr>

<td class="numero">

{{ $key+1 }}

</td>

<td class="personal">

<strong>

{{ $horario->user->titulo_profesional ?? '' }}
{{ $horario->user->name }}
{{ $horario->user->surname }}

</strong>

</td>

<td class="centro">

@if($horario->user->hasRole('medico'))

Médico

@else

Asistente

@endif

</td>

<td class="especialidad">

@if($horario->user->hasRole('medico'))

{{ $horario->especialidad }}

@else

—

@endif

</td>

<td class="centro">

{{ ucfirst($horario->dia_semana) }}

</td>

<td class="centro">

{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}

&nbsp;-&nbsp;

{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}

</td>

</tr>

@empty

<tr>

<td colspan="6" class="centro">

No existen horarios registrados.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="footer">

Sistema Web de Gestión de Historias Clínicas &bull; Puesto de Salud Cruz Blanca

</div>

</body>

</html>