@extends('layouts.Admin')

@section('content')

<style>

/* ========================= */
/* TITULO */
/* ========================= */
.dashboard-title{
    font-size:26px;
    font-weight:600;
    color:#34495e;
    margin-bottom:20px;
}

/* ========================= */
/* GRID CARDS */
/* ========================= */
.dashboard-row{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

/* ========================= */
/* CARD */
/* ========================= */
.stat-card{
    flex:1 1 calc(25% - 15px);
    min-width:240px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    overflow:hidden;
    transition:0.25s;
    display:flex;
    flex-direction:column;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 20px rgba(0,0,0,0.12);
}

/* TOP */
.stat-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:20px;
}

/* ICONO */
.stat-icon{
    width:50px;
    height:50px;
    background:#f4d279;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:#34495e;
}

/* INFO */
.stat-info{
    flex:1;
    margin-left:15px;
}

.stat-info p{
    margin:0;
    font-size:14px;
    color:#7f8c8d;
}

.stat-info h4{
    margin:0;
    font-size:16px;
    color:#34495e;
}

/* NUMERO */
.stat-number{
    font-size:28px;
    font-weight:bold;
    color:#34495e;
}

/* FOOTER */
.stat-footer{
    border-top:1px solid rgba(0,0,0,0.05);
    padding:10px;
    text-align:center;
    background:#34495e;
    color:#f4d279;
    text-decoration:none;
    font-weight:500;
    transition:0.3s;
}

.stat-footer:hover{
    background-color:#2c3e50;
    color:#fff;
}

/* ========================= */
/* RESPONSIVE CARDS */
/* ========================= */
@media(max-width:1200px){
    .stat-card{
        flex:1 1 calc(50% - 15px);
    }
}

@media(max-width:768px){
    .stat-card{
        flex:1 1 100%;
    }

    .dashboard-title{
        text-align:center;
        font-size:22px;
    }
}

