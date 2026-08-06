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
        <i class=" bi bi-gear"" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568;">
            Eliminar Configuración:{{ $configuracion->nombre_puestosalud }}
        </h1>
    </div>

    <hr>

    <div class="card card-outline" style="border-top:3px solid #f4d279;">
        <div class="card-header">
            <h3 class="card-title" style="font-size:12px; color:#6c757d;">
                Esta seguro que quiere eliminar esta Configuración 
            </h3>
        </div>

        <div class="card-body">

            <form action="{{ url($base.'/configuraciones/'.$configuracion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')

                <div class="row">

                    <div class="col-md-8">

                        <div class="row">

                            <div class="col-md-6">
                                <label style="color:#4a5568;">Nombre</label>
                                <input class="form-control" value="{{ $configuracion->nombre_puestosalud }}" readonly style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                            </div>

                            <div class="col-md-6">
                                <label style="color:#4a5568;">Dirección</label>
                                <input class="form-control" value="{{ $configuracion->direccion }}" readonly style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-md-6">
                                <label style="color:#4a5568;">Teléfono</label>
                                <input class="form-control" value="{{ $configuracion->telefono }}" readonly style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                            </div>

                            <div class="col-md-6">
                                <label style="color:#4a5568;">Facebook</label>
                                <input class="form-control" value="{{ $configuracion->facebook }}" readonly style="background-color: #f6e48bb1;border:1px solid #f4d279;">
                            </div>

                        </div>

                    </div>

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

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-ground">
                                    <a href="{{url($base.'/configuraciones')}}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                            Cancelar
                                    </a>
                                        <button type="submit" class="btn" style="background-color: #f4d279; width: 280px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                            <b>Eliminar Configuracion</b> 
                                        </button>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>

@endsection