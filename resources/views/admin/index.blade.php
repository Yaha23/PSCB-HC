@extends('layouts.Admin')

@section('content')

    <style>


            .dashboard-title{
                font-size:26px;
                font-weight:600;
                color:#34495e;
                margin-bottom:20px;
            }


            .dashboard-row{
                display:flex;
                flex-wrap:wrap;
                gap:15px;
            }


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

            .stat-top{
                display:flex;
                align-items:center;
                justify-content:space-between;
                padding:20px;
            }


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


            .stat-number{
                font-size:28px;
                font-weight:bold;
                color:#34495e;
            }

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


            .dashboard-box{
                background:#fff;
                border-radius:12px;
                padding:18px;
                box-shadow:0 4px 12px rgba(0,0,0,0.08);
                display:flex;
                flex-direction:column;
                overflow:hidden;
            }


            .dashboard-box.large{
                height:450px;
            }


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


            .dashboard-banner{

                background:linear-gradient(135deg,#34495e,#4b6b88);
                border-radius:20px;
                padding:30px;
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:30px;
                color:white;
                box-shadow:0 10px 25px rgba(0,0,0,.15);
                overflow:hidden;
            }

            .banner-info{  
                width:65%;

            }

            .banner-saludo{
                display:inline-block;
                background:rgba(255,255,255,.18); 
                border-radius:30px;
                font-size:17px;
                padding:10px 22px;
                font-weight:600;
            }

            .banner-info h2{

                font-size:58px;
                font-weight:800;
                line-height:1.2;
                margin-bottom:18px;
            }

            .banner-info p{

                font-size:24px;
                font-weight:600;
                color:#f4d279;
                margin-bottom:0;
            }



            .banner-resumen div{

                background:rgba(255,255,255,.12);
                padding:15px 22px;
                border-radius:14px;
                font-size:15px;

            }

            .banner-resumen strong{

                display:block;
                font-size:26px;
                color:#f4d279;
            }

            .banner-resumen i{

                font-size:22px;
                margin-bottom:8px;

            }

            .banner-image img{

                width:300px;

                max-width:100%;

            }
            .banner-status{

                width:360px;
                display:flex;
                justify-content:center;
                align-items:center;

            }

            .status-card{
                width:100%;
                background:rgba(255,255,255,.10);
                backdrop-filter:blur(6px);
                border-radius:18px;
                padding:18px 22px; 
                border:1px solid rgba(255,255,255,.18);
            }

            .status-header{
                display:flex;
                align-items:center;
                margin-bottom:10px; 
            }

            .status-text{
                color:#ecf0f1;
                font-size:14px;
                margin-bottom:10px; 
            }

            .status-item{
                display:flex;
                align-items:center;
                margin:8px 0;   
                font-size:16px;
            }
            .status-title{

                font-size:25px;
                font-weight:700;

            }

            .status-dot{

                width:14px;
                height:14px;
                background:#FFD54F;
                border-radius:50%;
                margin-right:12px;
                animation:pulse 1s infinite;

            }

            .status-item i{

                font-size:22px;
                color:#f4d279;
                width:35px;
            }

            .status-item strong{

                color:#FFD54F;
                margin-right:6px;

            }

            @keyframes pulse{ 
                0%{

                opacity:1;
                transform:scale(1);

                }

                50%{

                opacity:.4;
                transform:scale(1.25);

                }

                100%{

                opacity:1;
                transform:scale(1);

                }

            }



            @media(max-width:991px){

                .dashboard-banner{

                    flex-direction:column;
                    text-align:center;

                }

                .banner-info{

                    width:65%;

                }

                .banner-image{

                margin-top:25px;

                }

                .banner-image img{

                width:220px;

                }

                .banner-resumen{

                justify-content:center;

                }

            }

            .alerta-dashboard{
                position: fixed;
                top: 30px;
                right: 20px;
                width: 450px;  
                max-width: 95%;
                background: #fff;
                border-left: 6px solid #f4d279;
                border-radius: 15px;
                box-shadow: 0 15px 40px rgba(0,0,0,.15);
                display: flex;
                align-items: flex-start;
                padding: 10px 10px;
                z-index: 9999;
                animation: aparecer .35s;
            }

            .alerta-icono{
                font-size: 38px;
                color: #f4d279;
                margin-right: 18px;
                flex-shrink: 0;
            }

            .alerta-contenido{
                flex: 1;
                width: 100%;
                padding-right: 10px;
            }

            .alerta-contenido h5{
                margin: 0;
                color: #34495e;
                font-size: 60px;
                font-weight: 600;
                line-height: 1.5;
            }

            .alerta-contenido p{
                margin-top: 10px;
                margin-bottom: 0;
                color: #6c757d;
                font-size: 20px;
                line-height: 1.6;
            }

            .cerrar-alerta{
                position: absolute;
                top: 12px;
                right: 12px;
                background: transparent;
                border: none;
                font-size: 18px;
                color: #777;
                cursor: pointer;
            }

            .alerta-icono{
                font-size:38px;
                color:#f4d279;
                margin-right:18px;

            }

            .alerta-contenido{
                flex:1;
                padding-right:25px;

            }

            .alerta-contenido h5{

                margin:0;
                font-size:18px;
                color:#34495e;
                line-height:1.4;

            }

            .alerta-contenido p{

                margin-top:8px;
                margin-bottom:0;
                color:#6c757d;
                font-size:14px;
                line-height:1.5;

            }

            .alerta-contenido h5{

                margin:0;
                font-size:18px;
                color:#34495e;

            }

            .alerta-contenido p{

                margin:8px 0 15px;
                color:#777;
                font-size:14px;

            }

            .btn-alerta{

                display:inline-block;
                background:#34495e;
                color:#f4d279;
                padding:8px 18px;
                border-radius:8px;
                text-decoration:none;
                font-weight:600;

            }

            .btn-alerta:hover{

                background:#2d3e50;
                color:white;

            }

            .cerrar-alerta{

                position:absolute;
                top:12px;
                right:12px;
                background:none;
                border:none;
                font-size:18px;
                color:#777;
                cursor:pointer;

            }

            @keyframes aparecer{

                from{

                opacity:0;

                transform:translateY(-20px);

                }

                to{

                opacity:1;

                transform:translateY(0);

                }

            }

    </style>


    @php
        $hora = now()->format('H');

        if($hora >= 6 && $hora < 12){
            $saludo = "☀ Buenos días";
        }elseif($hora >= 12 && $hora < 18){
            $saludo = "🌤 Buenas tardes";
        }else{
            $saludo = "🌙 Buenas noches";
        }
    @endphp

    @if($pendientes > 0)

        <div class="alerta-dashboard" id="alertaPendientes">

            <button
                class="cerrar-alerta" onclick="document.getElementById('alertaPendientes').style.display='none'">

                <i class="bi bi-x-lg"></i>

            </button>

            <div class="alerta-icono">
                <i class="bi bi-bell-fill"></i>
            </div>

            <div class="alerta-contenido">

                <h5> Tiene {{ $pendientes }} historias clínicas pendientes </h5>

                <p>Existen registros que todavía necesitan ser completados.</p>

            </div>

        </div>

    @endif


    <div class="dashboard-banner">

            <div class="banner-info">

                <span class="banner-saludo">
                    {{ $saludo }},
                    {{ Auth::user()->titulo_profesional }}
                    {{ Auth::user()->name }}
                    {{ Auth::user()->surname }}
                </span>

                <h2>
                    Bienvenido al Sistema Web de Gestión
                    de Historias Clínicas.
                </h2>

                <p>
                    Puesto de Salud Cruz Blanca
                </p>

            

            </div>

            <div class="banner-status">

                <div class="status-card">

                    <div class="status-header">

                        <span class="status-dot"></span>

                        <span class="status-title">
                            Sistema Activo
                        </span>

                    </div>

                    <p class="status-text">El sistema se encuentra funcionando correctamente.</p>

                    <hr>

                    <div class="status-item">
                        <i class="bi bi-clock-history"></i>

                        <span id="relojActual">

                        </span>
                    </div>

                    <div class="status-item">
                        <i class="bi bi-calendar-event"></i>

                        <span>
                            {{ now()->translatedFormat('d \\d\\e F \\d\\e Y') }}
                        </span>

                    </div>

                    <div class="status-item">
                        <i class="bi bi-person-badge"></i>

                        <span>

                            @if(auth()->user()->hasRole('admin'))

                                Administrador

                            @elseif(auth()->user()->hasRole('asistente'))

                                Asistente

                            @else

                                Médico

                            @endif

                        </span>

                    </div>

                </div>

            </div>

    </div>


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


    <div class="row" style="margin-top:25px;">

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

    
        <div class="col-lg-5 col-md-12">
            <div class="dashboard-box large">

                <h4 style="margin-bottom:10px; color:#34495e; font-weight:600;">
                    <i class="bi bi-bar-chart"></i> Estadísticas
                </h4>

                <div style="flex:1;position:relative;display:flex;justify-content:center;align-items:center;">

                    <canvas id="graficoDashboard"></canvas>

                    <div id="mensajeSinDatos" style="position:absolute;inset:0;display:none;justify-content:center;align-items:center; flex-direction:column;
                        text-align:center;background:#fff;color:#7f8c8d;border-radius:10px;">

                        <i class="bi bi-bar-chart-line"style="font-size:55px;color:#d7d7d7;margin-bottom:15px;"></i>

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


    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

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



            const ctx = document.getElementById('graficoDashboard');

            @php
                $labels = [];
                $data = [];

    
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

            function actualizarReloj(){

            const ahora = new Date();

            document.getElementById("relojActual").innerHTML =
                ahora.toLocaleTimeString("es-PE");
            }

            setInterval(actualizarReloj,1000);

            actualizarReloj();

    
    </script>

@endsection