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


            .linea-separador{
                width:1px;
                border-left:1px dashed #777;
                height:745px;
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

.header td{
    vertical-align:middle;
}

.logo{
    width:69px;
}

.header-info{
    text-align:center;
}

.nombre-centro{

    font-size:14px;
    font-weight:bold;
    text-transform:uppercase;

}


.subtitulo{

    font-size:8px;
    line-height:1.4;

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
                width:45px;
                font-weight:bold;
                white-space:nowrap;
            }


            .valor{

                border-bottom:1px dotted #999;

            }



            /* ====================================
                    SECCIONES
            ==================================== */



            .seccion{
                margin-bottom:8px;
            }

            .titulo-seccion{
                font-size:9px;
                font-weight:bold;
                text-transform:uppercase;
                border-bottom:1px solid #777;
                padding-bottom:1px;
                margin:0;
            }

            .texto{
                margin:8px 0 0 0;      /* solo 2px debajo del título */
                padding:0;
                font-size:9px;
                line-height:1.3;
                white-space:pre-wrap;
            }



            /* ====================================
                        FIRMA
            ==================================== */


            .firma-section{
                position:absolute;
                top:580px;
                left:0;
                width:100%;
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
            .receta-box{
                position:relative;
                height:520px;
            }


        </style>

        <link rel="icon" type="image/png" href="{{ asset('image/PSCB.png') }}">


    </head>


    <body>


        <div class="container">



            <table class="recetas">


                    <tr>


                                <!-- =================================================
                                                RECETA ORIGINAL
                                ================================================= -->
                        <td class="receta-columna">

                            <div class="receta-box">

                                <!-- header -->

                                <!-- datos -->

                                <!-- diagnóstico -->

                                <!-- tratamiento -->

                                <!-- firma -->
                                <table class="header">

                                            <tr>


                                                <td width="70px">


                                                    <img src="{{ public_path('image/PSCB.png') }}"
                                                    class="logo">


                                                </td>

                                                <td class="header-info">


                                                    <div class="nombre-centro">

                                                    {{ strtoupper($configuracion->nombre_puestosalud) }}

                                                    </div>


                                                    <div class="subtitulo">

                                                    Dirección: {{ $configuracion->direccion }}
                                                    </div>

                                                    
                                                    <div class="subtitulo">

                                                    Hora de Atención:
                                                    8:00 am – 2:00 pm / 2:00 pm - 8:00 pm

                                                    </div>


                                                    <div class="subtitulo">

                                                    Teléfono: {{$configuracion->telefono }}  |  Gobierno Regional de Ica | RUC:20171178585

                                                    </div>




                                                


                                                    </td>


                                            </tr>


                                </table>





                                        <div class="titulo-receta">

                                            RECETA MÉDICA

                                        </div>
                                        <br>

                                        <!-- DATOS PACIENTE -->


                                        <table class="tabla-datos">


                                            <tr>

                                            <td class="label">
                                            Paciente:
                                            </td>

                                            <td class="valor">

                                            {{ strtoupper($consulta->paciente->nombres . ' ' . $consulta->paciente->apellidos) }}

                                            </td>


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


                                            <td class="label">
                                            Fecha:
                                            </td>

                                            <td class="valor">

                                            {{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

                                            </td>


                                            </tr>


                                        </table>
                                        <br>


                                        <!-- DIAGNOSTICO -->


                                        <div class="seccion">


                                            <div class="titulo-seccion">

                                            Diagnóstico

                                            </div>

                                            <div class="texto">{{ $consulta->diagnostico_principal }}</div>

                                        </div>

                                        <!-- TRATAMIENTO -->


                                        <div class="seccion">


                                            <div class="titulo-seccion">

                                            Prescripción Médica

                                            </div>


                                            <div class="texto">{{ $consulta->tratamiento }}</div>


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


                            </div>

                        </td>

                        <td class="linea-separador"></td>



                        
                                <!-- =================================================
                                                COPIA ARCHIVO
                                ================================================= -->

                        <td class="receta-columna ">

                            <div class="receta-box">

                                <!-- header -->

                                <!-- datos -->

                                <!-- diagnóstico -->

                                <!-- tratamiento -->

                                <!-- firma -->
                                <table class="header">

                                        <tr>


                                                <td width="70px">


                                                    <img src="{{ public_path('image/PSCB.png') }}"
                                                    class="logo">


                                                </td>



                                                <td class="header-info">


                                                    <div class="nombre-centro">

                                                    {{ strtoupper($configuracion->nombre_puestosalud) }}

                                                    </div>


                                                    <div class="subtitulo">

                                                    Dirección: {{ $configuracion->direccion }}

                                                    </div>
                                                     <div class="subtitulo">

                                                    Hora de Atención:
                                                    8:00 am – 2:00 pm / 2:00 pm - 8:00 pm

                                                    </div>


                                                    <div class="subtitulo">

                                                     Teléfono: {{$configuracion->telefono }}  |  Gobierno Regional de Ica | RUC:20171178585

                                                    </div>


                                                   


                                    

                                                </td>


                                        </tr>


                                </table>

                                    <div class="titulo-receta">

                                        RECETA MÉDICA

                                    </div>

                                        <!-- DATOS PACIENTE COPIA -->
                                    <br>

                                    <table class="tabla-datos">


                                            <tr>

                                            <td class="label">
                                            Paciente:
                                            </td>

                                            <td class="valor">

                                            {{ strtoupper($consulta->paciente->nombres . ' ' . $consulta->paciente->apellidos) }}

                                            </td>


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


                                            <td class="label">
                                            Fecha:
                                            </td>

                                            <td class="valor">

                                            {{ \Carbon\Carbon::parse($consulta->fecha_atencion)->format('d/m/Y') }}

                                            </td>


                                            </tr>


                                    </table>

                                    <br>

                                        <!-- ===================================
                                                DIAGNOSTICO COPIA
                                        ==================================== -->


                                        <div class="seccion">


                                            <div class="titulo-seccion">

                                            Diagnóstico

                                            </div>



                                            <div class="texto">{{ $consulta->diagnostico_principal }} </div>


                                        </div>

                                        <!-- ===================================
                                                PRESCRIPCIÓN COPIA
                                        ==================================== -->


                                        <div class="seccion">


                                            <div class="titulo-seccion">

                                                Prescripción Médica

                                            </div>


                                            <div class="texto">{{ $consulta->tratamiento }}</div>



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

                            </div>

                        </td>


                    





                    </tr>


            </table>



        </div>



    </body>


</html>