@extends('layouts.Admin')

    @section('content')

        @can('admin.usuarios.create')

            <div class="row" style="display:flex; align-items:center; gap:10px;">

            <i class="bi bi-person-add" style="font-size:28px; color:#5f6b7a;"></i>
            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                    Crear Usuario
            </h1>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                    <div class="card-header">
                        <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                        Ingrese los datos requeridos y registre un nuevo usuario

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
                            <form action="{{ route($base.'.usuarios.store') }}" method="POST">
                                @csrf
                                
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label style="color:#4a5568">Usuario:</label>

                                            <input
                                                type="text"
                                                name="username"
                                                class="form-control"
                                                placeholder="usuario"
                                                value="{{ old('username') }}"
                                                style="border:1px solid #fdde92da;"
                                                required>

                                            @error('username')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <!--Campo usuario-->
                                        <div class="col-md-3">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568" >Nombres Completos:</label>
                                                <input type="text" value="{{old('name') }}" name="name"  class="form-control" id="" placeholder="Nombres" required   style=" border:1px solid #fdde92da;">
                                                    @error('name')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror        
                                            </div>
                                        </div>
                                        <!--Campo -Apellidos-->

                                        <div class="col-md-3">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568">Apellidos Completos:</label>
                                                <input type="text" value="{{old('surname') }}" name="surname" class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;"  >
                                                    @error('surname')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>



                                        <!--Campo correo electronico-->
                                        <div class="col-md-3">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568">Email:</label>
                                                <input type="email" value="{{old('email') }}" name="email" class="form-control" id="" placeholder="Correo electronico" required  style=" border:1px solid #fdde92da;" >
                                                    @error('email')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>

                                    </div>
                                    
                                    
                                    <br>
                                    
                                    <div class="row">
                                        <!--Campo telefono-->
                                        <div class="col-md-4">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568">Telefono:</label>
                                                <input type="cel" value="{{old('phone') }}" name="phone" class="form-control" id="" placeholder="Telefono" required  style=" border:1px solid #fdde92da;" >
                                                    @error('phone')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>

                                        <!--Campo contraseña-->
                                        <div class="col-md-4">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568">Contraseña:</label>
                                                <input type="password" value="{{old('password') }}" name="password" class="form-control" id="" placeholder="Contraseña" required style=" border:1px solid #fdde92da;" >
                                                    @error('password')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>
                                        
                                        <!--campo confirmar contraseña-->
                                        <div class="col-md-4">
                                            <div class="form ground">
                                            <label for="" style="color: #4a5568" >Confirmar Contraseña:</label>
                                                <input type="password" name="password_confirmation" class="form-control" id="" placeholder="Confirmar Contraseña" required style=" border:1px solid #fdde92da;" >
                                                    @error('password_confirmation')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>

                                        
                                        

                                    </div>

                                    <hr>
                                    <!--Separador para eleccion-->
                                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                                        Indica el tipo y estado de la cuenta
                                        <i class="bi bi-check-all" style="margin-left:10px; color:#9aa0a6;"></i>                
                                    </h3>
                                <br>
                                    <div class="row">

    <!-- Estado -->
    <div class="col-md-3">
        <div class="form-group">

            <label style="color:#4a5568">Estado:</label>

            <select name="status" class="form-control" required
            style="border:1px solid #fdde92da;">

                <option value="" disabled selected>Ninguno</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>

            </select>

        </div>
    </div>


    <!-- Rol -->
    <div class="col-md-3">

        <div class="form-group">

            <label style="color:#4a5568">Rol:</label>

            <select name="role" id="rol" class="form-control" required
            style="border:1px solid #fdde92da;">

                <option value="" disabled selected>Ninguno</option>

                <option value="admin">
                    Administrador
                </option>

                <option value="asistente">
                    Asistente
                </option>

                <option value="medico">
                    Médico
                </option>

            </select>

        </div>

    </div>




    <!-- Especialidad -->
    <div class="col-md-3" id="divEspecialidad" style="display:none;">

        <div class="form-group">


            <label style="color:#4a5568">
                Especialidad:
            </label>


            <select 
                name="specialty"
                id="especialidad"
                class="form-control"
                disabled
                style="border:1px solid #fdde92da;">


                <option value="" disabled>
                    Seleccione
                </option>


                <option value="Medicina general">
                    Medicina general
                </option>


                <option value="Obstetricia">
                    Obstetricia
                </option>


            </select>


        </div>

    </div>





    <!-- Titulo profesional -->
    <div class="col-md-3">

        <div class="form-group">


            <label style="color:#4a5568">
                Título profesional:
            </label>


            <select
                name="titulo_profesional"
                id="titulo_profesional"
                class="form-control"
                required
                style="border:1px solid #fdde92da;">


                <option value="" disabled selected  >Seleccione</option>

                <option value="Dr.">Dr.</option>
                <option value="Dra.">Dra.</option>
                <option value="Obst.">Obst.</option>
                <option value="Lic. Enf.">Lic. Enf.</option>
                <option value="Téc. Enf.">Téc. Enf.</option>
                <option value="Enf.">Enfermero(a)</option>
                <option value="otros">Otros</option>


            </select>

        </div>

    </div>
 




    <!-- Otro título -->
    <div class="col-md-3" id="divOtroTitulo" style="display:none;">


        <div class="form-group">

            <label style="color:#4a5568">
                Especifique el título:
            </label>


            <input
                type="text"
                name="otro_titulo"
                id="otroTitulo"
                class="form-control"
                placeholder="Ejemplo: PhD."
                style="border:1px solid #fdde92da;">


        </div>


    </div>

       <!-- Colegio Profesional -->
    <div class="col-md-3">

        <div class="form-group">

            <label style="color:#4a5568">
                Colegio Profesional:
            </label>

            <input
                type="text"
                name="colegio_profesional"
                class="form-control"
                placeholder="Ejemplo: CMP 12345"
                value="{{ old('colegio_profesional') }}"
                style="border:1px solid #fdde92da;">

            @error('colegio_profesional')
                <small style="color:red">{{ $message }}</small>
            @enderror

        </div>

    </div>


