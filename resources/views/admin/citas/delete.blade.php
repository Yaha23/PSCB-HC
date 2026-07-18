@extends('layouts.Admin')

@section('content')

<div class="row" style="display:flex; align-items:center; gap:10px;">
    <i class="bi bi-eye" style="font-size:28px; color:#5f6b7a;"></i>
    <h1 style="margin:0; font-size:26px; color:#4a5568;">
        Eliminar Cita Medita
    </h1>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline" style="border-top: 3px solid #f4d279;">
            
            <div class="card-body">
                <form action="{{ url($base.'/citas', $cita->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                              <div class="row">

                    <!-- PACIENTE -->
                    <div class="col-md-4">
                        <label  style="color: #4a5568">Paciente:</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $cita->paciente->nombres ?? '' }} {{ $cita->paciente->apellidos ?? '' }}"
                               disabled style="background-color: #f6e48bb1; border:1px solid #fdde92da;">
                    </div>

                    <!-- MEDICO -->
                    <div class="col-md-4">
                        <label  style="color: #4a5568">Médico:</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $cita->medico->name ?? '---' }}   {{ $cita->medico->surname ?? '' }}"
                               disabled style="background-color: #f6e48bb1; border:1px solid #fdde92da;">
                    </div>

                    <!-- FECHA -->
                    <div class="col-md-4">
                        <label  style="color: #4a5568" >Fecha:</label>
                        <input type="text"
                               class="form-control"
                               value="{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}"
                               disabled style="background-color: #f6e48bb1; border:1px solid #fdde92da;">
                    </div>

                </div>

                <br>

                <div class="row">

                    <!-- HORA -->
                    <div class="col-md-4">
                        <label  style="color: #4a5568">Hora:</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $cita->hora }}"
                               disabled style="background-color: #f6e48bb1; border:1px solid #fdde92da;">
                    </div>

                    <!-- MOTIVO -->
                    <div class="col-md-4">
                        <label  style="color: #4a5568">Motivo:</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $cita->motivo }}"
                               disabled style="background-color: #f6e48bb1; border:1px solid #fdde92da;">
                    </div>

                </div>

                <br>
                 <!--Boton cancelar y Guardar datos-->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-ground">
                                                <a href="{{url($base.'/citas')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                        Cancelar
                                                </a>
                                                    <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                        <b>Eliminar Cita</b> 
                                                    </button>
                                        </div>
                                    </div>
                                </div>

                </form>


                    

            </div>
        </div>
    </div>
</div>

@endsection