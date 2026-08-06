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

        .upload-content {
            display: block;
        }

        .preview-container {
            display: none;
            margin-top: 10px;
        }

        .preview-container img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
    </style>

    <div class="row" style="display:flex; align-items:center; gap:10px;">

        <i class="bi bi-person-plus" style="font-size:28px; color:#5f6b7a;"></i>
        <h1 style="margin:0; font-size:26px; font-weight:500; color:#4a5568; font-family:'Segoe UI', Tahoma, sans-serif;">
                Registrar configuración 
        </h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline" style="border-top: 3px solid #f4d279;">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center" style="font-size:12px; color:#6c757d; font-weight:500;">
                    Ingrese los datos para una nueva configuración
                    <i class="bi bi-pen-fill" style="margin-left:10px; color:#9aa0a6;"></i>
                    
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>

                    <div class="card-body">
                        <form action="{{ route($base.'.configuraciones.store') }}" method="POST" enctype="multipart/form-data">                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Nombre:</label>
                                                <input type="text"  name="nombre_puestosalud"class="form-control" id="" placeholder="nombre" required  style=" border:1px solid #fdde92da;"  >
                                                                                                                                        
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Direccion:</label>
                                                <input type="text"  name="direccion"class="form-control" id="" placeholder=" direccion" required  style=" border:1px solid #fdde92da;"  >
                                                @error('direccion')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                @enderror       
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Telefono:</label>
                                                <input type="text"  name="telefono"class="form-control" id="" placeholder="telefono" required  style=" border:1px solid #fdde92da;"  >
                                                                                                                                        
                                            </div>
                                        </div>

                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  style="color: #4a5568">Facebook:</label>
                                                <input type="text"  name="facebook"class="form-control" id="" placeholder=" facebook" required  style=" border:1px solid #fdde92da;"  >
                                                @error('facebook')
                                                    <small style="color:red">{{ $message }}</small>                                               
                                                @enderror       
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="color: #4a5568">Logotipo:</label>

                                        <div class="upload-box" id="uploadBox">
                                            <input type="file" name="logo" id="file" accept="image/*" hidden>

                                            <div class="upload-content" onclick="document.getElementById('file').click()">
                                                <i class="bi bi-cloud-upload" style="font-size:40px; color:#f4d279;"></i>
                                                <p style="margin:5px 0; color:#6c757d;">Haz clic o arrastra una imagen</p>
                                                <small style="color:#aaa;">PNG, JPG (máx. 2MB)</small>
                                            </div>

                                            <div class="preview-container">
                                                <img id="preview" src="">
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        const fileInput = document.getElementById('file');
                                        const preview = document.getElementById('preview');
                                        const previewContainer = document.querySelector('.preview-container');
                                        const uploadContent = document.querySelector('.upload-content');

                                        fileInput.addEventListener('change', function(e) {

                                            const file = e.target.files[0];
                                            if (!file) return;

                                            if (!file.type.startsWith('image/')) {
                                                alert('Solo se permiten imágenes');
                                                return;
                                            }

                                            const reader = new FileReader();

                                            reader.onload = function(e) {
                                                preview.src = e.target.result;

                                                previewContainer.style.display = 'block';
                                                uploadContent.style.display = 'none';
                                            }

                                            reader.readAsDataURL(file);
                                        });
                                    </script>
                                    

                                </div>
                            </div>  
                            <br>
                              
                            <div class="row">
                                 <div class="col-md-12 text-center">
                                    <div class="form-ground">
                                            <a href="{{ url($base.'/configuraciones') }}"  class="btn btn-secondary" style=" background-color: #4a5568;width: 200px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI';letter-spacing: 0.5px;border-radius: 6px;padding: 5px;" >
                                                    Cancelar
                                            </a>
                                                <button type="submit" class="btn" style="background-color: #f4d279; width: 250px;font-size: 16px;font-weight: 400;font-family: 'Segoe UI', Tahoma, sans-serif;letter-spacing: 0.5px;border-radius: 6px;padding: 5px;color:  #4a5568";">
                                                    <b>Registrar Configuración</b>
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

