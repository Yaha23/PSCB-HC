
@extends('layouts.Admin')

@section('content')

    @can('admin.usuarios.destroy')

        <div class="row" style="display:flex; align-items:center; gap:10px;">

            <i class="bi bi-person-exclamation" style="font-size:28px; color:#5f6b7a;"></i>
            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                    Eliminar: {{ $usuario->name }} {{ $usuario->surname }}
            </h1>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                    <div class="card-header">
                        <h3 class="card-title d-flex align-items-center" style="font-size:15px; color:#6c757d; font-weight:500;">
                        ¿Estas seguro de eliminar el usuario?

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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url($base.'/usuarios',$usuario->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                
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
                                    <h3 class="card-title d-flex align-items-center" style="font-size:15px; color:#6c757d; font-weight:500;">
                                        Indica el tipo y estado de la cuenta
                                        <i class="bi bi-check-all" style="margin-left:10px; color:#9aa0a6;"></i>                
                                    </h3>
                                <br>
                                    <div class="row">
                                        <!--Campo estado de la cuenta Activa o Inactiva--> 
                                        <div class="col-md-4">
                                        <div class="form-group">
                                                <label  style="color: #4a5568">Estado:</label>
                                                <select name="status" class="form-control" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                    <option disabled>Ninguno</option>
                                                    <option value="activo" {{ $usuario->status == 'activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="inactivo" {{ $usuario->status == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                                    @error('status')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>
                                        <!--Campo Rol medico,administrador o asistente--> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Rol:</label>
                                                <select name="role" class="form-control" id="rol" disabled     style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;">
                                                    <option disabled>Ninguno</option>
                                                <option value="admin" {{ $usuario->hasRole('admin') ? 'selected' : '' }}>Administrador</option>
                                                    <option value="asistente" {{ $usuario->hasRole('asistente') ? 'selected' : '' }}>Asistente</option>
                                                    <option value="medico" {{ $usuario->hasRole('medico') ? 'selected' : '' }}>Medico</option>
                                                </select>
                                                    @error('role')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                    @enderror    
                                            </div>
                                        </div>
                                        <!--campo especialidad-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Especialidad:</label>
                                                    <select name="specialty" id="especialidad" class="form-control" {{ $usuario->hasRole('medico') ? '' : 'disabled' }} disabled  style="background-color: #f6e48bb1; border:1px solid #fdde92da; cursor:not-allowed;" >

                                                        <option value="" disabled 
                                                            {{ $usuario->role != 'medico' ? 'selected' : '' }}>
                                                            Seleccione
                                                        </option>

                                                        <option value="Medicina general"
                                                            {{ $usuario->hasRole('medico') && $usuario->specialty == 'Medicina general' ? 'selected' : '' }}>
                                                            Medicina general
                                                        </option>

                                                        <option value="Obstetricia"
                                                            {{ $usuario->hasRole('medico') && $usuario->specialty == 'Obstetricia' ? 'selected' : '' }}>
                                                            Obstetricia
                                                        </option>

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
                                                        <b> Eliminar usuario </b>
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
        <div class="alert alert-danger m-3">
            No tienes permisos para eliminar usuarios.
        </div>
    @endcan


    

@endsection

