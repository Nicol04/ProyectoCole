<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>
    @if (auth()->check())
        @php
            $roleId = auth()->user()->roles->first()?->id;
        @endphp

        @if ($roleId == 3)
            @include('panel.includes.menu_estudiante')
        @elseif($roleId == 2)
            @include('panel.includes.menu_docente')
        @endif
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="image-breadcrumb style-two"></div>

    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center">

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>Creación de unidades</h2>
                </div>
            </div>
        </div>
    </section>
    <!--Text breadcrumb area start-->
    <!-- INICIO DE CREACION DE UNIDADES -->
    <section class="middle-button-area py-4">
        <div class="container-fluid">
            <div class="container">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="font-green mb-3">Datos Generales de la Unidad</h4>

                        <form action="{{ route('unidades.store') }}" method="POST">
                            @csrf

                            <!-- Nombre de la unidad -->
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Unidad</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}"
                                    required maxlength="255">
                            </div>

                            <!-- Fechas -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de inicio</label>
                                    <input type="date" name="fecha_inicio" class="form-control"
                                        value="{{ old('fecha_inicio') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de fin</label>
                                    <input type="date" name="fecha_fin" class="form-control"
                                        value="{{ old('fecha_fin') }}" required>
                                </div>
                            </div>

                            <!-- Grado -->
                            <div class="mb-3">
                                <label class="form-label">Grado</label>
                                <input type="text" class="form-control" value="{{ $grado }}" readonly>
                                <input type="hidden" name="grado" value="{{ $grado }}">
                            </div>


                            <!-- Profesores responsables -->
                            <div class="form-group mb-3">
                                <label for="docentes">Docentes responsables</label>
                                <select id="docentes" name="profesores_responsables[]" multiple class="form-control">
                                    @foreach ($docentes as $id => $nombre)
                                        <option value="{{ $id }}">{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Situación significativa -->
                            <div class="mb-3">
                                <label class="form-label">Situación significativa</label>
                                <textarea name="situacion_significativa" rows="4" class="form-control" required>{{ old('situacion_significativa') }}</textarea>
                            </div>

                            <!-- Productos esperados -->
                            <div class="mb-3">
                                <label class="form-label">Productos esperados</label>
                                <textarea name="productos" rows="3" class="form-control" required>{{ old('productos') }}</textarea>
                            </div>

                            <!-- Botón -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    Guardar Unidad
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FIN DE CREACION DE UNIDADES -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#docentes').select2({
                placeholder: "Seleccione docentes responsables",
                width: '100%',
                allowClear: true,
            });

        });
    </script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
