@php
$user = Auth::user();

if($user->hasRole('admin')){
    $base = 'admin';
}elseif($user->hasRole('asistente')){
    $base = 'asistente';
}else{
    $base = 'medico';
}
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PSCB | CRUZ BLANCA</title>
<link rel="icon" type="image/png" href="{{ asset('image/PSCB.png') }}">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DATA TABLES -->
<link rel="stylesheet" href="{{url('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<style>

/* ========================= */
/* FIX GLOBAL TABLAS */
/* ========================= */

table.dataTable{
    width:100% !important;
}

.table-responsive{
    overflow-x:auto;
    width:100%;
}

/* evita desbordes raros */
.content-wrapper{
    background:#f4f6f9;
    padding:15px;
    overflow-x:hidden;
}

.container-fluid{
    max-width:100%;
}

/* ========================= */
/* SIDEBAR (NO TOCADO) */
/* ========================= */

.main-sidebar{
    background:#2c3e50 !important;
}

.nav-sidebar .nav-link{
    color:#f4d279 !important;
    font-weight:500;
    display:flex;
    align-items:center;
    gap:10px;
    border-radius:6px;
    margin:3px 8px;
}

/* ========================= */
/* RESPONSIVE MOBILE */
/* ========================= */

@media (max-width:768px){

    .content-wrapper{
        padding:10px;
    }

    .container-fluid{
        padding-left:8px !important;
        padding-right:8px !important;
    }

    .table{
        font-size:13px;
    }

}

</style>

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- NAVBAR -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      @php
         $user = Auth::user();

          if($user->hasRole('admin')){
              $ruta = url('/admin');
          }elseif($user->hasRole('asistente')){
              $ruta = url('/asistente');
          }else{
              $ruta = url('/medico');
          }
      @endphp

      <a href="{{ $ruta }}" class="nav-link">PUESTO DE SALUD CRUZ BLANCA</a>
     
    </li>
  </ul>
</nav>


<!-- SIDEBAR -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="{{ $ruta }}" class="brand-link">

@php
    $configuracionGlobal = \App\Models\Configuracion::first();
@endphp

@if($configuracionGlobal && $configuracionGlobal->logo)

    <img 
        src="{{ asset('storage/'.$configuracionGlobal->logo) }}" 
        class="brand-image img-circle"
    >

@else

    <img 
        src="{{ asset('image/PSCB.png') }}" 
        class="brand-image img-circle"
    >

@endif


  <span class="brand-text">P.S. Cruz Blanca</span>
</a>

<div class="sidebar">

  <div class="user-panel text-center mt-3 mb-3">
   

    <div class="info text-warning">
    @if(Auth::user()->hasRole('admin'))
        Administrador
    @elseif(Auth::user()->hasRole('asistente'))
        Asistente
    @elseif(Auth::user()->hasRole('medico'))
        Médico
    @endif
</div>
</div>

  <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">
        <!--  Configuraciones-->
        @can('admin.configuraciones.index')
          <li class="nav-item">
            <a href="{{ url($base.'/configuraciones') }}" class="nav-link">
              <i class="nav-icon bi bi-gear-wide-connected"></i>
              <p>Configuracion </p>
            </a>

            
          </li>
        @endcan
      
      
      
            <!--USUARIOS_NAVEGADOR-->
        @can('admin.usuarios.index')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas bi bi-people"></i>
              <p>Usuarios <i class="right fas fa-angle-left"></i></p>
            </a>

            <ul class="nav nav-treeview">

              @can('admin.usuarios.create')
              <li class="nav-item">
                <a href="{{url($base.'/usuarios/create')}}" class="nav-link">
                  <i class="bi bi-person-add nav-icon"></i>
                  <p>Crear Usuarios</p>
                </a>
              </li>
              @endcan

              @can('admin.usuarios.index')
              <li class="nav-item">
                <a href="{{ url($base.'/usuarios') }}" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Lista de Usuarios</p>
                </a>
              </li>
              @endcan

            </ul>
          </li>
        @endcan
          
          
         @can('admin.pacientes.index')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-person-heart"></i>
            <p>Pacientes <i class="right fas fa-angle-left"></i></p>
          </a>

          <ul class="nav nav-treeview">

            @can('admin.pacientes.create')
            <li class="nav-item">
              <a href="{{url($base.'/pacientes/create')}}" class="nav-link">
                <i class="bi bi-person-vcard-fill nav-icon"></i>
                <p>Registrar Paciente</p>
              </a>
            </li>
            @endcan

            @can('admin.pacientes.index')
            <li class="nav-item">
              <a href="{{ url($base.'/pacientes') }}" class="nav-link">
                <i class="bi bi-clipboard2-plus-fill nav-icon"></i>
                <p>Lista de Pacientes</p>
              </a>
            </li>
            @endcan

          </ul>
        </li>
        @endcan

       @can('admin.horarios.index')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-house-fill"></i>
            <p>Agenda <i class="right fas fa-angle-left"></i></p>
          </a>

          <ul class="nav nav-treeview">

            <!-- HORARIOS -->
            @can('admin.horarios.index')
            <li class="nav-item">
              <a href="{{url($base.'/horarios')}}" class="nav-link">
                <i class="bi bi-house-add-fill nav-icon"></i>
                <p>Horarios</p>
              </a>
            </li>
            @endcan

            <!-- CITAS -->
            @can('admin.citas.index')
            <li class="nav-item">
              <a href="{{ url($base.'/citas') }}" class="nav-link">
                <i class="bi bi-houses-fill nav-icon"></i>
                <p>Citas médicas</p>
              </a>
            </li>
            @endcan

          </ul>
        </li>
        @endcan   
          

          
          
          <li class="nav-item">
            <a href="#" class="nav-link nav-logout"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              
                <i class="nav-icon bi bi-box-arrow-left"></i>
                <p>Cerrar Sesión</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        </li>
                </ul>
      </nav>

</div>
</aside>

<!-- CONTENT -->
<div class="content-wrapper">
  <div class="container-fluid">

    @yield('content')

  </div>
</div>

<!-- FOOTER -->
<footer class="main-footer">
   <i class="bi bi-clock-history"></i>
  <strong> Horario de atención: 08:00 a.m. - 02:00 p.m. | 02:00 p.m. - 08:00 p.m.</strong>
</footer>

</div>

<!-- SCRIPTS -->
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- DATA TABLES CORREGIDO -->
<script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{url('dist/js/adminlte.min.js')}}"></script>

<script>
$(document).ready(function(){

    // 🔥 IMPORTANTE: RESPONSIVE REAL
    $('.datatable').DataTable({
        responsive: true,
        autoWidth: false
    });

});
</script>

<!-- 🔥 AQUÍ VA SWEETALERT -->
@if(session('mensaje'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: '{{ session('icono') }}',
        title: '{{ session('mensaje') }}',
        showConfirmButton: false,
        timer: 2000
    });
});
</script>
@endif



</body>
</html>