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
                        <form action="{{ route($base.'.horariosmedicos.store') }}" method="POST">
                            @csrf
                            
                                <div class="row">
                                      <!--Campo medico_asignado-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Medico Asignado:</label>
                                          <select name="medico_id" id="medico_id" class="form-control" style=" border:1px solid #fdde92da;" >
                                            <option value="">Seleccione</option>

                                            @foreach($medicos as $medico)
                                                <option 
                                                        value="{{ $medico->id }}"
                                                        data-especialidad="{{ strtolower($medico->specialty) }}"
                                                    >
                                                        {{ $medico->name }} {{ $medico->surname }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('medico_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror    
                                        </div>
                                    </div>
                                     <!--campo especialidad-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  style="color: #4a5568">Especialidad:</label>
                                            <select name="especialidad" id="especialidad" class="form-control" required style=" border:1px solid #fdde92da;">
                                                <option value="" disabled selected>Seleccione</option>
                                                <option value="medicina general">Medicina general</option>
                                                <option value="obstetricia">Obstetricia</option>
                                            </select>
                                                @error('especialidad')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        
                                        </div>
                                    </div>
                                    <!--Campo Dia-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568" >Dia:</label>
                                            <select name="dia_semana" value="{{old('dia_semana') }}" class="form-control" data-gtm-form-interact-field-id="0" required style=" border:1px solid #fdde92da;"required >
                                                    <option value="" disabled selected>Ninguno</option>
                                                    <option value="lunes">Lunes</option>
                                                    <option value="martes">Martes</option>
                                                    <option value="miercoles">Miercoles</option>
                                                    <option value="jueves">Jueves</option>
                                                    <option value="viernes">Viernes</option>
                                                    <option value="sabado">Sabado</option>

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
                                            <input type="time" value="{{old('hora_inicio') }}" name="hora_inicio" class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;"  >
                                                @error('hora_inicio')
                                                <small style="color:red">{{ $message }}</small>                                               
                                                @enderror    
                                        </div>
                                    </div>

                                    
                                    <!--Campo correo hora fin-->
                                    <div class="col-md-4">
                                        <div class="form ground">
                                        <label for=""  style="color: #4a5568">Hora Fin:</label>
                                            <input type="time" value="{{old('hora_fin') }}" name="hora_fin" class="form-control" id="" placeholder="Apellidos" required  style=" border:1px solid #fdde92da;"  >
                                                @error('hora_fin')
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
                                                <a href="{{ url($base.'/horariosmedicos') }}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
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

            const medicoSelect = document.getElementById('medico_id');
            const especialidadSelect = document.getElementById('especialidad');

            medicoSelect.addEventListener('change', function () {

                let especialidad = this.options[this.selectedIndex].dataset.especialidad;

                if (!especialidad) return;

                // recorrer opciones de especialidad
                for (let i = 0; i < especialidadSelect.options.length; i++) {

                    if (especialidadSelect.options[i].value === especialidad) {
                        especialidadSelect.selectedIndex = i;
                        break;
                    }
                }

            });

        });
        </script>



    

@endsection

