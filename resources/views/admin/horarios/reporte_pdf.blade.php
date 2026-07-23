<!DOCTYPE html>
<html>
<head>

<style>

body{
font-family: DejaVu Sans;
font-size:12px;
}


h2{
text-align:center;
}


table{
width:100%;
border-collapse:collapse;
}


th{
background:#4a5568;
color:white;
}


td,th{
border:1px solid #999;
padding:6px;
text-align:center;
}


</style>

</head>


<body>


<h2>
Puesto de Salud Cruz Blanca
</h2>

<h3 style="text-align:center">
Horario del Personal
</h3>



<table>

<thead>

<tr>

<th>N°</th>
<th>Personal</th>
<th>Cargo</th>
<th>Especialidad</th>
<th>Día</th>
<th>Horario</th>

</tr>

</thead>


<tbody>


@foreach($horarios as $key=>$horario)


<tr>

<td>
{{ $key+1 }}
</td>


<td>

{{ $horario->user->titulo_profesional ?? '' }}
{{ $horario->user->name }}
{{ $horario->user->surname }}

</td>



<td>

@if($horario->user->hasRole('medico'))

Médico

@else

Asistente

@endif


</td>



<td>

@if($horario->user->hasRole('medico'))

{{ $horario->especialidad }}

@else

---

@endif


</td>



<td>

{{ ucfirst($horario->dia_semana) }}

</td>



<td>

{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}

-

{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}

</td>


</tr>


@endforeach


</tbody>


</table>


</body>
</html>