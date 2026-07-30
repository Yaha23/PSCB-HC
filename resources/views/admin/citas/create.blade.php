@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-plus" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                Registrar Cita 
        </h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    Ingrese los datos requeridos y registre una nueva cita

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
                        <form action="{{ route($base.'.citas.store') }}" method="POST">
                            @csrf
                            
                                <div class="row">
                                      <!--Campo medico_asignado-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Paciente:</label>
                                          <select name="paciente_id"  class="form-control" style=" border:1px solid #fdde92da;" required >
                                            <option value=""disabled selected>Seleccione Paciente</option>

                                             @foreach($pacientes as $paciente)
                                                <option value="{{ $paciente->id }}">
                                                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('paciente_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror    
                                        </div>
                                    </div>
                                     <!--campo medico-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  style="color: #4a5568">Medico:</label>
                                            <select name="medico_id"  id="medico_id" class="form-control" required style=" border:1px solid #fdde92da;" required >
                                                <option value="" disabled selected>Seleccione Médico</option>
                                                @foreach($medicos as $medico)
                                                    <option
                                                        value="{{ $medico->id }}"
                                                        data-especialidad="{{ $medico->specialty }}"
                                                    >
                                                        {{ $medico->titulo_profesional ?? '' }}
                                                        {{ $medico->name }}
                                                        {{ $medico->surname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                                @error('medico_id')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        
                                        </div>
                                    </div>
                                    <!-- Especialidad -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="color:#4a5568">Especialidad:</label>

                                            <input type="text"
                                                id="especialidad"
                                                class="form-control"
                                                readonly
                                                style="border:1px solid #fdde92da; background-color:#fdde92da;text-transform:uppercase;">
                                        </div>
                                    </div>
                                   
                                    
                                    

                                </div>   
                                                          
                                <br>
                                
                                <div class="row">
                                     <!--Hora-->
                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Fecha :</label>
                                            <input type="date"  name="fecha"class="form-control" id="" placeholder="fecha de atencion" required  style=" border:1px solid #fdde92da;" required >
                                                @error('fecha')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>
                                    
                                    
                                     <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Hora :</label>
                                            <input type="time"  name="hora"class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;" required >
                                                @error('hora')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                     <!--Campo -Motivo-->

                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Motivo:</label>
                                            <input type="text" value="{{old('motivo') }}" name="motivo" class="form-control" id="" placeholder="motivo de atencion" required  style=" border:1px solid #fdde92da;" required >
                                                @error('motivo')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                    

                                    
                                    
                                 

                                    

                                     
                                    
                                    

                                </div>
                                <br>                            
                                
                                

                              
                               
                               
                                <br>
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{ route($base.'.citas.index') }}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                        <b>Registrar Cita</b>
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

        const medicoSelect = document.getElementById('medico_id');
        const especialidad = document.getElementById('especialidad');

        medicoSelect.addEventListener('change', function () {

            const opcion = this.options[this.selectedIndex];

            especialidad.value = opcion.dataset.especialidad || '';

        });

    });
    </script>

 @endsection

