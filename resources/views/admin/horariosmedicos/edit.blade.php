@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-plus" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                Actualizar Horario :{{ $horario->medico->name ?? '' }} {{ $horario->medico->surname ?? '' }}  
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
                    <form action="{{ url($base.'/horariosmedicos/'.$horario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                            
                                <div class="row">
                                      <!--Campo medico_asignado-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Medico Asignado:</label>
                                         <select name="medico_id" id="medicoSelect" class="form-control" style="border:1px solid #fdde92da;">
                                                @foreach($medicos as $medico)
                                                    <option
                                                        value="{{ $medico->id }}"
                                                        data-especialidad="{{ $medico->specialty }}"
                                                        {{ $medico->id == $horario->medico_id ? 'selected' : '' }}>
                                                        {{ $medico->name }} {{ $medico->surname }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        @error('medico_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="color:#4a5568">Especialidad:</label>
                                            <input type="text"
                                                id="especialidad"
                                                class="form-control"
                                                value="{{ $horario->medico->specialty ?? '' }}"
                                                readonly
                                                style="background-color:#fdde92da;border:1px solid #fdde92da;"">
                                        </div>
                                    </div>
                                   
                                    <!--Campo Dia-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Dia:</label>
                                            <select name="dia_semana" class="form-control" style="border:1px solid #fdde92da;">
                                                @foreach(['lunes','martes','miercoles','jueves','viernes','sabado'] as $dia)
                                                    <option value="{{ $dia }}"
                                                        {{ $horario->dia_semana == $dia ? 'selected' : '' }}>
                                                        {{ ucfirst($dia) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                                @error('dia_semana')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror        
                                        </div>
                                    </div>
                                    
                                    
                                    

                                </div>   
                                                          
                                <br>
                                
                                <div class="row">
                                    
                                     <!--Campo -Apellidos-->

                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Hora Inicio:</label>
                                            <input type="time" 
                                            name="hora_inicio"
                                            value="{{ old('hora_inicio', $horario->hora_inicio) }}"
                                            class="form-control" style="border:1px solid #fdde92da;">  
                                        </div>
                                    </div>

                                    
                                    <!--Campo correo hora fin-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Hora Fin:</label>
                                            <input type="time" 
                                                name="hora_fin"
                                                value="{{ old('hora_fin', $horario->hora_fin) }}"
                                                class="form-control" style="border:1px solid #fdde92da;">  
                                        </div>
                                    </div>


                                    

                                     
                                    
                                    

                                </div>
                                <br>                            
                                
                                

                              
                               
                               
                                <br>
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{url($base.'/horariosmedicos')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                        <b>Actualizar Horario</b>
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

    const medicoSelect = document.getElementById('medicoSelect');
    const especialidadInput = document.getElementById('especialidad');

    function actualizarEspecialidad() {

        const especialidad =
            medicoSelect.options[medicoSelect.selectedIndex]
            .getAttribute('data-especialidad');

        especialidadInput.value = especialidad || '';
    }

    actualizarEspecialidad();

    medicoSelect.addEventListener('change', actualizarEspecialidad);

});
</script>



    

@endsection

