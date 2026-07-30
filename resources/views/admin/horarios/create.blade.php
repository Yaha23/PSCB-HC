@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-plus" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                Registrar Horario 
        </h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    Ingrese los datos requeridos y registre un nuevo horario

                    <i class="bi bi-pen-fill" style="margin-left:10px; color:#9aa0a6;"></i>
                    
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route($base.'.horarios.store') }}" method="POST">
                            @csrf

                            <div class="row" id="filaPrincipal">

                                <!-- Rol -->
                                <div class="col-md-4">
                                    <label style="color:#4a5568">Rol:</label>

                                    <select name="rol" id="rol" class="form-control"
                                        required style="border:1px solid #fdde92da;">

                                        <option value=""disabled selected>Seleccione</option>
                                        <option value="medico">Médico</option>
                                        <option value="asistente">Asistente</option>

                                    </select>
                                </div>


                                <!-- Personal -->
                                <div class="col-md-4">

                                    <label style="color:#4a5568">Personal:</label>

                                    <select name="user_id"
                                            id="user_id"
                                            class="form-control"
                                            required
                                            style="border:1px solid #fdde92da;">

                                        <option value=""disabled selected>Seleccione</option>

                                    </select>

                                </div>


                                <!-- Especialidad -->
                                <div class="col-md-4" id="divEspecialidad">

                                    <label style="color:#4a5568">
                                        Especialidad:
                                    </label>

                                    <input type="text"
                                        name="especialidad"
                                        id="especialidad"
                                        class="form-control"
                                        readonly
                                        style="border:1px solid #fdde92da;
                                        background-color:#f6e48bb1;
                                        text-transform:uppercase;">

                                </div>

                            </div>


                            <br>


                            <!-- SEGUNDA FILA -->
                            <div class="row" id="filaHorario">


                                <!-- Día -->
                                <div class="col-md-4" id="divDia">

                                    <label style="color:#4a5568">
                                        Día:
                                    </label>

                                    <select name="dia_semana"
                                            class="form-control"
                                            required
                                            style="border:1px solid #fdde92da;">

                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="lunes">Lunes</option>
                                        <option value="martes">Martes</option>
                                        <option value="miercoles">Miércoles</option>
                                        <option value="jueves">Jueves</option>
                                        <option value="viernes">Viernes</option>
                                        <option value="sabado">Sábado</option>

                                    </select>

                                </div>


                                <!-- Hora Inicio -->
                                <div class="col-md-4">

                                    <label style="color:#4a5568">
                                        Hora_Inicio:
                                    </label>

                                    <input type="time"
                                        name="hora_inicio"
                                        class="form-control"
                                        required
                                        style="border:1px solid #fdde92da;">

                                </div>



                                <!-- Hora Fin -->
                                <div class="col-md-4">

                                    <label style="color:#4a5568">
                                        Hora_Fin:
                                    </label>

                                    <input type="time"
                                        name="hora_fin"
                                        class="form-control"
                                        required
                                        style="border:1px solid #fdde92da;">

                                </div>


                            </div>

                                

                              
                               
                               
                                <br>
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{ url($base.'/horarios') }}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568">
                                                        <b>Registrar Horario</b>
                                                    </button>
                                        </div>
                                    </div>
                                </div>
                    </form>


                    </div>
                                  
            </div>
               
        </div>
        
    </div>

   <script>

        document.addEventListener('DOMContentLoaded', function () {


            const rol = document.getElementById('rol');
            const user = document.getElementById('user_id');

            const especialidad = document.getElementById('especialidad');
            const divEspecialidad = document.getElementById('divEspecialidad');

            const divDia = document.getElementById('divDia');


            const medicos = @json($medicos);
            const asistentes = @json($asistentes);



            function actualizarVista(){

                const filaPrincipal = document.getElementById('filaPrincipal');
                const filaHorario = document.getElementById('filaHorario');


                if(rol.value === 'medico'){


                    // Mostrar especialidad
                    divEspecialidad.style.display = '';

                    especialidad.required = true;


                    // Día vuelve a la segunda fila como primera columna
                    filaHorario.insertBefore(
                        divDia,
                        filaHorario.children[0]
                    );


                }else{


                    // Ocultar especialidad
                    divEspecialidad.style.display = 'none';

                    especialidad.value = '';

                    especialidad.required = false;


                    // Día pasa a la primera fila después de Personal
                    filaPrincipal.insertBefore(
                        divDia,
                        filaPrincipal.children[2]
                    );


                }

            }



            rol.addEventListener('change', function(){


                user.innerHTML =
                '<option value="">Seleccione</option>';


                especialidad.value = '';



                if(this.value === 'medico'){


                    medicos.forEach(function(m){


                        user.innerHTML += `

                        <option 
                            value="${m.id}"
                            data-especialidad="${m.specialty}">

                            ${m.titulo_profesional ?? ''} 
                            ${m.name} 
                            ${m.surname}

                        </option>

                        `;


                    });


                }



                if(this.value === 'asistente'){


                    asistentes.forEach(function(a){


                        user.innerHTML += `

                        <option value="${a.id}">

                            ${a.titulo_profesional ?? ''} 
                            ${a.name} 
                            ${a.surname}

                        </option>

                        `;


                    });


                }



                actualizarVista();


            });




            user.addEventListener('change',function(){


                if(rol.value === 'medico'){


                    especialidad.value =
                    this.options[this.selectedIndex]
                    .dataset.especialidad ?? '';

                }


            });



            actualizarVista();


        });

        </script>


    

@endsection

