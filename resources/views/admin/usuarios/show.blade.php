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
                                     <div class="col-md-4">
                                            <label style="color:#4a5568">Usuario:</label>

                                            <input type="text" value="{{$usuario->username }}" name="username"  class="form-control" id="" placeholder="Nombres" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">


                                            @error('username')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for="" style="color: #4a5568" >Nombres Completos:</label>
                                            <input type="text" value="{{$usuario->name }}" name="name"  class="form-control" id="" placeholder="Nombres" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                @error('name')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror        
                                        </div>
                                    </div>
                                     <!--Campo -Apellidos-->

                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for="" style="color: #4a5568">Apellidos Completos:</label>
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
                                        <label for=""  style="color: #4a5568">Correo Electrónico:</label>
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
                               @php
    $rol = $usuario->getRoleNames()->first();
@endphp

@if($rol == 'medico')

    {{-- =========================
         MÉDICO
         Primera fila:
         Estado | Rol | Especialidad | Título Profesional
    ========================== --}}
    <div class="row">

        <!-- Estado -->
        <div class="col-md-3">
            <div class="form-group">
                <label style="color:#4a5568;">Estado:</label>

                <input type="text"
                    value="{{ strtoupper($usuario->status) }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;cursor:not-allowed;">
            </div>
        </div>

        <!-- Rol -->
        <div class="col-md-3">
            <div class="form-group">
                <label style="color:#4a5568;">Rol:</label>

                <input type="text"
                    value="{{ strtoupper($rol) }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;cursor:not-allowed;">
            </div>
        </div>

        <!-- Especialidad -->
        <div class="col-md-3">
            <div class="form-group">
                <label style="color:#4a5568;">Especialidad:</label>

                <input type="text"
                    value="{{ strtoupper($usuario->specialty) }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;cursor:not-allowed;">
            </div>
        </div>

        <!-- Título -->
        <div class="col-md-3">
            <div class="form-group">
                <label style="color:#4a5568;">Título profesional:</label>

                <input type="text"
                    value="{{ $usuario->titulo_profesional }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
            </div>
        </div>

    </div>


    {{-- Segunda fila: Colegio Profesional --}}
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">

                <label style="color:#4a5568;">
                    Colegio Profesional:
                </label>

                <input type="text"
                    value="{{ $usuario->colegio_profesional }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;">

            </div>
        </div>

    </div>

@else

    {{-- =========================
         ADMINISTRADOR / ASISTENTE
         Una sola fila
         Estado | Rol | Título | Colegio
    ========================== --}}

    <div class="row">

        <!-- Estado -->
        <div class="col-md-3">
            <div class="form-group">

                <label style="color:#4a5568;">Estado:</label>

                <input type="text"
                    value="{{ strtoupper($usuario->status) }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;cursor:not-allowed;">

            </div>
        </div>

        <!-- Rol -->
        <div class="col-md-3">
            <div class="form-group">

                <label style="color:#4a5568;">Rol:</label>

                <input type="text"
                    value="{{ strtoupper($rol) }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;cursor:not-allowed;">

            </div>
        </div>

        <!-- Título -->
        <div class="col-md-3">
            <div class="form-group">

                <label style="color:#4a5568;">Título profesional:</label>

                <input type="text"
                    value="{{ $usuario->titulo_profesional }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;">

            </div>
        </div>

        <!-- Colegio -->
        <div class="col-md-3">
            <div class="form-group">

                <label style="color:#4a5568;">Colegio Profesional:</label>

                <input type="text"
                    value="{{ $usuario->colegio_profesional }}"
                    class="form-control"
                    readonly
                    style="background-color:#f6e48bb1;border:1px solid #fdde92da;">

            </div>
        </div>

    </div>

@endif
  
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

