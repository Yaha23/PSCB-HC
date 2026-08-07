@extends('layouts.Admin')

@section('content')

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-pencil-square" style="font-size:28px; color:#5f6b7a;"></i>

        <h1 style="margin:0;font-size:26px;font-weight:500;color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">

            Actualizar Paciente:{{ $paciente->nombres }} {{ $paciente->apellidos }}

        </h1>

    </div>

    <hr>

    <div class="row">

        <div class="col-md-12">

            <div class="card card-outline" style="border-top: 3px solid #f4d279;">

                <div class="card-header">

                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                        Modifique los datos del paciente
                        <i class="bi bi-pen-fill" style="margin-left:10px; color:#9aa0a6;"></i>
                    </h3>

                </div>

                <div class="card-body">

                    <form action="{{ route($base.'.pacientes.update', $paciente->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            
                            <div class="row">

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Nombres del Paciente:
                                        </label>

                                        <input type="text" name="nombres" value="{{ old('nombres', $paciente->nombres) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('nombres')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Apellidos del Paciente:
                                        </label>

                                        <input type="text" name="apellidos" value="{{ old('apellidos', $paciente->apellidos) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('apellidos')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">
                                        <label style="color:#4a5568;">
                                            DNI:
                                        </label>

                                        <input type="text" name="DNI" value="{{ old('DNI', $paciente->DNI) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('DNI')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Fecha de Nacimiento:
                                        </label>

                                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('fecha_nacimiento')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                            <br>

                            <div class="row">

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Correo Electrónico:
                                        </label>

                                        <input type="email"
                                            name="email" value="{{ old('email', $paciente->email) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('email')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Género:
                                        </label>

                                        <select name="genero" class="form-control" required style="border:1px solid #fdde92da;">

                                            <option value="masculino"
                                                {{ $paciente->genero == 'masculino' ? 'selected' : '' }}>
                                                Masculino
                                            </option>

                                            <option value="femenino"
                                                {{ $paciente->genero == 'femenino' ? 'selected' : '' }}>
                                                Femenino
                                            </option>

                                        </select>

                                        @error('genero')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Estado Civil:
                                        </label>


                                        <select name="estado_civil" class="form-control" required style="border:1px solid #fdde92da;">


                                            <option value="" disabled>
                                                Seleccione
                                            </option>


                                            <option value="soltero"
                                                {{ $paciente->estado_civil == 'soltero' ? 'selected' : '' }}>
                                                Soltero(a)
                                            </option>


                                            <option value="casado"
                                                {{ $paciente->estado_civil == 'casado' ? 'selected' : '' }}>
                                                Casado(a)
                                            </option>


                                            <option value="conviviente"
                                                {{ $paciente->estado_civil == 'conviviente' ? 'selected' : '' }}>
                                                Conviviente
                                            </option>


                                            <option value="divorciado"
                                                {{ $paciente->estado_civil == 'divorciado' ? 'selected' : '' }}>
                                                Divorciado(a)
                                            </option>


                                            <option value="viudo"
                                                {{ $paciente->estado_civil == 'viudo' ? 'selected' : '' }}>
                                                Viudo(a)
                                            </option>


                                            <option value="separado"
                                                {{ $paciente->estado_civil == 'separado' ? 'selected' : '' }}>
                                                Separado(a)
                                            </option>


                                        </select>


                                        @error('estado_civil')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror


                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Teléfono:
                                        </label>

                                        <input type="text" name="celular" value="{{ old('celular', $paciente->celular) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('celular')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                            <br>

                            <div class="row">

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Dirección:
                                        </label>

                                        <input type="text" name="direccion" value="{{ old('direccion', $paciente->direccion) }}" class="form-control" required style="border:1px solid #fdde92da;">

                                        @error('direccion')
                                            <small style="color:red">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                                @php
                                    $gruposNormales = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
                                    $esOtroGrupo = !in_array($paciente->grupo_sanguineo, $gruposNormales);
                                @endphp

                            
                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Grupo Sanguíneo:
                                        </label>

                                        <select
                                            name="grupo_sanguineo" id="grupo_sanguineo" class="form-control" required style="border:1px solid #fdde92da;">

                                            @foreach($gruposNormales as $grupo)

                                                <option value="{{ $grupo }}"
                                                    {{ !$esOtroGrupo && $paciente->grupo_sanguineo == $grupo ? 'selected' : '' }}>
                                                    {{ $grupo }}
                                                </option>

                                            @endforeach

                                            <option value="otros" {{ $esOtroGrupo ? 'selected' : '' }}>
                                                Otros
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            
                                <div class="col-md-3 {{ $esOtroGrupo ? '' : 'd-none' }}" id="divOtroGrupo">

                                    <div class="form-group">

                                        <label style="color:#4a5568;">
                                            Especifique el grupo sanguíneo:
                                        </label>

                                        <input type="text" name="otro_grupo_sanguineo" id="otro_grupo_sanguineo" class="form-control" value="{{ $esOtroGrupo ? $paciente->grupo_sanguineo : '' }}" placeholder="Grupo Sanguineo" style="border:1px solid #fdde92da;">

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="row">

                                <div class="col-md-12 text-center">

                                    <a href="{{ url($base.'/pacientes') }}"class="btn btn-secondary" style="background-color:#4a5568;width:200px;font-size:16px;border-radius:6px;">
                                        Cancelar
                                    </a>

                                    <button type="submit" class="btn" style="background-color:#f4d279; width:280px; font-size:16px;border-radius:6px;color:#4a5568;">
                                        <b>Actualizar Paciente</b>
                                    </button>

                                </div>

                            </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>

        const grupo = document.getElementById('grupo_sanguineo');
        const divOtroGrupo = document.getElementById('divOtroGrupo');
        const otroGrupo = document.getElementById('otro_grupo_sanguineo');

        function mostrarOcultarGrupo() {

            if (grupo.value === 'otros') {

                divOtroGrupo.classList.remove('d-none');
                otroGrupo.required = true;

            } else {

                divOtroGrupo.classList.add('d-none');
                otroGrupo.required = false;
                otroGrupo.value = '';

            }

        }

            grupo.addEventListener('change', mostrarOcultarGrupo);

            mostrarOcultarGrupo();

    </script>

@endsection