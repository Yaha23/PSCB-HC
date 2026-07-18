<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pacientes</title>

    <style>
    @page {
        margin: 15px 20px;
    }

    body{
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #2c3e50;

        /* 🔥 ESTO ES CLAVE PARA EVITAR CENTRADO RARO */
        margin: 0;
        padding: 0;
    }

    .wrapper{
        padding: 10px 5px;
    }

    /* ===== ENCABEZADO ===== */
    .header{
        text-align: center;
        border-bottom: 2px solid #2c3e50;
        padding-bottom: 8px;
        margin-bottom: 10px;
    }

    .header h1{
        margin: 0;
        font-size: 17px;
        font-weight: bold;
    }

    .header h2{
        margin: 3px 0;
        font-size: 11px;
        color: #6c757d;
    }

    .header .meta{
        font-size: 10px;
        color: #888;
    }

    /* ===== RESUMEN ===== */
    .summary{
        margin-bottom: 10px;
        font-size: 10px;
        padding: 6px 8px;
        background: #f5f7fa;
        border: 1px solid #e3e6ea;
    }

    /* ===== TABLA ===== */
    table{
        width: 100%;
        border-collapse: collapse;
    }

    thead th{
        background: #2c3e50;
        color: white;
        font-size: 9px;
        padding: 7px;
        text-transform: uppercase;
    }

    tbody td{
        border: 1px solid #ddd;
        padding: 6px;
        font-size: 9px;
        text-align: center;
    }

    tbody tr:nth-child(even){
        background: #f7f9fb;
    }

    .left{
        text-align: left;
    }

    /* ===== FOOTER ===== */
    .footer{
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 9px;
        color: #777;
        border-top: 1px solid #ddd;
        padding-top: 4px;
    }
</style>
</head>

<body>

<div class="wrapper">

    <div class="header">
        <h1>PUESTO DE SALUD CRUZ BLANCA</h1>
        <h2>Reporte General de Pacientes</h2>
        <div class="meta">
            Fecha: {{ date('d/m/Y H:i') }}
        </div>
    </div>

    <div class="summary">
        Total de pacientes: <b>{{ count($pacientes) }}</b>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Paciente</th>
                <th>DNI</th>
                <th>Género</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Diagnóstico</th>
            </tr>
        </thead>

        <tbody>
            @php $i = 1; @endphp

            @foreach ($pacientes as $paciente)
                @php
                    $consulta = $paciente->consultas->first();
                @endphp

                <tr>
                    <td>{{ $i++ }}</td>
                    <td class="left">{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                    <td>{{ $paciente->DNI }}</td>
                    <td>{{ $paciente->genero }}</td>
                    <td>
                        {{ $consulta?->medico?->name ?? '---' }}
                        {{ $consulta?->medico?->surname ?? '' }}
                    </td>
                    <td>{{ $consulta->especialidad ?? '---' }}</td>
                    <td>{{ $consulta->fecha_atencion ?? '---' }}</td>
                    <td class="left">{{ $consulta->diagnostico_principal ?? '---' }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

</div>

<div class="footer">
    Sistema Clínico • Documento generado automáticamente
</div>

</body>
</html>