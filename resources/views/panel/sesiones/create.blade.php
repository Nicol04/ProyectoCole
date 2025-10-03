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

        @if (!isset($directAccess))
            @php
                // Solo obtener cursos si no es acceso directo
                $aulasIds = auth()->user()->usuario_aulas()->pluck('aula_id')->toArray();
                $cursos = DB::table('aula_curso')
                    ->whereIn('aula_id', $aulasIds)
                    ->join('cursos', 'aula_curso.curso_id', '=', 'cursos.id')
                    ->select('cursos.*', 'aula_curso.id as aula_curso_id')
                    ->get();
            @endphp
        @endif

        @if ($roleId == 3)
            @include('panel.includes.menu_estudiante')
        @elseif($roleId == 2)
            @include('panel.includes.menu_docente')
        @endif
    @endif

    <!--Breadcrumb area start-->
    <section class="text-bread-crumb bc-style-two">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups! Hubo algunos problemas con tus datos:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Sesion </h2>
                    <div class="bread-crumb-line">
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
                    <div class="admission-form contact-page-form p-4 shadow-sm bg-white rounded">
                        <h1 class="area-heading font-per style-two text-center mb-4">Nueva Sesión</h1>
                        <p class="heading-para text-center mb-4">Complete los datos para crear una nueva sesión.</p>
                        <form action="{{ route('sesiones.store') }}" method="POST">
                            @csrf

                            <!-- Datos de la sesión -->
                            <h3 class="font-green mb-3">Datos de la sesión</h3>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="titulo" class="form-label">Título</label>
                                    <input type="text" name="titulo" id="titulo" placeholder="Título"
                                        class="form-control form-control-lg" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="curso_id" class="form-label">Curso</label>
                                    <select name="curso_id" class="form-control" id="curso-select"
                                        {{ $disableCursoSelect ? 'disabled' : '' }} required>
                                        <option value="">Seleccione un curso</option>
                                        @foreach ($cursos as $cursoItem)
                                            <option value="{{ $cursoItem->id }}"
                                                {{ (old('curso_id') ?? ($curso->id ?? '')) == $cursoItem->id ? 'selected' : '' }}>
                                                {{ $cursoItem->curso }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="competencia_id" class="form-label">Competencias</label>
                                    <select name="competencia_id[]" class="form-control select2" id="competencia-select"
                                        multiple="multiple" required>
                                        @if ($competencias)
                                            @foreach ($competencias as $competencia)
                                                <option value="{{ $competencia->id }}">{{ $competencia->nombre }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="capacidad_id" class="form-label">Capacidades</label>
                                    <select name="capacidad_id[]" class="form-control select2" id="capacidad-select"
                                        multiple="multiple" required>
                                        <!-- Las capacidades relacionadas se cargarán dinámicamente aquí -->
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="desempeno_id" class="form-label">Desempeños</label>
                                    <select name="desempeno_id[]" class="form-control select2" id="desempeno-select"
                                        multiple="multiple" required>
                                        <!-- Los desempeños relacionadas se cargarán dinámicamente aquí -->
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="proposito_sesion" class="form-label">Propósito de la sesión</label>
                                <textarea name="proposito_sesion" placeholder="Propósito de la sesión" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" placeholder="Fecha"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dia" class="form-label">Día</label>
                                    <input type="text" name="dia" id="dia" placeholder="Día"
                                        class="form-control" readonly>
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-outline-info" id="btn-hoy">
                                    Usar fecha de hoy
                                </button>
                            </div>

                            <!-- Tiempo estimado -->
                            <div class="mb-3">
                                <label for="tiempo_estimado" class="form-label">Tiempo estimado (minutos)</label>
                                <div class="d-flex align-items-center">
                                    <select name="tiempo_estimado" id="tiempo_estimado" class="form-control mr-2"
                                        required>
                                        <option value="">Seleccione duración</option>
                                        <option value="30">30 minutos</option>
                                        <option value="60">60 minutos</option>
                                        <option value="90">90 minutos</option>
                                        <option value="custom">Personalizado</option>
                                    </select>
                                    <input type="number" id="tiempo_custom" class="form-control ml-2" min="1"
                                        max="300" style="display: none;" placeholder="Ingrese minutos">
                                </div>
                            </div>

                            <!-- Evidencia -->
                            <div class="mb-3">
                                <label for="evidencia" class="form-label">Evidencia</label>
                                <textarea name="evidencia" id="evidencia" class="form-control" rows="3"
                                    placeholder="Describa las evidencias de aprendizaje que se recogerán..."></textarea>
                            </div>

                            <!-- Instrumento -->
                            <div class="mb-3">
                                <label for="instrumento" class="form-label">Instrumento de Evaluación</label>
                                <select name="instrumento" id="instrumento" class="form-control">
                                    <option value="">Seleccione un instrumento</option>
                                    <option value="Lista de cotejo">Lista de cotejo</option>
                                    <option value="Rúbrica">Rúbrica</option>
                                    <option value="Escala de valoración">Escala de valoración</option>
                                    <option value="Registro anecdótico">Registro anecdótico</option>
                                    <option value="Portafolio">Portafolio</option>
                                    <option value="Observación directa">Observación directa</option>
                                    <option value="custom">Personalizado</option>
                                </select>
                                <input type="text" id="instrumento_custom" class="form-control mt-2"
                                    name="instrumento_custom" placeholder="Ingrese el instrumento personalizado"
                                    style="display: none;">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Guardar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('curso-select').addEventListener('change', function() {
            const cursoId = this.value;
            const competenciaSelect = document.getElementById('competencia-select');

            if (cursoId) {
                fetch(`/cursos/${cursoId}/competencias`)
                    .then(response => response.json())
                    .then(data => {
                        competenciaSelect.innerHTML = '<option value="">Seleccione una competencia</option>';
                        data.forEach(competencia => {
                            competenciaSelect.innerHTML +=
                                `<option value="${competencia.id}">${competencia.nombre}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar competencias:', error);
                    });
            } else {
                competenciaSelect.innerHTML = '<option value="">Seleccione una competencia</option>';
            }
        });

        $(document).ready(function() {
            // Inicializar Select2 para competencias
            $('#competencia-select').select2({
                placeholder: "Escriba para buscar o seleccione competencias",
                tags: true,
                tokenSeparators: [',', ' '],
                allowClear: true,
                width: '100%'
            });

            // Inicializar Select2 para capacidades
            $('#capacidad-select').select2({
                placeholder: "Capacidades relacionadas",
                tags: false,
                allowClear: true,
                width: '100%'
            });

            // Inicializar Select2 para desempeños
            $('#desempeno-select').select2({
                placeholder: "Desempeños relacionados",
                tags: false,
                allowClear: true,
                width: '100%'
            });

            // Cargar capacidades al seleccionar competencias
            $('#competencia-select').on('change', function() {
                const competenciasSeleccionadas = $(this).val(); // Obtener las competencias seleccionadas
                const capacidadSelect = $('#capacidad-select');
                const desempenoSelect = $('#desempeno-select');

                // Limpiar las capacidades y desempeños actuales
                capacidadSelect.empty().trigger('change');
                desempenoSelect.empty().trigger('change');

                if (competenciasSeleccionadas && competenciasSeleccionadas.length > 0) {
                    competenciasSeleccionadas.forEach(function(competenciaId) {
                        // Hacer una solicitud AJAX para obtener las capacidades de cada competencia
                        fetch(`/competencias/${competenciaId}/capacidades`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(capacidad => {
                                    // Verificar si la capacidad ya está en el select
                                    if (!capacidadSelect.find(
                                            `option[value="${capacidad.id}"]`).length) {
                                        capacidadSelect.append(new Option(capacidad
                                            .nombre, capacidad.id));
                                    }
                                });

                                // Actualizar el select de capacidades
                                capacidadSelect.trigger('change');
                            })
                            .catch(error => {
                                console.error('Error al cargar capacidades:', error);
                            });

                        // Hacer una solicitud AJAX para obtener los desempeños relacionados con la competencia seleccionada
                        $.ajax({
                            url: '/desempenos/por-competencia-y-grado',
                            method: 'POST',
                            data: {
                                competencia_id: competenciaId,
                                _token: '{{ csrf_token() }}' // Agregar el token CSRF
                            },
                            success: function(data) {
                                if (data.error) {
                                    console.error(data.error);
                                    return;
                                }

                                data.forEach(desempeno => {
                                    // Agregar cada desempeño al select
                                    desempenoSelect.append(new Option(desempeno
                                        .descripcion, desempeno.id));
                                });

                                // Actualizar el select de desempeños
                                desempenoSelect.trigger('change');
                            },
                            error: function(error) {
                                console.error('Error al cargar desempeños:', error);
                            }
                        });
                    });
                }
            });

        });

        // Cargar desempeños al seleccionar una competencia
        $('#competencia-select').on('change', function() {
            const competenciaId = $(this).val(); // Obtener la competencia seleccionada
            const desempenoSelect = $('#desempeno-select');
            desempenoSelect.empty(); // Limpiar los desempeños actuales

            if (competenciaId) {
                // Hacer una solicitud AJAX para obtener los desempeños relacionados con la competencia seleccionada
                $.ajax({
                    url: '/desempenos/por-competencia-y-grado',
                    method: 'POST',
                    data: {
                        competencia_id: competenciaId,
                        _token: '{{ csrf_token() }}' // Agregar el token CSRF
                    },
                    success: function(data) {
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }

                        data.forEach(desempeno => {
                            // Agregar cada desempeño al select
                            desempenoSelect.append(new Option(desempeno.descripcion, desempeno
                                .id));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar desempeños:', error);
                    }
                });
            }
        });

        // Si ya hay un curso seleccionado, cargar sus competencias al cargar la página
        @if (isset($curso_id) && $curso_id)
            document.getElementById('curso-select').dispatchEvent(new Event('change'));
        @endif

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
        document.getElementById('tiempo_estimado').addEventListener('change', function() {
            const customInput = document.getElementById('tiempo_custom');
            if (this.value === 'custom') {
                customInput.style.display = 'block';
                customInput.setAttribute('name', 'tiempo_estimado');
                this.removeAttribute('name');
            } else {
                customInput.style.display = 'none';
                customInput.removeAttribute('name');
                this.setAttribute('name', 'tiempo_estimado');
            }
        });
        document.getElementById('instrumento').addEventListener('change', function() {
            const customInput = document.getElementById('instrumento_custom');
            if (this.value === 'custom') {
                customInput.style.display = 'block';
                customInput.setAttribute('name', 'instrumento'); // Cambiar el atributo name
                this.removeAttribute('name'); // Quitar el atributo name del select
            } else {
                customInput.style.display = 'none';
                customInput.removeAttribute('name'); // Quitar el atributo name del input
                this.setAttribute('name', 'instrumento'); // Restaurar el atributo name al select
            }
        });
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
