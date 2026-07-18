@extends('layouts.Admin')

@section('content')

@php
    $base = auth()->user()->hasRole('admin') ? 'admin' :
            (auth()->user()->hasRole('asistente') ? 'asistente' : 'medico');

    $consulta = $paciente->consultas->first();
@endphp

<div style="display:flex; justify-content:space-between; align-items:center; width:100%;">

    {{-- TITULO --}}
    <div style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-trash-fill"
           style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0;
                   font-size:26px;
                   font-weight:500;
                   color:#4a5568;
                   font-family:'Segoe UI', Tahoma, sans-serif;">

            Eliminar Paciente:
            {{ $paciente->nombres }}
            {{ $paciente->apellidos }}

        </h1>

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-12">

        <div class="card card-outline"
             style="border-top:3px solid #f4d279;">

            {{-- HEADER --}}
            <div class="card-header">

                <h3 class="card-title d-flex align-items-center"
                    style="font-size:12px;
                           color:#6c757d;
                           font-weight:500;">

                    Confirmación de eliminación del paciente

                    <i class="bi bi-exclamation-triangle-fill"
                       style="margin-left:10px; color:#9aa0a6;"></i>

                </h3>

            </div>

            {{-- BODY --}}
            <div class="card-body">

                <form action="{{ route($base.'.pacientes.destroy', $paciente->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    {{-- FILA 1 --}}
                    <div class="row">

                        {{-- NOMBRES --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Nombres
                                </label>

                                <input type="text"
                                       value="{{ $paciente->nombres }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- APELLIDOS --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Apellidos
                                </label>

                                <input type="text"
                                       value="{{ $paciente->apellidos }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- DNI --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    DNI
                                </label>

                                <input type="text"
                                       value="{{ $paciente->DNI }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- FECHA NACIMIENTO --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Fecha Nacimiento
                                </label>

                                <input type="date"
                                       value="{{ $paciente->fecha_nacimiento }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                    </div>

                    <br>

                    {{-- FILA 2 --}}
                    <div class="row">

                        {{-- EMAIL --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Email
                                </label>

                                <input type="email"
                                       value="{{ $paciente->email }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- GENERO --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Género
                                </label>

                                <input type="text"
                                       value="{{ ucfirst($paciente->genero) }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- ESTADO CIVIL --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Estado Civil
                                </label>

                                <input type="text"
                                       value="{{ ucfirst($paciente->estado_civil) }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                    </div>

                    <br>

                    {{-- FILA 3 --}}
                    <div class="row">

                        {{-- CELULAR --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Celular
                                </label>

                                <input type="text"
                                       value="{{ $paciente->celular }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- DIRECCION --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Dirección
                                </label>

                                <input type="text"
                                       value="{{ $paciente->direccion }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                        {{-- GRUPO SANGUINEO --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label style="color:#4a5568;">
                                    Grupo Sanguíneo
                                </label>

                                <input type="text"
                                       value="{{ strtoupper($paciente->grupo_sanguineo) }}"
                                       class="form-control"
                                       readonly
                                       style="background-color:#f6e48bb1;
                                              border:1px solid #fdde92da;
                                              cursor:not-allowed;">

                            </div>

                        </div>

                    </div>

                    <hr>

                    {{-- BOTONES --}}
                    <!--Boton cancelar y Guardar datos-->
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-ground">
                                                    <a href="{{url($base.'/pacientes')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                            Cancelar
                                                    </a>
                                                        <button type="submit" class="btn" style="background-color: #f4d279; width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                        <b> Eliminar Paciente </b>
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