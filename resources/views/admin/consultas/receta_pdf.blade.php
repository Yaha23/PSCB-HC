<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page{
    margin:20px 24px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:10px;
    color:#333;
    line-height:1.5;
}


/* ====================================
   CONTENEDOR
==================================== */

.container{
    width:100%;
}


/* ====================================
   HEADER
==================================== */

.header{

    width:100%;
    border-bottom:1.5px solid #555;
    padding-bottom:12px;
    margin-bottom:22px;

}


.logo{

    width:80px;

}


.nombre-centro{

    font-size:20px;
    font-weight:bold;
    color:#333;
    text-transform:uppercase;
    margin-bottom:5px;

}


.subtitulo{

    font-size:10px;
    color:#555;
    margin-bottom:10px;
    padding-left:30px;

}


.titulo-receta{

    margin-top:10px;
    font-size:14px;
    font-weight:bold;
    letter-spacing:1px;
    color:#333;
    text-transform:uppercase;
    margin-bottom:10px;
    padding-left:90px;

}



/* ====================================
   DATOS PACIENTE
==================================== */


.tabla-datos{

    width:100%;
    border-collapse:collapse;
    margin-bottom:35px;

}


.tabla-datos td{

    padding:7px 3px;
    vertical-align:top;

}


.label{

    width:75px;
    font-weight:bold;
    color:#333;

}


.valor{

    border-bottom:1px dotted #999;

}



/* ====================================
   SECCIONES
==================================== */


.seccion{

    margin-top:10px;
    margin-bottom:15px;

}

.titulo-seccion{

    font-size:11px;
    font-weight:bold;
    text-transform:uppercase;

    border-bottom:1px solid #888;

    padding-bottom:4px;
    margin-bottom:3px;

}


.texto{

    font-size:10px;
    line-height:1.3;

    text-align:left;

    white-space:pre-wrap;

    word-wrap:break-word;

    overflow-wrap:break-word;

}



/* ====================================
   FIRMA
==================================== */


.firma-section{

    width:100%;
    margin-top:80px;
    text-align:center;

}


.linea-firma{

    width:220px;
    margin:auto;

    border-top:1px solid #444;

    padding-top:8px;

    font-size:10px;
    font-weight:bold;
    text-transform:uppercase;

}


.cargo{

    margin-top:5px;
    font-size:10px;

}



/* ====================================
   EVITAR CORTES
==================================== */


.header,
.seccion,
.firma-section{

    page-break-inside:avoid;

}


</style>

</head>


<body>


<div class="container">



<!-- ===================================
            HEADER
==================================== -->


<table class="header">

<tr>


<td width="90px">


<img src="{{ public_path('image/PSCB.png') }}"
     class="logo">


</td>


<td>


<div class="nombre-centro">

Puesto de Salud Cruz Blanca

</div>


<div class="subtitulo">

Dirección: C. Alva Maurtua 245 | Teléfono: 970 883 057

</div>



<div class="titulo-receta">

RECETA MÉDICA

</div>



</td>


</tr>


</table>






<!-- ===================================
          DATOS PACIENTE
==================================== -->


<table class="tabla-datos">


<tr>


<td class="label">
Paciente:
</td>


<td class="valor">

{{ strtoupper($consulta->paciente->nombres . ' ' . $consulta->paciente->apellidos) }}

</td>


<td class="label">
Fecha:
</td>


<td class="valor">

{{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

</td>


</tr>



<tr>


<td class="label">

DNI:

</td>


<td class="valor">

{{ $consulta->paciente->DNI }}

</td>



<td class="label">

Sexo:

</td>


<td class="valor">

{{ strtoupper(substr($consulta->paciente->genero,0,1)) }}

</td>


</tr>



</table>






<!-- ===================================
          DIAGNOSTICO
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
          TRATAMIENTO
==================================== -->


<div class="seccion">


<div class="titulo-seccion">

Tratamiento

</div>



<div class="texto">
{{ $consulta->tratamiento }}
</div>



</div>

<br>
<br>
<br>







<!-- ===================================
             FIRMA
==================================== -->


<div class="firma-section">


<div class="linea-firma">


{{ strtoupper($consulta->medico->name . ' ' . $consulta->medico->surname) }}


</div>



<div class="cargo">


{{ strtoupper($consulta->medico->specialty) }}


</div>



</div>




</div>


</body>

</html>