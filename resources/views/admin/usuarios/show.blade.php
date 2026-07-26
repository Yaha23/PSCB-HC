@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-fill" style="font-size:28px; color:#85a2c5;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family: Geneva, Tahoma, sans-serif;">
               Informacion del Usuario: {{ $usuario->name }} {{ $usuario->surname }}
        </h1>
    </div>

    

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    Datos del usuario registrado
                    <i class="bi bi-file-earmark-person-fill" style="margin-left:10px; color:#9aa0a6;"></i>
                    
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
                        <form action="{{ url($base.'/usuarios/create') }}" method="POST">
                            @csrf
                            
                                <div class="row">
                                    <!--Campo usuario-->
                                    <div class="col-md-6">
                                        <div class="form ground">
                                        <label for="" style="color: #4a5568" >Nombre de Usuario:</label>
                                            <input type="text" value="{{$usuario->name }}" name="name"  class="form-control" id="" placeholder="Nombres" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                @error('name')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror        
                                        </div>
                                    </div>
                                     <!--Campo -Apellidos-->

                                     <div class="col-md-6">
                                        <div class="form ground">
                                        <label for="" style="color: #4a5568">Apellidos:</label>
                                            <input type="text" value="{{$usuario->surname }}" name="surname" class="form-control" id="" placeholder="Apellidos" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                @error('surname')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                   

                                </div>
                                
                                
                                <br>
                                
                                <div class="row">
                                     <!--Campo correo electronico-->
                                      <div class="col-md-6">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Email:</label>
                                            <input type="email" value="{{$usuario->email }}" name="email" class="form-control" id="" placeholder="Correo electronico" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                @error('email')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>
                                     <!--Campo telefono-->
                                    <div class="col-md-6">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Telefono:</label>
                                            <input type="cel" value="{{$usuario->phone }}" name="phone" class="form-control" id="" placeholder="Telefono" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                @error('phone')
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
                                    <div class="col-md-3">
                                    <div class="form-group">
                                            <label  style="color: #4a5568">Estado:</label>
                                    <input type="text" value="{{$usuario->status }}" name="status" class="form-control" id="" placeholder="Telefono" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;text-transform:uppercase;">
 
                                                @error('status')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>
                                    <!--Campo Rol medico,administrador o asistente--> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label  style="color: #4a5568">Rol:</label>
                                                @php
                                                    $rol = $usuario->getRoleNames()->first();
                                                @endphp

                                                <input type="text" value="{{$usuario->role }}" name="role" class="form-control" id="" placeholder="Telefono" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;text-transform:uppercase;">

                                            
                                                @error('role')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>
                                    <!--campo especialidad-->
                                   
                                    @php
                                        $rol = $usuario->getRoleNames()->first();
                                    @endphp


                                    @if($rol == 'medico')

                                    <div class="col-md-3" id="divEspecialidad">

                                        <div class="form-group">

                                            <label style="color:#4a5568;">
                                                Especialidad:
                                            </label>


                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ $usuario->specialty }}"
                                                disabled
                                                style="
                                                background-color:#f6e48bb1;
                                                border:1px solid #fdde92da;
                                                cursor:not-allowed;text-transform:uppercase;"
                                            >

                                        </div>

                                    </div>

                                    @endif
                                   
                                <div class="col-md-3">

                                        <div class="form-group">

                                            <label style="color:#4a5568;">
                                                 Título profesional:
                                            </label>

                                            <input type="text"
                                                value="{{ $usuario->titulo_profesional }}"
                                                class="form-control"
                                                readonly
                                                style="background-color:#f6e48bb1;
                                                        border:1px solid #fdde92da;">

                                        </div>

                                    </div>
                                </div>

                          
                                <hr>
                               
                                

                                </div>
                                
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                        <a href="{{url($base.'/usuarios')}}"  class="btn btn-secondary"  style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                <b>Volver</b>
                                        </a>
                                           
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <br>


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


    

@endsection

