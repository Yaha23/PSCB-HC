@extends('layouts.Admin')

@section('content')

<div class="row" style="display:flex;align-items:center;gap:10px;">

    <i class="bi bi-pencil-square"
       style="font-size:28px;color:#5f6b7a;"></i>

    <h1 style="margin:0;font-size:26px;font-weight:500;color:#4a5568;font-family:'Segoe UI',Tahoma,sans-serif;">
        Editar Horario
    </h1>

</div>

<hr>

<div class="row">

    <div class="col-md-12">

        <div class="card card-outline" style="border-top:3px solid #f4d279;">

            <div class="card-header">

                <h3 class="card-title d-flex align-items-center"
                    style="font-size:12px;color:#6c757d;font-weight:500;">

                    Actualizar Información del Horario.

                    <i class="bi bi-pencil-fill"
                       style="margin-left:10px;color:#9aa0a6;"></i>

                </h3>

            </div>

            <div class="card-body">

                <form action="{{ route($base.'.horarios.update',$horario->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    @php
                        $rolActual = $horario->user->hasRole('medico')
                            ? 'medico'
                            : 'asistente';
                    @endphp

                    <div class="row" id="filaPrincipal">

                        <div class="col-md-4">

                            <label style="color:#4a5568">Rol:</label>

                            <select name="rol"
                                    id="rol"
                                    class="form-control"
                                    required
                                    style="border:1px solid #fdde92da;">

                                <option value="" disabled selected>Seleccione</option>

                                <option value="medico"
                                    {{ $rolActual=='medico' ? 'selected':'' }}>
                                    Médico
                                </option>

                                <option value="asistente"
                                    {{ $rolActual=='asistente' ? 'selected':'' }}>
                                    Asistente
                                </option>

                            </select>

                        </div>

                        <div class="col-md-4">

                            <label style="color:#4a5568">
                                Personal:
                            </label>

                            <select
                                name="user_id"
                                id="user_id"
                                class="form-control"
                                required
                                style="border:1px solid #fdde92da;">
                                

                            </select>
                            

                        </div>

                        <div class="col-md-4"
                             id="divEspecialidad">

                            <label style="color:#4a5568">

                                Especialidad:

                            </label>

                            <input
                                type="text"
                                id="especialidad"
                                name="especialidad"
                                readonly
                                value="{{ $horario->especialidad }}"
                                class="form-control"
                                style="border:1px solid #fdde92da;
                                background:#f6e48bb1;text-transform:uppercase">

                        </div>

                    </div>

                    <br>

                    <div class="row" id="filaHorario">

                        <div class="col-md-4"
                             id="divDia">

                            <label style="color:#4a5568">

                                Día:

                            </label>

                            <select
                                name="dia_semana"
                                class="form-control"
                                required
                                style="border:1px solid #fdde92da;">

                                @foreach([
                                    'lunes'=>'Lunes',
                                    'martes'=>'Martes',
                                    'miercoles'=>'Miércoles',
                                    'jueves'=>'Jueves',
                                    'viernes'=>'Viernes',
                                    'sabado'=>'Sábado'
                                ] as $valor=>$texto)

                                    <option
                                        value="{{ $valor }}"
                                        {{ $horario->dia_semana==$valor ? 'selected':'' }}>

                                        {{ $texto }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-4">

                            <label style="color:#4a5568">

                                Hora_Inicio:

                            </label>

                            <input
                                type="time"
                                name="hora_inicio"
                                class="form-control"
                                value="{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}"
                                required
                                style="border:1px solid #fdde92da;">

                        </div>

                        <div class="col-md-4">

                            <label style="color:#4a5568">

                                Hora_Fin:

                            </label>

                            <input
                                type="time"
                                name="hora_fin"
                                class="form-control"
                                value="{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}"
                                required
                                style="border:1px solid #fdde92da;">

                        </div>

                    </div>

                    <br>

                    <div class="text-center">

                        <a href="{{ url($base.'/horarios') }}"
                           class="btn btn-secondary"
                           style="background:#4a5568;width:200px;">

                            Cancelar

                        </a>

                        <button
                            class="btn"
                            style="background:#f4d279;width:200px;color:#4a5568;">

                            <b>Actualizar Horario</b>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded',function(){

    const rol=document.getElementById('rol');
    const user=document.getElementById('user_id');
    const especialidad=document.getElementById('especialidad');

    const divEspecialidad=document.getElementById('divEspecialidad');
    const divDia=document.getElementById('divDia');

    const filaPrincipal=document.getElementById('filaPrincipal');
    const filaHorario=document.getElementById('filaHorario');

    const medicos=@json($medicos);
    const asistentes=@json($asistentes);

    const usuarioActual={{ $horario->user_id }};

    function cargarUsuarios(){

        user.innerHTML='<option value="">Seleccione</option>';

        if(rol.value==='medico'){

            medicos.forEach(function(m){

                user.innerHTML+=`

                <option
                    value="${m.id}"
                    data-especialidad="${m.specialty}"
                    ${usuarioActual==m.id?'selected':''}>

                    ${m.titulo_profesional ?? ''}
                    ${m.name}
                    ${m.surname}

                </option>`;

            });

        }else{

            asistentes.forEach(function(a){

                user.innerHTML+=`

                <option
                    value="${a.id}"
                    ${usuarioActual==a.id?'selected':''}>

                    ${a.titulo_profesional ?? ''}
                    ${a.name}
                    ${a.surname}

                </option>`;

            });

        }

        actualizarVista();
        actualizarEspecialidad();

    }

    function actualizarVista(){

        if(rol.value==='medico'){

            divEspecialidad.style.display='';

            filaHorario.insertBefore(divDia,filaHorario.children[0]);

        }else{

            divEspecialidad.style.display='none';

            especialidad.value='';

            filaPrincipal.insertBefore(divDia,filaPrincipal.children[2]);

        }

    }

    function actualizarEspecialidad(){

        if(rol.value==='medico'){

            especialidad.value=user.options[user.selectedIndex]?.dataset.especialidad ?? '';

        }

    }

    rol.addEventListener('change',cargarUsuarios);

    user.addEventListener('change',actualizarEspecialidad);

    cargarUsuarios();

});

</script>

@endsection