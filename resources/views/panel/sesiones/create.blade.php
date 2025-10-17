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
                $aulasIds = auth()->user()->usuario_aulas->pluck('aula_id')->toArray();
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

    <section class="kindergarten-top-content wow fadeInUp" data-wow-delay=".3s">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="kin-top-con text-center mb-4">
                        <h3 class="font-per style-two">Crear nueva sesión</h3>
                        <p>Complete los datos para crear una nueva sesión.</p>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('sesiones.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="aula_curso_id" value="{{ $cursos->first()->aula_curso_id }}">
                                <!-- Datos de la sesión -->
                                <h4 class="font-green mb-3">Datos Informativos</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Institución Educativa</label>
                                        <input type="text" class="form-control" value="Ann Goulden" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Directora</label>
                                        <input type="text" class="form-control"
                                            value="Dra. Maricarmen Julliana Ruiz Falero" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Docente</label>
                                        <input type="text" class="form-control"
                                            value="{{ auth()->user()->persona->nombre . ' ' . auth()->user()->persona->apellido }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Grado y Sección</label>
                                        <input type="text" class="form-control"
                                            value="{{ (auth()->user()->usuario_aulas->first()?->aula->grado ?? 'No asignado') . ' ' . (auth()->user()->usuario_aulas->first()?->aula->seccion ?? 'No asignado') }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha" class="form-label">Fecha</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dia" class="form-label">Día</label>
                                        <input type="text" name="dia" id="dia" class="form-control"
                                            readonly>
                                    </div>
                                </div>

                                <div class="text-center mb-3">
                                    <button type="button" class="btn btn-outline-info" id="btn-hoy">
                                        Usar fecha de hoy
                                    </button>
                                </div>

                                <!-- Tiempo estimado -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempo_estimado" class="form-label">Tiempo estimado
                                            (minutos)</label>
                                        <select name="tiempo_estimado" id="tiempo_estimado" class="form-control"
                                            required>
                                            <option value="">Seleccione duración</option>
                                            <option value="30">30 minutos</option>
                                            <option value="60">60 minutos</option>
                                            <option value="90">90 minutos</option>
                                            <option value="custom">Personalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" id="tiempo_custom" class="form-control" min="1"
                                            max="300" style="display: none;" placeholder="Ingrese minutos">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="titulo" class="form-label">Título</label>
                                        <input type="text" name="titulo" id="titulo" placeholder="Título"
                                            class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="proposito_sesion" class="form-label">Propósito de la
                                            sesión</label>
                                        <textarea name="proposito_sesion" placeholder="Propósito de la sesión" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>

                                <h4 class="font-green mb-3">Propósitos de Aprendizaje</h4>
                                <div class="row">
                                    @include('components.form-competencias', [
                                        'cursos' => $cursos,
                                        'competencias' => $competencias ?? null,
                                        'disableCursoSelect' => $disableCursoSelect ?? false,
                                        'curso' => $curso ?? null
                                    ])
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" id="mostrarEnfoques" name="mostrarEnfoques">
                                    <label for="mostrarEnfoques">¿Agregar enfoques transversales?</label>
                                </div>

                                <div id="camposEnfoques" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="enfoque_transversal" class="form-label">Enfoque
                                                transversal</label>
                                            <select name="enfoque_transversal[]" id="enfoque_transversal"
                                                class="form-control select2" multiple="multiple">
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="competencias_transversales" class="form-label">Competencias
                                                transversales</label>
                                            <select name="competencias_transversales[]"
                                                id="competencias_transversales" class="form-control select2"
                                                multiple="multiple">
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="capacidades_transversales" class="form-label">Capacidades
                                                transversales</label>
                                            <select name="capacidades_transversales[]" id="capacidades_transversales"
                                                class="form-control select2" multiple="multiple">
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="desempeno_transversal" class="form-label">Desempeños
                                                transversales</label>
                                            <select name="desempeno_transversal[]" id="desempeno_transversal"
                                                class="form-control select2" multiple="multiple">
                                                <!-- Opciones cargadas dinámicamente -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="criterios" class="form-label">Criterios</label>
                                        <textarea name="criterios" id="criterios" class="form-control" rows="3"
                                            placeholder="Describa los criterios de evaluación..." required></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="evidencia" class="form-label">Evidencia</label>
                                        <textarea name="evidencia" id="evidencia" class="form-control" rows="3"
                                            placeholder="Describa las evidencias de aprendizaje que se recogerán..." required></textarea>
                                    </div>
                                </div>
                                <div class="col-mb-3">
                                    <label for="instrumento" class="form-label">Instrumento de Evaluación</label>
                                    <select name="instrumento" id="instrumento" class="form-control" required>
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
                                <button type="submit"
                                    class="first-btn kids-care-btn bgc-orange fadeInRight fadeInLeft animated">
                                    Guardar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // ✅ ELIMINADO: El evento duplicado del curso-select ya está manejado en form-competencias.blade.php

        // 🔹 MANEJO DE ENFOQUES TRANSVERSALES
        const mostrarEnfoquesCheckbox = $('#mostrarEnfoques');
        const camposEnfoques = $('#camposEnfoques');
        const enfoqueSelect = $('#enfoque_transversal');
        const competenciasSelect = $('#competencias_transversales');
        const capacidadesSelect = $('#capacidades_transversales');
        const desempenoTransversalSelect = $('#desempeno_transversal');

        // Ocultar los campos al inicio
        camposEnfoques.hide();

        // Inicializar Select2 para enfoques transversales
        enfoqueSelect.select2({
            placeholder: "Seleccione o agregue enfoques transversales",
            tags: true,
            tokenSeparators: [',', ' '],
            allowClear: true,
            width: '100%'
        });

        competenciasSelect.select2({
            placeholder: "Seleccione o agregue competencias transversales",
            tags: true,
            tokenSeparators: [',', ' '],
            allowClear: true,
            width: '100%'
        });

        capacidadesSelect.select2({
            placeholder: "Seleccione o agregue capacidades transversales",
            tags: true,
            tokenSeparators: [',', ' '],
            allowClear: true,
            width: '100%'
        });

        desempenoTransversalSelect.select2({
            placeholder: "Seleccione o agregue desempeños transversales",
            tags: true,
            tokenSeparators: [',', ' '],
            allowClear: true,
            width: '100%'
        });

        // ✅ MOSTRAR/OCULTAR ENFOQUES
        mostrarEnfoquesCheckbox.on('change', function() {
            if (this.checked) {
                camposEnfoques.show();

                // Limpiar antes de cargar
                enfoqueSelect.empty();
                competenciasSelect.empty();
                capacidadesSelect.empty();

                // Cargar enfoques transversales
                $.ajax({
                    url: '/enfoques-transversales',
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(enfoque) {
                            enfoqueSelect.append(new Option(enfoque.nombre, enfoque.id));
                        });
                        enfoqueSelect.trigger('change');
                    },
                    error: function(error) {
                        console.error('Error al cargar enfoques:', error);
                    }
                });

                // Cargar competencias transversales
                $.ajax({
                    url: '/competencias-transversales',
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(competencia) {
                            competenciasSelect.append(new Option(competencia.nombre, competencia.id));
                        });
                        competenciasSelect.trigger('change');
                    },
                    error: function(error) {
                        console.error('Error al cargar competencias transversales:', error);
                    }
                });
            } else {
                camposEnfoques.hide();
                enfoqueSelect.val(null).trigger('change');
                competenciasSelect.val(null).trigger('change');
                capacidadesSelect.val(null).trigger('change');
            }
        });

        // ✅ AL CAMBIAR COMPETENCIAS TRANSVERSALES, CARGAR CAPACIDADES
        competenciasSelect.on('change', function() {
            const competenciasSeleccionadas = $(this).val();
            capacidadesSelect.empty().trigger('change');

            if (!competenciasSeleccionadas || competenciasSeleccionadas.length === 0) return;

            const capacidadesCargadas = new Set();

            competenciasSeleccionadas.forEach(function(competenciaId) {
                $.ajax({
                    url: `/competencias-transversales/${competenciaId}/capacidades`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(capacidad) {
                            if (!capacidadesCargadas.has(capacidad.id)) {
                                capacidadesCargadas.add(capacidad.id);
                                capacidadesSelect.append(new Option(capacidad.nombre, capacidad.id));
                            }
                        });
                        capacidadesSelect.trigger('change');
                    },
                    error: function(error) {
                        console.error('Error al cargar capacidades transversales:', error);
                    }
                });
            });
        });

        // ✅ AL CAMBIAR CAPACIDADES TRANSVERSALES, CARGAR DESEMPEÑOS
        capacidadesSelect.on('change', function() {
            const capacidadesSeleccionadas = $(this).val();
            desempenoTransversalSelect.empty().trigger('change');

            if (!capacidadesSeleccionadas || capacidadesSeleccionadas.length === 0) {
                return;
            }

            $.ajax({
                url: '/desempenos/por-capacidad-transversal',
                method: 'POST',
                data: {
                    capacidades_transversales: capacidadesSeleccionadas,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    data.forEach(function(desempeno) {
                        desempenoTransversalSelect.append(new Option(desempeno.descripcion, desempeno.id));
                    });

                    desempenoTransversalSelect.trigger('change');
                },
                error: function(error) {
                    console.error('Error al cargar desempeños transversales:', error);
                }
            });
        });

        // Al limpiar las competencias, limpiar las capacidades
        competenciasSelect.on('select2:clear', function() {
            capacidadesSelect.empty().trigger('change');
            desempenoTransversalSelect.empty().trigger('change');
        });

        // ✅ EVENTOS DE FECHA Y OTROS CAMPOS
        $('#fecha').on('change', function() {
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const fechaSeleccionada = new Date(this.value);
            const dia = dias[fechaSeleccionada.getDay()];
            $('#dia').val(dia);
        });

        $('#btn-hoy').on('click', function() {
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2, '0');
            const dd = String(hoy.getDate()).padStart(2, '0');
            const fechaHoy = `${yyyy}-${mm}-${dd}`;
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const diaHoy = dias[hoy.getDay()];

            $('#fecha').val(fechaHoy);
            $('#dia').val(diaHoy);
        });

        $('#tiempo_estimado').on('change', function() {
            const customInput = $('#tiempo_custom');
            if (this.value === 'custom') {
                customInput.show().attr('name', 'tiempo_estimado');
                $(this).removeAttr('name');
            } else {
                customInput.hide().removeAttr('name');
                $(this).attr('name', 'tiempo_estimado');
            }
        });

        $('#instrumento').on('change', function() {
            const customInput = $('#instrumento_custom');
            if (this.value === 'custom') {
                customInput.show().attr('name', 'instrumento');
                $(this).removeAttr('name');
            } else {
                customInput.hide().removeAttr('name');
                $(this).attr('name', 'instrumento');
            }
        });

        // ✅ DEBUG: Verificar si hay curso preseleccionado
        @if (isset($curso_id) && $curso_id)
            console.log('Curso preseleccionado: {{ $curso_id }}');
            const cursoSelect = document.getElementById('curso-select');
            if (cursoSelect) {
                cursoSelect.dispatchEvent(new Event('change'));
            }
        @endif
    });
    </script>
    
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
