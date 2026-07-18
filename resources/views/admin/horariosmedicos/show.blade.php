@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-eye" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                Informacion de Horario Medico:{{ $horario->medico->name ?? '' }} {{ $horario->medico->surname ?? '' }}  
        </h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    informacion de horario del medico

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
                        <form action="{{ url($base.'/horariosmedicos/create') }}" method="POST">
                            @csrf
                            
                                <div class="row">

                                    <!-- Médico -->
                                    <div class="col-md-4">
                                        <label>Médico:</label>
                                        <input type="text" disabled 
                                    value="{{ $horario->medico->name ?? '' }} {{ $horario->medico->surname ?? '' }}"                                        class="form-control"
                                        style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                                    </div>

                                    <!-- Especialidad -->
                                    <div class="col-md-4">
                                        <label>Especialidad:</label>
                                        <input type="text" disabled 
                                        value="{{ $horario->medico->specialty ?? '' }}"
                                        class="form-control"
                                        style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                                    </div>
                                

                                     <!-- Día -->
                                    <div class="col-md-4">
                                        <label>Día:</label>
                                        <input type="text" disabled 
                                        value="{{ $horario->dia_semana }}" 
                                        class="form-control"
                                        style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                                    </div>
                                     
                                    <!-- Hora inicio -->
                                    <div class="col-md-4">
                                        <label>Hora Inicio:</label>
                                        <input type="time" disabled 
                                        value="{{ $horario->hora_inicio }}" 
                                        class="form-control"
                                        style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                                    </div>

                                    <!-- Hora fin -->
                                    <div class="col-md-4">
                                        <label>Hora Fin:</label>
                                        <input type="time" disabled 
                                        value="{{ $horario->hora_fin }}" 
                                        class="form-control"
                                        style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                                    </div>
                                    

                                </div>   
                                                          
                     
                                
                                                                 
                                <br>
                                <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{url($base.'/horariosmedicos')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    
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

