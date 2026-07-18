@extends('layouts.Admin')

@section('content')

<style>
.upload-box {
    border: 2px dashed #f4d279;
    border-radius: 12px;
    padding: 25px;
    background: #fffdf7;
    display: flex;
    justify-content: center;
    align-items: center;
}

.preview-container img {
    width: 160px;
    height: 160px;
    object-fit: contain;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
</style>

<div class="row" style="display:flex; align-items:center; gap:10px;">
    <i class="bi bi-eye-fill" style="font-size:28px; color:#5f6b7a;"></i>
    <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568;">
        Información de Configuración:{{ $configuracion->nombre_puestosalud }}
    </h1>
</div>

<hr>

<div class="card card-outline" style="border-top:3px solid #f4d279;">
    <div class="card-header">
        <h3 class="card-title" style="font-size:12px; color:#6c757d;">
            Información registrada
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-8">

                <div class="row">

                    <div class="col-md-6">
                        <label style="color:#4a5568;">Nombre</label>
                        <input class="form-control"
                            value="{{ $configuracion->nombre_puestosalud }}"
                            readonly
                            style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                    </div>

                    <div class="col-md-6">
                        <label style="color:#4a5568;">Dirección</label>
                        <input class="form-control"
                            value="{{ $configuracion->direccion }}"
                            readonly
                            style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-6">
                        <label style="color:#4a5568;">Teléfono</label>
                        <input class="form-control"
                            value="{{ $configuracion->telefono }}"
                            readonly
                            style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                    </div>

                    <div class="col-md-6">
                        <label style="color:#4a5568;">Facebook</label>
                        <input class="form-control"
                            value="{{ $configuracion->facebook }}"
                            readonly
                            style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                    </div>

                </div>

            </div>

            <!-- LOGO -->
            <div class="col-md-4 text-center">

                <label style="color:#4a5568;">Logotipo</label>

                <div class="upload-box">

                    <div class="preview-container">

                        @if($configuracion->logo)
                            <img src="{{ asset('storage/'.$configuracion->logo) }}">
                        @else
                            <p>No hay imagen</p>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        <br>

        <div class="text-center">
            <a href="{{ url($base.'/configuraciones') }}"
               class="btn"
               style="background:#4a5568; color:white; width:200px;">
                Volver
            </a>
        </div>

    </div>
</div>

@endsection