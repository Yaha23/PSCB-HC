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
                                        <!--Campo usuario-->
                                        <div class="col-md-4">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568" >Nombre de Usuario:</label>
                                                <input type="text" value="{{old('name') }}" name="name"  class="form-control" id="" placeholder="Nombres" required   style=" border:1px solid #fdde92da;">
                                                    @error('name')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror        
                                            </div>
                                        </div>
                                        <!--Campo -Apellidos-->

                                        <div class="col-md-4">
                                            <div class="form ground">
                                            <label for=""  style="color: #4a5568">Apellidos:</label>
                                                <input type="text" value="{{old('surname') }}" name="surname" class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;"  >
                                                    @error('surname')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>

                                        <!--Campo correo electronico-->
                                        <div class="col-md-4">
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
                                        <!--Campo estado de la cuenta Activa o Inactiva--> 
                                        <div class="col-md-4">
                                        <div class="form-group">
                                                <label style="color: #4a5568">Estado:</label>
                                                <select name="status" value="{{old('status') }}" class="form-control" data-gtm-form-interact-field-id="0" required style=" border:1px solid #fdde92da;" >
                                                    <option value="" disabled selected>Ninguno</option>
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                                    @error('status')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>
                                        <!--Campo Rol medico,administrador o asistente--> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="color: #4a5568">Rol:</label>
                                                <select value="{{old('role') }}" name="role" class="form-control" id="rol" data-gtm-form-interact-field-id="0" required style=" border:1px solid #fdde92da;" >
                                                    <option value="" disabled selected>Ninguno</option>
                                                    <option value="admin">Administrador</option>
                                                    <option value="asistente">Asistente</option>
                                                    <option value="medico">Medico</option>

                                                </select>
                                                    @error('role')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>
                                        <!--campo especialidad-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="color: #4a5568">Especialidad:</label>
                                                    <select value="{{old('specialty') }}" name="specialty" id="especialidad" class="form-control"  disabled="" required style=" border:1px solid #fdde92da;" >                                       
                                                    <option value="" disabled selected >Seleccione</option>
                                                    <option value="medicina general">Medicina general</option>
                                                    <option value="obstetricia">Obstetricia</option>
                                                
                                                </select>
                                                    @error('specialty')
                                                        <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            
                                            </div>
                                        </div>


                                    </div>
                                    
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
                    
                document.getElementById('rol').addEventListener('change', function () {

                    let especialidad = document.getElementById('especialidad');

                    // Siempre desactivado por defecto
                    especialidad.disabled = true;
                    especialidad.value = "";

                    // SOLO si es médico → activar
                    if (this.value === 'medico') {
                        especialidad.disabled = false;
                    }

                });
            </script>



        @else
            <div class="alert alert-danger">
                No tienes permisos para acceder a esta página.
            </div>
        @endcan

    

    

        
        

    @endsection

