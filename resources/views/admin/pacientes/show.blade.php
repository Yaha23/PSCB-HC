@extends('layouts.Admin')

@section('content')

    @php
        $base = auth()->user()->hasRole('admin') ? 'admin' :
                (auth()->user()->hasRole('asistente') ? 'asistente' : 'medico');
    @endphp

    <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">

    
        <div style="display:flex; align-items:center; gap:10px;">

            <i class="bi bi-person-vcard-fill"
            style="font-size:28px; color:#5f6b7a;"></i>

            <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568;font-family:'Segoe UI', Tahoma, sans-serif;">
                Información del Paciente: {{ $paciente->nombres }} {{ $paciente->apellidos }}
            </h1>

        </div>

            <a href="{{ url($base.'/pacientes') }}" class="btn" style="background:#4a5568;color:white; border-radius:6px; padding:8px 14px;">
                Volver
            </a>

    </div>

    <hr>

    <div class="row">

        <div class="col-md-12">

            <div class="card card-outline"
                style="border-top:3px solid #f4d279;">

                <div class="card-header">

                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                        Datos del paciente registrado
                        <i class="bi bi-person-fill" style="margin-left:10px; color:#9aa0a6;"></i>

                    </h3>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Nombres del Paciente: </label>
                                <input type="text" value="{{ $paciente->nombres }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Apellidos del Paciente: </label>
                                <input type="text" value="{{ $paciente->apellidos }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color:#4a5568;">DNI: </label>
                                <input type="text" value="{{ $paciente->DNI }}" class="form-control" readonly  style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Fecha de Nacimiento:</label>
                                <input type="date" value="{{ $paciente->fecha_nacimiento }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                    </div>

                    <br>
                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label style="color:#4a5568;"> Correo Electrónico: </label>
                                <input type="email" value="{{ $paciente->email }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Género: </label>
                                <input type="text" value="{{ ucfirst($paciente->genero) }}" class="form-control" readonly style="background-color:#f6e48bb1;border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label style="color:#4a5568;"> Estado Civil: </label>
                                <input type="text" value="{{ ucfirst($paciente->estado_civil) }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                    </div>
                    <br>
                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label style="color:#4a5568;"> Teléfono:</label>
                                <input type="text" value="{{ $paciente->celular }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Dirección:</label>
                                <input type="text" value="{{ $paciente->direccion }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="color:#4a5568;"> Grupo Sanguíneo:</label>
                                <input type="text" value="{{ strtoupper($paciente->grupo_sanguineo) }}" class="form-control" readonly style="background-color:#f6e48bb1; border:1px solid #fdde92da;">
                            </div>

                        </div>

                    </div>

                    <hr>
                    <div class="row">

                        <div class="col-md-12 text-center">
                            <a href="{{ route($base.'.consultas.index', $paciente->id) }}" class="btn" style="background-color:#f4d279; color:#4a5568; width:250px; font-size:16px;border-radius:6px;">
                                <i class="bi bi-clipboard2-pulse-fill"></i>
                                <b>Atenciones del paciente</b>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection