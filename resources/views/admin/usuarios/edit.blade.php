@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-fill-check" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
                Modificar:{{ $usuario->name }} {{ $usuario->surname }}
        </h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    Actualice los datos del usuario y verifique la información antes de guardar.

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
                     
                        <form action="{{ url($base.'/usuarios',$usuario->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                                <div class="row">
                                    <!--Campo usuario-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Nombre de Usuario:</label>
                                            <input type="text" value="{{$usuario->name }}" name="name"  class="form-control" id="" placeholder="Nombres" required   style=" border:1px solid #fdde92da;">
                                                @error('name')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror        
                                        </div>
                                    </div>
                                     <!--Campo -Apellidos-->

                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Apellidos:</label>
                                            <input type="text" value="{{$usuario->surname }}" name="surname" class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;"  >
                                                @error('surname')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                    <!--Campo correo electronico-->
                                      <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Email:</label>
                                            <input type="email" value="{{$usuario->email }}" name="email" class="form-control" id="" placeholder="Correo electronico" required  style=" border:1px solid #fdde92da;" >
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
                                            <input type="cel" value="{{$usuario->phone }}" name="phone" class="form-control" id="" placeholder="Telefono" required  style=" border:1px solid #fdde92da;" >
                                                @error('phone')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                    <!--Campo contraseña-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Contraseña:</label>
                                            <input type="password" value="{{old('password') }}" name="password" class="form-control" id="" placeholder="Contraseña"  style=" border:1px solid #fdde92da;"//le dire que no es requerido para poder modificar la contraseña y cambiarla por una nueva >
                                                @error('password')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>
                                    
                                    <!--campo confirmar contraseña-->
                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for="" style="color: #4a5568" >Confirmar Contraseña:</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="" placeholder="Confirmar Contraseña"  style=" border:1px solid #fdde92da;" >
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

                                            <option disabled>Ninguno</option>

                                            <option value="activo"
                                                {{ $usuario->status == 'activo' ? 'selected' : '' }}>
                                                Activo
                                            </option>

                                            <option value="inactivo"
                                                {{ $usuario->status == 'inactivo' ? 'selected' : '' }}>
                                                Inactivo
                                            </option>

                                        </select>

                                        @error('status')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>


                                <!-- Rol -->
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label style="color:#4a5568">Rol:</label>

                                        <select name="role" id="rol" class="form-control" required
                                            style="border:1px solid #fdde92da;">

                                            <option disabled>Ninguno</option>

                                            <option value="admin"
                                            {{ $usuario->getRoleNames()->first() == 'admin' ? 'selected':'' }}>
                                                Administrador
                                            </option>


                                            <option value="asistente"
                                            {{ $usuario->getRoleNames()->first() == 'asistente' ? 'selected':'' }}>
                                                Asistente
                                            </option>


                                            <option value="medico"
                                            {{ $usuario->getRoleNames()->first() == 'medico' ? 'selected':'' }}>
                                                Médico
                                            </option>

                                        </select>

                                        @error('role')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>

                                <!-- Especialidad -->
                                <div class="col-md-3" id="divEspecialidad"
                                    style="{{ $usuario->getRoleNames()->first() == 'medico' ? '' : 'display:none;' }}">

                                    <div class="form-group">

                                        <label style="color:#4a5568">
                                            Especialidad:
                                        </label>

                                        <select 
                                            name="specialty"
                                            id="especialidad"
                                            class="form-control"
                                            {{ $usuario->getRoleNames()->first() == 'medico' ? '' : 'disabled' }}
                                            style="border:1px solid #fdde92da;">


                                            <option value="">
                                                Seleccione
                                            </option>


                                            <option value="Medicina general"
                                            {{ $usuario->specialty == 'Medicina general' ? 'selected':'' }}>
                                                Medicina general
                                            </option>


                                            <option value="Obstetricia"
                                            {{ $usuario->specialty == 'Obstetricia' ? 'selected':'' }}>
                                                Obstetricia
                                            </option>


                                        </select>


                                        @error('specialty')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror


                                    </div>

                                </div>




                       
                                <!-- Título profesional -->
                                <div class="col-md-3" id="divTitulo">

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

                                            <option value="">Seleccione</option>

                                            <option value="Dr."
                                                {{ $usuario->titulo_profesional == 'Dr.' ? 'selected' : '' }}>
                                                Dr.
                                            </option>

                                            <option value="Dra."
                                                {{ $usuario->titulo_profesional == 'Dra.' ? 'selected' : '' }}>
                                                Dra.
                                            </option>

                                            <option value="Obst."
                                                {{ $usuario->titulo_profesional == 'Obst.' ? 'selected' : '' }}>
                                                Obst.
                                            </option>

                                            <option value="Lic. Enf."
                                                {{ $usuario->titulo_profesional == 'Lic. Enf.' ? 'selected' : '' }}>
                                                Lic. Enf.
                                            </option>

                                            <option value="Téc. Enf."
                                                {{ $usuario->titulo_profesional == 'Téc. Enf.' ? 'selected' : '' }}>
                                                Téc. Enf.
                                            </option>

                                            <option value="Enf."
                                                {{ $usuario->titulo_profesional == 'Enf.' ? 'selected' : '' }}>
                                                Enfermero(a)
                                            </option>

                                            <option value="otros"
                                                {{
                                                    !in_array($usuario->titulo_profesional,
                                                    ['Dr.','Dra.','Obst.','Lic. Enf.','Téc. Enf.','Enf.'])
                                                    && $usuario->titulo_profesional
                                                    ? 'selected' : ''
                                                }}>
                                                Otros
                                            </option>

                                        </select>

                                    </div>

                                </div>



                                <!-- OTRO TITULO -->
                                <div class="col-md-3"
                                    id="divOtroTitulo"
                                    style="
                                    {{ 
                                    !in_array($usuario->titulo_profesional,
                                    ['Dr.','Dra.','Obst.','Lic. Enf.','Téc. Enf.','Enf.'])
                                    && $usuario->titulo_profesional
                                    ? ''
                                    : 'display:none;'
                                    }}">


                                    <div class="form-group">


                                        <label style="color:#4a5568">
                                            Especifique el título:
                                        </label>


                                        <input 
                                            type="text"
                                            name="otro_titulo"
                                            id="otroTitulo"
                                            class="form-control"
                                            value="{{ 
                                            !in_array($usuario->titulo_profesional,
                                            ['Dr.','Dra.','Lic.Enf.','Licda.Enf.','Mg.','Esp.','Téc.Enf.','Enf.'])
                                            ? $usuario->titulo_profesional
                                            : ''
                                            }}"
                                            placeholder="Ejemplo: PhD."
                                            style="border:1px solid #fdde92da;">


                                    </div>


                                </div>


                            </div>
                            <hr>
                                
                                
                              
                                
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{url($base.'/usuarios')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: Geneva, Tahoma, sans-serif;;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: Geneva, Tahoma, sans-serif;;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                        <b>Actualizar Usuario </b>
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
    const rol = document.getElementById('rol');

    const divEspecialidad = document.getElementById('divEspecialidad');
    const especialidad = document.getElementById('especialidad');

    const titulo = document.getElementById('titulo_profesional');
    const divOtroTitulo = document.getElementById('divOtroTitulo');
    const otroTitulo = document.getElementById('otroTitulo');


    function actualizarFormulario(){

        // Mostrar especialidad solo si es médico
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



        // Mostrar otro título
        if(titulo.value==="otros"){

            divOtroTitulo.style.display="block";
            otroTitulo.required=true;

        }else{

            divOtroTitulo.style.display="none";
            otroTitulo.required=false;
            otroTitulo.value="";

        }

    }



    rol.addEventListener('change', actualizarFormulario);

    titulo.addEventListener('change', actualizarFormulario);


    actualizarFormulario();
 </script>
@endsection

