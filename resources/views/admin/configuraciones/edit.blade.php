@extends('layouts.Admin')

@section('content')

    <style>
        .upload-box {
            border: 2px dashed #f4d279;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background-color: #fffdf7;
            transition: 0.3s;
            cursor: pointer;
        }

        .upload-box:hover {
            background-color: #fff8dc;
            border-color: #e6c45c;
        }

        .preview-container img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
    </style>

    <div class="row" style="display:flex; align-items:center; gap:10px;">
        <i class="bi bi-pencil-square" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568;">
            {{ $configuracion->nombre_puestosalud }}
        </h1>
    </div>

    <hr>

    <div class="card card-outline" style="border-top: 3px solid #f4d279;">
        <div class="card-header">
            <h3 class="card-title" style="font-size:12px; color:#6c757d;">
                Modifica los datos del sistema
            </h3>
        </div>

        <div class="card-body">

            <form action="{{ url($base.'/configuraciones/'.$configuracion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-8">

                        <div class="row">

                            <div class="col-md-6">
                                <label  style="color: #4a5568" >Nombre:</label>
                                <input type="text" name="nombre_puestosalud"
                                    value="{{ $configuracion->nombre_puestosalud }}"
                                    class="form-control" style="border:1px solid #f4d279;">
                            </div>

                            <div class="col-md-6">
                                <label  style="color: #4a5568" >Dirección:</label>
                                <input type="text" name="direccion" value="{{ $configuracion->direccion }}" class="form-control" style="border:1px solid #f4d279;">
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-md-6">
                                <label  style="color: #4a5568">Teléfono:</label>
                                <input type="text" name="telefono" value="{{ $configuracion->telefono }}" class="form-control" style="border:1px solid #f4d279;">
                            </div>

                            <div class="col-md-6">
                                <label  style="color: #4a5568">Facebook:</label>
                                <input type="text" name="facebook" value="{{ $configuracion->facebook }}" class="form-control" style="border:1px solid #f4d279;">
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 text-center">

                        <label  style="color: #4a5568">Logotipo:</label>

                        <div class="upload-box">

                            <div class="preview-container mb-2">
                                <img id="preview"  src="{{  $configuracion->logo ? asset('storage/'.$configuracion->logo) : asset('image/PSCB.png') }}">
                            </div>

                            <input type="file" name="logo" id="file" class="form-control" accept="image/*">

                            <script>
                                document.getElementById('file').addEventListener('change', function(e) {

                                const file = e.target.files[0];

                                if (!file) return;

                                if (!file.type.startsWith('image/')) {
                                    alert('Solo se permiten imágenes');
                                    return;
                                }

                                const reader = new FileReader();

                                reader.onload = function(e) {
                                    const preview = document.getElementById('preview');

                                    preview.src = e.target.result; 
                                }

                                    reader.readAsDataURL(file);
                                });
                            </script>

                        </div>

                    </div>

                </div>
                <br>
                <hr>
                <div class="text-center">

                    <button type="submit" class="btn" style="background:#f4d279; width:220px; color:#4a5568;">
                            <b>Actualizar Configuracion</b>
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection