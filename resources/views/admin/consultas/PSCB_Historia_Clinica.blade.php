<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<style>

@page{
    margin:15px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:10px;
    color:#000;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    border:1px solid #000;
    padding:3px;
    vertical-align:top;
}

.sin-borde{
    border:none;
}

.titulo{
    text-align:center;
    font-size:16px;
    font-weight:bold;
}

.subtitulo{
    text-align:center;
    font-size:13px;
    font-weight:bold;
}

.logo{
    width:55px;
}

.celda{
    font-weight:bold;
    background:#f5f5f5;
}

.campo{
    height:22px;
}

.area{
    height:55px;
}

.area-grande{
    height:85px;
}

.centro{
    text-align:center;
}

.footer{
    position:fixed;
    bottom:5px;
    width:100%;
    text-align:center;
    font-size:9px;
}

</style>

</head>

<body>

<table>

<tr>

<td class="sin-borde" style="width:15%;text-align:center;">

<img src="{{ public_path('image/PSCB.png') }}" class="logo">

</td>

<td class="sin-borde" style="width:70%;">

<div class="titulo">
PUESTO DE SALUD CRUZ BLANCA
</div>

<div class="subtitulo">
FORMATO DE ATENCIÓN INTEGRAL DEL ADULTO
</div>

<div class="subtitulo">
CONSULTA
</div>

</td>

<td class="sin-borde centro" style="width:15%;">
{{ date('d/m/Y') }}
</td>

</tr>

</table>

<table>

<tr>

<td class="celda" style="width:15%;">FECHA</td>
<td style="width:20%;">{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}</td>

<td class="celda" style="width:15%;">HORA</td>
<td style="width:20%;">
    {{ \Carbon\Carbon::parse($consulta->hora_atencion)->format('g:i A') }}
</td>

<td class="celda" style="width:10%;">EDAD</td>
<td style="width:20%;">
{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años
</td>

</tr>

</table>

<table>

<tr>

<td class="celda" style="width:25%;">
Paciente
</td>

<td style="width:75%;">
{{ $consulta->paciente->apellidos }},
{{ $consulta->paciente->nombres }}
</td>

</tr>

<tr>

<td class="celda">
DNI
</td>

<td>
{{ $consulta->paciente->DNI }}
</td>

</tr>

<tr>

<td class="celda">
Sexo
</td>

<td style="text-transform:uppercase;">
{{ $consulta->paciente->genero }}
</td>

</tr>

<tr>

<td class="celda">
Dirección
</td>

<td>
{{ $consulta->paciente->direccion }}
</td>

</tr>

<tr>

<td class="celda">
Profesional
</td>

<td>

{{ $consulta->medico->titulo_profesional ?? '' }}
{{ $consulta->medico->name ?? '' }}
{{ $consulta->medico->surname ?? '' }}

</td>

</tr>

<tr>

<td class="celda">
Especialidad
</td>

<td style="text-transform:uppercase;">
{{ $consulta->especialidad }}
</td>

</tr>

</table>

<table>

<tr>

<td class="celda" style="width:60%;">
Motivo de consulta
</td>

<td class="celda">
Tiempo de enfermedad
</td>

</tr>

<tr>

<td class="area">

{!! nl2br(e($consulta->motivo_consulta ?? '-')) !!}

</td>

<td>

{{ $consulta->tiempo_enfermedad ?? '-' }}

</td>

</tr>

</table>

<table>

<tr>

<td class="celda">Apetito</td>
<td class="celda">Sed</td>
<td class="celda">Sueño</td>
<td class="celda">Estado de ánimo</td>

</tr>

<tr>

<td>{{ $consulta->apetito ?? '-' }}</td>

<td>{{ $consulta->sed ?? '-' }}</td>

<td>{{ $consulta->sueno ?? '-' }}</td>

<td>{{ $consulta->estado_animo ?? '-' }}</td>

</tr>

</table>

<table>

<tr>

<td class="celda">Orina</td>

<td class="celda">Deposiciones</td>

</tr>

<tr>

<td>{{ $consulta->orina ?? '-' }}</td>

<td>{{ $consulta->deposiciones ?? '-' }}</td>

</tr>

</table>

@php

$sv=$consulta->signosVitales;

$imc='-';

if($sv && $sv->peso && $sv->talla){

$imc=round($sv->peso/($sv->talla*$sv->talla),2);

}

@endphp

<table>

<tr>

<td class="celda">Ex. Físico</td>

<td class="celda centro">T°</td>

<td class="celda centro">P.A</td>

<td class="celda centro">F.C</td>

<td class="celda centro">F.R</td>

<td class="celda centro">Peso</td>

<td class="celda centro">Talla</td>

<td class="celda centro">IMC</td>

</tr>

<tr>

<td></td>

<td class="centro">{{ $sv->temperatura ?? '-' }}</td>

<td class="centro">{{ $sv->presion_arterial ?? '-' }}</td>

<td class="centro">{{ $sv->frecuencia_cardiaca ?? '-' }}</td>

<td class="centro">{{ $sv->frecuencia_respiratoria ?? '-' }}</td>

<td class="centro">{{ $sv->peso ?? '-' }}</td>

<td class="centro">{{ $sv->talla ?? '-' }}</td>

<td class="centro">{{ $imc }}</td>

</tr>

</table>

<!-- ================= DIAGNÓSTICO Y TRATAMIENTO ================= -->

<table>

<tr>

<td class="celda" style="width:45%;">
DIAGNÓSTICO
</td>

<td class="celda" style="width:55%;">
TRATAMIENTO
</td>

</tr>

<tr>

<td class="area-grande">

{!! nl2br(e($consulta->diagnostico_principal ?? '-')) !!}

</td>

<td class="area-grande">

{!! nl2br(e($consulta->tratamiento ?? '-')) !!}

</td>

</tr>

<tr>

<td class="celda">
Exámenes auxiliares
</td>

<td class="celda">
Acuerdos y compromisos
</td>

</tr>

<tr>

<td class="area">

{!! nl2br(e($consulta->examenes_auxiliares ?? '-')) !!}

</td>

<td class="area">

{!! nl2br(e($consulta->acuerdos_compromisos ?? '-')) !!}

</td>

</tr>

<tr>

<td class="celda">
Próxima cita
</td>

<td class="celda">
Referencia (Lugar y motivo)
</td>

</tr>

<tr>

<td>

{{ $consulta->proxima_cita ?? 'No programada' }}

</td>

<td>

{!! nl2br(e($consulta->referencia ?? '-')) !!}

</td>

</tr>

<tr>

<td class="celda">
Atendido por
</td>

<td class="celda">
Firma y Sello
</td>

</tr>

<tr>

<td>

{{ $consulta->medico->titulo_profesional ?? '' }}
{{ $consulta->medico->name ?? '' }} {{ $consulta->medico->surname ?? '' }}

</td>

<td style="height:70px;text-align:center;vertical-align:bottom;">

<div style="border-top:1px solid #000;width:220px;margin:auto;"></div>



{{ $consulta->medico->titulo_profesional ?? '' }}
{{ $consulta->medico->name ?? '' }}
{{ $consulta->medico->surname ?? '' }}

<br>
{{ strtoupper($consulta->medico->specialty) }}

<br>


</td>

</tr>

<tr>

<td class="celda" colspan="2">
Observaciones
</td>

</tr>

<tr>

<td colspan="2" style="height:70px;">

{!! nl2br(e($consulta->observaciones ?? '-')) !!}

</td>

</tr>

</table>

<div class="footer">

Puesto de Salud Cruz Blanca

</div>

</body>

</html>