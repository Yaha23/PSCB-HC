@extends('layouts.Admin')

@section('content')

<head>
    <style>
    .pagination .page-link {
        color: #2c3e50 !important;
        font-weight: 500;
        
        transition: 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #fff8dc !important;
        color: #2c3e50 !important;
        border-color: #f4d279;
    }

    .pagination .active .page-link {
        background-color: #2c3e50 !important;
        border-color: #85a2c5 !important;
        color: white !important;
    }
</style>
</head>

<div class="row" style="margin-bottom:15px;">
    <div style="display:flex; align-items:center; gap:10px;">
        
        <i class="nav-icon bi bi-people-fill" style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
            Horarios del Personal
        </h1>

    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">

            <!-- HEADER -->
            <div class="card-header">
                <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;"> 
                    Horarios registrados en el sistema
                    <i class="fas fa-file-alt" style="margin-left:10px; color:#9aa0a6;"></i>
                </h3>

                @can('admin.horarios.create')

                     <div  class="card-tools">
                        <a href="{{url($base.'/horarios/create')}}" class="btn btn-primary"  style="background-color: #f4d279; width: 150px;font-size: 14px;font-weight: 400;font-family: sans-serif;letter-spacing: 0.5px;border-color:#f4d279;border-radius: 6px;padding: 5px;color:  #4a5568";" >
                            <b>Nuevo Horario</b>
                        </a>
                    </div>


                @endcan

               
            </div>

            <!-- BODY -->
            <div class="card-body">

                @php
                    $contador = ($horarios->currentPage() - 1) * $horarios->perPage() + 1;
                @endphp

                <form method="GET" action="{{url($base.'/horarios')}}">

                <div style="
                display:flex;
                justify-content:center;
                gap:10px;
                flex-wrap:wrap;
                align-items:center;
                ">


                <input 
                type="text"
                name="buscar"
                value="{{request('buscar')}}"
                class="form-control"
                placeholder="Buscar personal..."
                style="
                width:250px;
                border:1px solid #f4d279;
                ">


                <select 
                name="rol"
                class="form-control"
                style="
                width:180px;
                border:1px solid #f4d279;
                ">

                <option value="">Todos</option>

                <option value="medico"
                {{request('rol')=='medico'?'selected':''}}>
                Médicos
                </option>


                <option value="asistente"
                {{request('rol')=='asistente'?'selected':''}}>
                Asistentes
                </option>


                </select>


                <button class="btn"
                style="
                background:#f4d279;
                color:#4a5568;
                ">

                <i class="bi bi-search"></i>
                Buscar

                </button>



                <a href="{{url($base.'/horarios')}}"
                class="btn btn-secondary">

                Limpiar

                </a>



                <a href="{{route($base.'.horarios.pdf',
                [
                'buscar'=>request('buscar'),
                'rol'=>request('rol')
                ])}}"
                target="_blank"
                class="btn"
                style="
                background:#4a5568;
                color:white;
                ">

                <i class="bi bi-file-earmark-pdf"></i>
                Reporte

                </a>


                </div>

                </form>

                <br>

                <table id="example1" class="table table-bordered table-hover table-sm">
                    <thead style="background-color:#4a5568; color:white">
                        <tr>
                            <td class="text-center"><b>Nro</b></td>
                            <td class="text-center"><b>Personal</b></td>
                            <td class="text-center"><b>Rol</b></td>
                            <td class="text-center"><b>Especialidad</b></td>
                            <td class="text-center"><b>Día</b></td>
                            <td class="text-center"><b>Horario</b></td>
                            <td class="text-center"><b>Acciones</b></td>
                        </tr>
                    </thead>

                    <tbody style="text-align:center;">
                        @forelse ($horarios as $horario)

                        <tr>

                        <td>
                            {{ $contador++ }}
                        </td>


                        <!-- Personal -->
                        <td>

                            {{ $horario->user->titulo_profesional ?? '' }}

                            {{ $horario->user->name ?? '---' }}

                            {{ $horario->user->surname ?? '' }}

                        </td>



                        <!-- Rol -->
                        <td>

                            @if($horario->user->hasRole('medico')) 
                            Médico
                            @elseif($horario->user->hasRole('asistente'))
                            Asistente
                            @endif


                            </td>
                            <td>

                            @if($horario->user->hasRole('medico'))

                            {{ $horario->especialidad ?? '---' }}

                            @else

                            ---

                            @endif

                            </td>



                    



                        <!-- Día -->

                        <td>

                        {{ ucfirst($horario->dia_semana) }}

                        </td>



                        <!-- Horario -->

                        <td>

                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i a') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i a') }}

                        </td>



                        <!-- Acciones -->

                        <td>

<div class="btn-group">


@can('admin.horarios.show')

<a href="{{ url($base.'/horarios/'.$horario->id) }}"
class="btn"
style="background:#f4d279;color:#4a5568">

<i class="bi bi-eye-fill"></i>

</a>

@endcan



@can('admin.horarios.edit')

<a href="{{ url($base.'/horarios/'.$horario->id.'/edit') }}"
class="btn"
style="background:#f4d279;color:#4a5568">

<i class="bi bi-pencil-square"></i>

</a>

@endcan



@can('admin.horarios.destroy')

<a href="{{ route($base.'.horarios.confirmDelete',$horario->id) }}"
class="btn"
style="background:#f4d279;color:#4a5568">

<i class="bi bi-trash3-fill"></i>

</a>

@endcan


</div>

</td>


</tr>


@empty

<tr>

<td colspan="7">

No existen horarios registrados

</td>

</tr>


@endforelse
                </table>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-end mt-2 ">
                    {{ $horarios->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection