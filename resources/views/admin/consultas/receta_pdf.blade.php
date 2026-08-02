<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>


@page{

    size: A4 landscape;

    margin:15px 18px;

}


body{

    font-family: DejaVu Sans, sans-serif;

    font-size:9px;

    color:#333;

    line-height:1.4;

}



.container{

    width:100%;

}



/* ====================================
        CONTENEDOR RECETA DOBLE
==================================== */


.recetas{

    width:100%;

    border-collapse:collapse;

}



.receta-columna{

    width:50%;

    vertical-align:top;

    padding:10px 15px;

}



.separador{

    border-left:1px dashed #777;

}



/* ====================================
             HEADER
==================================== */


.header{

    width:100%;

    border-bottom:1px solid #555;

    padding-bottom:8px;

    margin-bottom:12px;

}



.logo{

    width:60px;

}



.institucion{

    font-size:8px;

    font-weight:bold;

    color:#555;

}



.nombre-centro{

    font-size:14px;

    font-weight:bold;

    text-transform:uppercase;

}



.subtitulo{

    font-size:8px;

}



.titulo-receta{

    margin-top:8px;

    font-size:12px;

    font-weight:bold;

    text-align:center;

    text-transform:uppercase;

}





.numero-receta{

    text-align:right;

    font-size:8px;

    margin-bottom:10px;

}



/* ====================================
        DATOS PACIENTE
==================================== */


.tabla-datos{

    width:100%;

    border-collapse:collapse;

    margin-bottom:12px;

}



.tabla-datos td{

    padding:3px;

}



.label{

    width:55px;

    font-weight:bold;

}



.valor{

    border-bottom:1px dotted #999;

}



/* ====================================
        SECCIONES
==================================== */


.seccion{

    margin-bottom:10px;

}



.titulo-seccion{

    font-size:9px;

    font-weight:bold;

    text-transform:uppercase;

    border-bottom:1px solid #777;

    padding-bottom:2px;

}



.texto{

    margin-top:5px;

    font-size:9px;

    white-space:pre-wrap;

    min-height:35px;

}



/* ====================================
              RP
==================================== */


.rp{

    font-size:16px;

    font-weight:bold;

}



/* ====================================
             FIRMA
==================================== */


.firma-section{

    margin-top:35px;

    text-align:center;

}



.linea-firma{

    width:170px;

    margin:auto;

    border-top:1px solid #444;

    padding-top:5px;

    font-size:9px;

    font-weight:bold;

    text-transform:uppercase;

}



.cargo{

    font-size:9px;

    margin-top:3px;

}


</style>

</head>


<body>


<div class="container">



<table class="recetas">


<tr>


<!-- =================================================
                RECETA ORIGINAL
================================================= -->


<td class="receta-columna">



<table class="header">

<tr>


<td width="70px">


<img src="{{ public_path('image/PSCB.png') }}"
class="logo">


</td>



<td>


<div class="institucion">

MINISTERIO DE SALUD - DIRESA ICA

</div>



<div class="nombre-centro">

Puesto de Salud Cruz Blanca

</div>



<div class="subtitulo">

Dirección: C. Alva Maurtua 245 |
Teléfono: 956 562 272

</div>


</td>


</tr>


</table>





<div class="titulo-receta">

RECETA MÉDICA - ORIGINAL

</div>




<div class="numero-receta">

N° RECETA:
RX-{{ str_pad($consulta->id,6,'0',STR_PAD_LEFT) }}

</div>







<!-- DATOS PACIENTE -->


<table class="tabla-datos">


<tr>


<td class="label">

Paciente:

</td>


<td class="valor">

{{ strtoupper($consulta->paciente->nombres . ' ' . $consulta->paciente->apellidos) }}

</td>


</tr>




<tr>


<td class="label">

DNI:

</td>


<td class="valor">

{{ $consulta->paciente->DNI }}

</td>


</tr>





<tr>


<td class="label">

Edad:

</td>


<td class="valor">

{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años

</td>


</tr>




<tr>


<td class="label">

Fecha:

</td>


<td class="valor">

{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

</td>


</tr>




</table>







<!-- DIAGNOSTICO -->


<div class="seccion">


<div class="titulo-seccion">

Diagnóstico

</div>



<div class="texto">

{{ $consulta->diagnostico_principal }}

</div>


</div>







<!-- TRATAMIENTO -->


<div class="seccion">


<div class="titulo-seccion">

Prescripción Médica

</div>



<div class="rp">

Rp/

</div>



<div class="texto">

{{ $consulta->tratamiento }}

</div>


</div>







<!-- FIRMA ORIGINAL -->


<div class="firma-section">


<div class="linea-firma">


{{$consulta->medico->titulo_profesional ?? ''}}

{{ strtoupper($consulta->medico->name . ' ' . $consulta->medico->surname) }}


</div>




<div class="cargo">

{{ strtoupper($consulta->medico->specialty) }}

</div>



<div>

Colegio Prof.:

{{ $consulta->medico->colegio_profesional ?? '' }}

</div>



</div>



</td>





<!-- =================================================
                COPIA ARCHIVO
================================================= -->


<td class="receta-columna separador">





<table class="header">

<tr>


<td width="70px">


<img src="{{ public_path('image/PSCB.png') }}"
class="logo">


</td>



<td>


<div class="institucion">

MINISTERIO DE SALUD - DIRESA ICA

</div>



<div class="nombre-centro">

Puesto de Salud Cruz Blanca

</div>



<div class="subtitulo">

Dirección: C. Alva Maurtua 245 |
Teléfono: 956 562 272

</div>


</td>


</tr>


</table>





<div class="titulo-receta">

RECETA MÉDICA - COPIA ARCHIVO

</div>





<div class="numero-receta">

N° RECETA:
RX-{{ str_pad($consulta->id,6,'0',STR_PAD_LEFT) }}

</div>





<!-- DATOS PACIENTE COPIA -->


<table class="tabla-datos">


<tr>


<td class="label">

Paciente:

</td>


<td class="valor">

{{ strtoupper($consulta->paciente->nombres . ' ' . $consulta->paciente->apellidos) }}

</td>


</tr>



<tr>


<td class="label">

DNI:

</td>


<td class="valor">

{{ $consulta->paciente->DNI }}

</td>


</tr>




<tr>


<td class="label">

Edad:

</td>


<td class="valor">

{{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento)->age }} años

</td>


</tr>




<tr>


<td class="label">

Fecha:

</td>


<td class="valor">

{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

</td>


</tr>



</table>




<!-- ===================================
          DIAGNOSTICO COPIA
==================================== -->


<div class="seccion">


<div class="titulo-seccion">

Diagnóstico

</div>



<div class="texto">

{{ $consulta->diagnostico_principal }}

</div>


</div>







<!-- ===================================
          PRESCRIPCIÓN COPIA
==================================== -->


<div class="seccion">


<div class="titulo-seccion">

Prescripción Médica

</div>



<div class="rp">

Rp/

</div>



<div class="texto">

{{ $consulta->tratamiento }}

</div>



</div>








<!-- ===================================
          FIRMA COPIA
==================================== -->


<div class="firma-section">


<div class="linea-firma">


{{$consulta->medico->titulo_profesional ?? ''}}

{{ strtoupper($consulta->medico->name . ' ' . $consulta->medico->surname) }}


</div>



<div class="cargo">

{{ strtoupper($consulta->medico->specialty) }}

</div>



<div>

Colegio Prof.:

{{ $consulta->medico->colegio_profesional ?? '' }}

</div>



</div>






</td>


</tr>


</table>



</div>



</body>


</html>