</div>
<hr>
                                    
                                    <!--Boton cancelar y Guardar datos-->
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-ground">
                                                    <a href="{{url($base.'/usuarios')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                            Cancelar
                                                    </a>
                                                        <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                            <b>Registrar usuario</b>
                                                        </button>
                                            </div>
                                        </div>
                                    </div>
                            </form>


                        </div>
                                    
                </div>
                
            </div>
            
        </div>

        <!--script que permite que al momento de seleccionar medico se habilite el campo especialidad-->
            <script>
                    
               document.addEventListener("DOMContentLoaded", function(){


    const rol = document.getElementById('rol');

    const divEspecialidad = document.getElementById('divEspecialidad');

    const especialidad = document.getElementById('especialidad');


    const titulo = document.getElementById('titulo_profesional');

    const divOtroTitulo = document.getElementById('divOtroTitulo');



    function actualizarCampos(){


        // ==========================
        // CONTROL ESPECIALIDAD
        // ==========================

        if(rol.value === "medico"){


            divEspecialidad.style.display="block";


            especialidad.disabled=false;

            especialidad.required=true;



        }else{


            divEspecialidad.style.display="none";


            especialidad.disabled=true;

            especialidad.required=false;

            especialidad.value="";


        }





        // ==========================
        // CONTROL OTRO TITULO
        // ==========================


        if(titulo.value==="otros"){


            divOtroTitulo.style.display="block";


        }else{


            divOtroTitulo.style.display="none";


            document.getElementById('otroTitulo').value="";


        }



    }



    rol.addEventListener('change', actualizarCampos);


    titulo.addEventListener('change', actualizarCampos);


});
            </script>



        @else
            <div class="alert alert-danger">
                No tienes permisos para acceder a esta página.
            </div>
        @endcan

    

    

        
        

    @endsection