/* ========================= */
/* CONTENEDORES INFERIORES */
/* ========================= */
.dashboard-box{
    background:#fff;
    border-radius:12px;
    padding:18px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

/* ALTURA CONTROLADA */
.dashboard-box.large{
    height:450px;
}

/* RESPONSIVE IMPORTANTE */
@media(max-width:992px){
    .dashboard-box.large{
        height:420px;
    }
}

@media(max-width:768px){
    .dashboard-box.large{
        height:380px;
    }
}

/* 🔥 CLAVE: EN MOVIL SE SEPARAN COMPLETAMENTE */
@media(max-width:768px){
    .col-lg-7,
    .col-lg-5{
        margin-bottom:20px;
    }
}

@media(max-width:480px){
    .dashboard-box.large{
        height:auto;
    }
}

</style>

<!-- ========================= -->
<!-- TITULO -->
<!-- ========================= -->
<div class="row">
    <div class="col-12">
        <h1 class="dashboard-title">
            Bienvenido:
            {{ Auth::user()->titulo_profesional ? Auth::user()->titulo_profesional : '' }}
            {{ Auth::user()->name }}
            {{ Auth::user()->surname }}
        </h1>
        <hr>
    </div>
</div>

<!-- ========================= -->
<!-- CARDS -->
<!-- ========================= -->
<div class="dashboard-row">

@can('admin.usuarios.index')
<div class="stat-card">
    <div class="stat-top">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <h4>Usuarios</h4>
            <p>Registrados en el sistema</p>
        </div>
        <div class="stat-number">{{ $total_usuarios }}</div>
    </div>
    <a href="{{ url($base.'/usuarios') }}" class="stat-footer">Acceder</a>
</div>
@endcan


@can('admin.pacientes.index')
<div class="stat-card">
    <div class="stat-top">
        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        <div class="stat-info">
            <h4>Pacientes</h4>
            <p>Historias clínicas</p>
        </div>
        <div class="stat-number">{{ $total_pacientes }}</div>
    </div>
    <a href="{{ url($base.'/pacientes') }}" class="stat-footer">Acceder</a>
</div>
@endcan


@can('admin.horarios.index')
<div class="stat-card">
    <div class="stat-top">
        <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
        <div class="stat-info">
            <h4>Horarios</h4>
            <p>Disponibilidad médica</p>
        </div>
        <div class="stat-number">{{ $total_horarios }}</div>
    </div>
    <a href="{{ url($base.'/horarios') }}" class="stat-footer">Acceder</a>
</div>
@endcan


@can('admin.citas.index')
<div class="stat-card">
    <div class="stat-top">
        <div class="stat-icon"><i class="bi bi-clipboard-check"></i></div>
        <div class="stat-info">
            <h4>Citas</h4>
            <p>Atenciones registradas</p>
        </div>
        <div class="stat-number">{{ $total_citas }}</div>
    </div>
    <a href="{{ url($base.'/citas') }}" class="stat-footer">Acceder</a>
</div>
@endcan

</div>

<!-- ========================= -->
<!-- SECCIÓN INFERIOR -->
<!-- ========================= -->
<div class="row" style="margin-top:25px;">

    <!-- CALENDARIO -->
    <div class="col-lg-7 col-md-12">
        <div class="dashboard-box large">

            <h4 style="margin-bottom:10px; color:#34495e; font-weight:600;">
                <i class="bi bi-calendar-event"></i> Calendario
            </h4>

            <div style="flex:1; overflow:hidden;">
                <div id="calendar"></div>
            </div>

        </div>
    </div>

    @php
        $user = auth()->user();
    @endphp

    <!-- GRAFICO -->
    <div class="col-lg-5 col-md-12">
        <div class="dashboard-box large">

            <h4 style="margin-bottom:10px; color:#34495e; font-weight:600;">
                <i class="bi bi-bar-chart"></i> Estadísticas
            </h4>

            <div style="
    flex:1;
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
">

    <canvas id="graficoDashboard"></canvas>

    <div id="mensajeSinDatos"
        style="
            position:absolute;
            inset:0;
            display:none;
            justify-content:center;
            align-items:center;
            flex-direction:column;
            text-align:center;
            background:#fff;
            color:#7f8c8d;
            border-radius:10px;
        ">

        <i class="bi bi-bar-chart-line"
           style="font-size:55px;color:#d7d7d7;margin-bottom:15px;"></i>

        <h5 style="margin-bottom:8px;color:#34495e;">
            Sin estadísticas disponibles
        </h5>

        <p style="margin:0;font-size:14px;">
            Las estadísticas se mostrarán cuando existan registros.
        </p>

    </div>

</div>

        </div>
    </div>

</div>

<!-- ========================= -->
<!-- LIBRERIAS -->
<!-- ========================= -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ========================= -->
<!-- JS -->
<!-- ========================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ========================= */
        /* CALENDARIO */
        /* ========================= */
        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: '100%',
            locale: 'es',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },

            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },

            eventColor: '#34495e',
            eventTextColor: '#f4d279',

            events: @json($citas_calendario)
        });

        calendar.render();

        /* ========================= */
        /* GRAFICO */
        /* ========================= */

        const ctx = document.getElementById('graficoDashboard');

    @php
        $labels = [];
        $data = [];

        // 👑 ADMIN → VE TODO
        if($user->hasRole('admin')){

            if($total_usuarios > 0){
                $labels[] = 'Usuarios';
                $data[] = $total_usuarios;
            }

            if($total_pacientes > 0){
                $labels[] = 'Pacientes';
                $data[] = $total_pacientes;
            }

            if($total_citas > 0){
                $labels[] = 'Citas';
                $data[] = $total_citas;
            }

            if($total_horarios > 0){
                $labels[] = 'Horarios';
                $data[] = $total_horarios;
            }

        // 🧑‍💼 ASISTENTE → SIN USUARIOS
        }elseif($user->hasRole('asistente')){

            if($total_pacientes > 0){
                $labels[] = 'Pacientes';
                $data[] = $total_pacientes;
            }

            if($total_citas > 0){
                $labels[] = 'Citas';
                $data[] = $total_citas;
            }

            if($total_horarios > 0){
                $labels[] = 'Horarios';
                $data[] = $total_horarios;
            }

        // 🧑‍⚕️ MÉDICO → SOLO LO SUYO
        }else{

            if($total_pacientes > 0){
                $labels[] = 'Mis Pacientes';
                $data[] = $total_pacientes;
            }

            if($total_citas > 0){
                $labels[] = 'Mis Citas';
                $data[] = $total_citas;
            }

            if($total_horarios > 0){
                $labels[] = 'Mis Horarios';
                $data[] = $total_horarios;
            }
        }
        @endphp

        const datos = @json($data);

if (datos.length > 0) {

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Resumen',
                data: datos,
                backgroundColor: '#34495e',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

} else {

    document.getElementById('mensajeSinDatos').style.display = 'flex';

}

    });

  
</script>

@endsection