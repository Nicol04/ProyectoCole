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


                            <!-- Contenido curricular dinámico -->
                            @include('components.contenido-curricular', [
                                'cursos' => $cursos ?? collect(),
                            ])

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
