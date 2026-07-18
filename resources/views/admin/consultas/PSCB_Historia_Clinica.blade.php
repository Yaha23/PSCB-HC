<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">


<style>


@page{
    margin:18px 25px;
}


body{

    font-family: DejaVu Sans, sans-serif;
    font-size:10px;
    color:#000;

}


.container{

    width:100%;

}



/* ================= HEADER ================= */


.header{

    width:100%;
    border-bottom:2px solid #4a5568;
    padding-bottom:6px;

}



.logo{

    width:90px;
    height:80px;
    object-fit:contain;

}




.minsa{

    font-size:12px;
    font-weight:bold;
    color:#4a5568;

}



.establecimiento{

    font-size:10px;
    font-weight:bold;
    margin-top:3px;

}



.titulo-documento{

    margin-top:8px;
    text-align:center;
    font-size:13px;
    font-weight:bold;

}



.fecha{

    font-size:9px;

}





/* ================= TABLAS ================= */


table{

    width:100%;
    border-collapse:collapse;

}


td{

    border:1px solid #000;
    padding:5px;

}


.label{

    width:25%;
    font-weight:bold;

}





/* ================= SECCIONES ================= */


.seccion{

    margin-top:12px;
    border:1px solid #000;
    padding:5px;

    font-weight:bold;
    font-size:10px;

}






/* ================= SIGNOS ================= */


.signos td{

    text-align:center;

}


.signos .titulo{

    font-weight:bold;

}






/* ================= CAMPOS CLINICOS ================= */


.campo{

    border:1px solid #000;

    min-height:100px;

    padding:10px;

    text-align:justify;

    line-height:1.5;

}



.tratamiento{

    min-height:130px;

}







/* ================= FIRMA ================= */


.firma{

    margin-top:70px;
    text-align:center;

}



.linea{

    width:200px;

    border-top:1px solid #000;

    margin:auto;

}


.cargo{

    font-size:9px;

}






/* ================= FOOTER ================= */


.footer{

    position:fixed;

    bottom:8px;

    width:100%;

    text-align:center;

    font-size:8px;

}



</style>


</head>



<body>


<div class="container">



<!-- ================= ENCABEZADO ================= -->


<table class="header">

<tr>



<!-- LOGO PSCB -->

<td style="border:none;width:20%;vertical-align:middle;text-align:center;">


<img src="{{public_path('image/PSCB.png')}}" class="logo">


</td>




<!-- INFORMACIÓN CENTRAL -->

<td style="border:none;width:60%;text-align:center;vertical-align:middle;">



<div class="minsa">

MINISTERIO DE SALUD

</div>



<div class="establecimiento">

PUESTO DE SALUD CRUZ BLANCA

</div>



<div class="titulo-documento">

HISTORIA CLÍNICA

</div>



</td>





<!-- FECHA -->

<td style="border:none;width:20%;vertical-align:middle;text-align:right;">



<div class="fecha">

Fecha:

<br>

{{date('d/m/Y')}}


</div>



</td>




</tr>


</table>







<!-- ================= DATOS PACIENTE ================= -->



<div class="seccion">

I. DATOS DE IDENTIFICACIÓN

</div>



<table>


<tr>

<td class="label">

Apellidos y nombres

</td>


<td colspan="3">

{{$consulta->paciente->apellidos}}
{{$consulta->paciente->nombres}}

</td>


</tr>




<tr>

<td class="label">

DNI

</td>


<td>

{{$consulta->paciente->DNI}}

</td>



<td class="label">

Sexo

</td>


<td>

{{$consulta->paciente->genero}}

</td>


</tr>





<tr>

<td class="label">

Fecha nacimiento

</td>


<td>

{{$consulta->paciente->fecha_nacimiento}}

</td>



<td class="label">

Celular

</td>


<td>

{{$consulta->paciente->celular}}

</td>


</tr>




<tr>

<td class="label">

Dirección

</td>


<td colspan="3">

{{$consulta->paciente->direccion}}

</td>


</tr>



</table>







<!-- ================= ATENCION ================= -->



<div class="seccion">

II. DATOS DE LA ATENCIÓN

</div>



<table>


<tr>


<td class="label">

Fecha de atención

</td>


<td>

{{$consulta->fecha_atencion}}

</td>




<td class="label">

Especialidad

</td>


<td>

{{$consulta->especialidad}}

</td>



</tr>





<tr>

<td class="label">

Profesional responsable

</td>


<td colspan="3">

{{$consulta->medico->name ?? '-'}} {{$consulta->medico->surname ?? '-'}}

</td>


</tr>



</table>







<!-- ================= FUNCIONES VITALES ================= -->



@php

$sv=$consulta->signosVitales;

@endphp



<div class="seccion">

III. FUNCIONES VITALES

</div>




<table class="signos">


<tr>

<td class="titulo">Peso</td>

<td class="titulo">Talla</td>

<td class="titulo">P.A.</td>

<td class="titulo">Temperatura</td>

<td class="titulo">F.C.</td>

<td class="titulo">F.R.</td>


</tr>



<tr>


<td>{{$sv->peso ?? '-'}} Kg</td>

<td>{{$sv->talla ?? '-'}} m</td>

<td>{{$sv->presion_arterial ?? '-'}} mmHg</td>

<td>{{$sv->temperatura ?? '-'}} °C</td>

<td>{{$sv->frecuencia_cardiaca ?? '-'}} lpm</td>

<td>{{$sv->frecuencia_respiratoria ?? '-'}} rpm</td>


</tr>


</table>







<!-- ================= DIAGNOSTICO ================= -->



<div class="seccion">

IV. DIAGNÓSTICO

</div>



<div class="campo">


{{$consulta->diagnostico_principal ?? 'Sin diagnóstico registrado'}}


</div>







<!-- ================= TRATAMIENTO ================= -->



<div class="seccion">

V. INDICACIONES / TRATAMIENTO

</div>



<div class="campo tratamiento">


{!!nl2br(e($consulta->tratamiento ?? 'Sin tratamiento registrado'))!!}


</div>








<!-- ================= FIRMA ================= -->



<div class="firma">


<div class="linea"></div>


<br>


{{$consulta->medico->name ?? ''}}


<br>


<div class="cargo">

MÉDICO RESPONSABLE

</div>


</div>






<div class="footer">

Historia Clínica - Documento clínico confidencial

</div>



</div>


</body>


</html>