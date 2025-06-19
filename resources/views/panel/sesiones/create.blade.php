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

    <!--Breadcrumb area start-->
    <section class="text-bread-crumb bc-style-two">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Sesion </h2>
                    <div class="bread-crumb-line"><span>
                            <a href="{{ route('sesiones.index', ['id' => $curso->id]) }}">Sesiones / </a></span>Nueva
                        sesión</div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb area end-->

    <!-- Admission application form area start -->
    <div class="admission-process-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="admission-form contact-page-form">
                        <h1 class="area-heading font-per style-two">Nueva Sesión</h1>
                        <p class="heading-para">Complete los datos para crear una nueva sesión.</p>

                        <form action="{{ route('sesiones.store') }}" method="POST">
                            @csrf
                            <h6>Detalles de la Sesión</h6>
                            <input type="text" name="titulo" placeholder="Título" class="form-control mb-3"
                                required>
                            <textarea name="objetivo" placeholder="Objetivo" class="form-control mb-3" rows="3" required></textarea>
                            <textarea name="actividades" placeholder="Actividades" class="form-control mb-3" rows="3" required></textarea>
                            <input type="date" name="fecha" id="fecha" placeholder="Fecha"
                                class="form-control mb-3" required>
                            <input type="text" name="dia" id="dia" placeholder="Día"
                                class="form-control mb-3" readonly>
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-outline-info" id="btn-hoy">
                                    Usar fecha de hoy
                                </button>
                            </div>
                            <input type="hidden" name="aula_curso_id" value="{{ $aulaCurso->id }}">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">Guardar Sesión</button>
                                <a href="{{ route('sesiones.index', ['id' => $aulaCurso->curso->id]) }}"
                                    class="btn btn-secondary px-4">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fecha').addEventListener('change', function() {
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const fechaSeleccionada = new Date(this.value);
            const dia = dias[fechaSeleccionada.getDay()];
            document.getElementById('dia').value = dia;
        });

        window.addEventListener('DOMContentLoaded', function() {
            const inputFecha = document.getElementById('fecha');
            if (inputFecha.value) {
                const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                const fechaSeleccionada = new Date(inputFecha.value);
                const dia = dias[fechaSeleccionada.getDay()];
                document.getElementById('dia').value = dia;
            }
        });
        document.getElementById('btn-hoy').addEventListener('click', function() {
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2, '0');
            const dd = String(hoy.getDate()).padStart(2, '0');
            const fechaHoy = `${yyyy}-${mm}-${dd}`;
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const diaHoy = dias[hoy.getDay()];

            document.getElementById('fecha').value = fechaHoy;
            document.getElementById('dia').value = diaHoy;
        });
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>
</html>
