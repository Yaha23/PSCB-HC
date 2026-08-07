<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <style>
            @page { margin: 18px; }

            body{
                font-family: DejaVu Sans, sans-serif;
                font-size: 10px;
                color:#000;
            }

            .header{
                text-align:center;
                border-bottom:2px solid #1f3b57;
                padding-bottom:8px;
                margin-bottom:10px;
            }

            .header h1{
                margin:0;
                font-size:14px;
                color:#1f3b57;
            }

            .section-title{
                background:#e8eef5;
                padding:6px;
                font-weight:bold;
                border:1px solid #1f3b57;
                margin-top:10px;
            }

            .table{
                width:100%;
                border-collapse:collapse;
                margin-bottom:8px;
            }

            .table td{
                border:1px solid #000;
                padding:5px;
                font-size:9px;
            }

            .label{
                background:#f2f2f2;
                font-weight:bold;
                width:25%;
            }

            .box{
                min-height:60px;
            }

            .footer{
                position:fixed;
                bottom:0;
                width:100%;
                text-align:center;
                font-size:8px;
                color:#666;
            }
        </style>

    </head>

    <body>

        <div class="header">
            <h1>INFORME DE ATENCIÓN MÉDICA</h1>
            <div>Fecha impresión: {{ date('d/m/Y H:i') }}</div>
        </div>

        <div class="section-title">DATOS DEL PACIENTE</div>

        <table class="table">
            <tr>
                <td class="label">Nombre</td>
                <td>{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</td>
            </tr>
            <tr>
                <td class="label">DNI</td>
                <td>{{ $consulta->paciente->DNI }}</td>
            </tr>
        </table>

        <div class="section-title">DATOS DE LA CONSULTA</div>

        <table class="table">
            <tr>
                <td class="label">Fecha</td>
                <td>{{ $consulta->fecha_atencion }}</td>
                <td class="label">Especialidad</td>
                <td>{{ $consulta->especialidad }}</td>
            </tr>

            <tr>
                <td class="label">Médico</td>
                <td colspan="3">{{ $consulta->medico->name ?? '-' }}</td>
            </tr>
        </table>

        @php 
            $sv = $consulta->signosVitales; 
        @endphp

        <div class="section-title">SIGNOS VITALES</div>

        <table class="table">
            <tr>
                <td class="label">Peso</td>
                <td>{{ $sv->peso ?? '-' }}</td>

                <td class="label">Talla</td>
                <td>{{ $sv->talla ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Presión</td>
                <td>{{ $sv->presion_arterial ?? '-' }}</td>

                <td class="label">Temperatura</td>
                <td>{{ $sv->temperatura ?? '-' }}</td>
            </tr>
        </table>


        <div class="section-title">DIAGNÓSTICO</div>

        <table class="table">
            <tr>
                <td class="box">{{ $consulta->diagnostico_principal }}</td>
            </tr>
        </table>

        <div class="section-title">TRATAMIENTO</div>

        <table class="table">
            <tr>
                <td class="box">{{ $consulta->tratamiento }}</td>
            </tr>
        </table>

        <div style="margin-top:40px; text-align:center;">
            _______________________<br>
            FIRMA Y SELLO
        </div>

    </body>
</html>