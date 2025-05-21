<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>
    <div class="preloader"></div> <!-- carga -->
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


    <!-- Editar Sesión -->
    <section class="kindergarten-top-content wow fadeInUp" data-wow-delay=".3s">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="kin-top-con">
                        <h2 class="text-center font-red mb-4">Editar Sesión</h2>

                        <form action="{{ route('sesiones.update', $sesion->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" id="titulo" class="form-control"
                                    value="{{ $sesion->titulo }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="objetivo">Objetivo</label>
                                <textarea name="objetivo" id="objetivo" class="form-control" rows="3" required>{{ $sesion->objetivo }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="actividades">Actividades</label>
                                <textarea name="actividades" id="actividades" class="form-control" rows="3" required>{{ $sesion->actividades }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control"
                                    value="{{ $sesion->fecha }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="dia">Día</label>
                                <input type="text" name="dia" id="dia" class="form-control"
                                    value="{{ $sesion->dia }}" readonly>
                            </div>

                            <script>
                                document.getElementById('fecha').addEventListener('change', function() {
                                    const dias = [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                    const fechaSeleccionada = new Date(this.value);
                                    const dia = dias[fechaSeleccionada.getDay()];
                                    document.getElementById('dia').value = dia;
                                });

                                document.getElementById('fecha').addEventListener('change', function() {
                                    const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                    const fechaSeleccionada = new Date(this.value);
                                    const dia = dias[fechaSeleccionada.getDay()];
                                    document.getElementById('dia').value = dia;
                                });

                                window.addEventListener('DOMContentLoaded', function() {
                                    const inputFecha = document.getElementById('fecha');
                                    if (inputFecha.value) {
                                        const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        const fechaSeleccionada = new Date(inputFecha.value);
                                        const dia = dias[fechaSeleccionada.getDay()];
                                        document.getElementById('dia').value = dia;
                                    }
                                });
                            </script>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">Guardar Cambios</button>
                                <a href="{{ route('sesiones.show', $sesion->id) }}"
                                    class="btn btn-secondary px-4">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
