<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>

@page{
    margin:20px 25px;
}

body{
    font-family: DejaVu Sans;
    font-size:10px;
    color:#2c3e50;
    margin:0;
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
    margin-bottom:12px;
}

/*==================================
RESUMEN
==================================*/

.resumen{

    margin-bottom:12px;

    padding:7px 10px;

    background:#fffdf6;

    border:1px solid #f4d279;

    font-size:10px;

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

    font-size:9px;

    font-weight:bold;

    text-transform:uppercase;

    text-align:center;

}

.tabla td{

    border:1px solid #d9d9d9;

    padding:6px 5px;

    font-size:9px;

    vertical-align:middle;

}

.tabla tbody tr:nth-child(even){

    background:#fffdf6;

}

.numero{

    text-align:center;

}

.izquierda{

    text-align:left;

}

.centro{

    text-align:center;

}

/*==================================
PIE DE PAGINA
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
$fechaReporte=\Carbon\Carbon::now('America/Lima');
@endphp

<table class="header">

<tr>

<td width="15%">

{{-- Logo --}}
{{-- <img src="{{ public_path('img/logo.png') }}" class="logo"> --}}

</td>

<td width="60%" class="titulo">

<h2>PUESTO DE SALUD CRUZ BLANCA</h2>

<h3>Reporte General de Pacientes</h3>

</td>

<td width="25%" class="fecha">

<strong>Fecha:</strong>

{{ $fechaReporte->format('d/m/Y') }}

<br>

<strong>Hora:</strong>

{{ $fechaReporte->format('h:i A') }}

</td>

</tr>

</table>

<div class="linea"></div>

<div class="resumen">

<strong>Total de pacientes registrados:</strong>

{{ count($pacientes) }}

</div>

<table class="tabla">

<thead>

<tr>

<th width="5%">N°</th>

<th width="22%">Paciente</th>

<th width="11%">DNI</th>

<th width="9%">Género</th>

<th width="18%">Médico</th>

<th width="14%">Especialidad</th>

<th width="10%">Fecha</th>

<th width="21%">Diagnóstico</th>

</tr>

</thead>

<tbody>

@php
$i=1;
@endphp

@forelse($pacientes as $paciente)

@php
$consulta=$paciente->consultas->first();
@endphp

<tr>

<td class="numero">

{{ $i++ }}

</td>

<td class="izquierda">

<strong>

{{ $paciente->nombres }}

{{ $paciente->apellidos }}

</strong>

</td>

<td class="centro">

{{ $paciente->DNI }}

</td>

<td class="centro">

{{ ucfirst($paciente->genero) }}

</td>

<td class="izquierda">

@if($consulta && $consulta->medico)

{{ $consulta->medico->titulo_profesional ?? '' }}

{{ $consulta->medico->name }}

{{ $consulta->medico->surname }}

@else

---

@endif

</td>

<td class="centro">

{{ $consulta->especialidad ?? '---' }}

</td>

<td class="centro">

@if($consulta && $consulta->fecha_atencion)

{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

@else

---

@endif

</td>

<td class="izquierda">

{{ $consulta->diagnostico_principal ?? '---' }}

</td>

</tr>

@empty

<tr>

<td colspan="8" class="centro">

No existen pacientes registrados.

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