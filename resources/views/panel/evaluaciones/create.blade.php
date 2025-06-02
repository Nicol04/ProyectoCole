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

    <!--Breadcrumb area start-->
    <div class="image-breadcrumb style-con"></div>
    <!--Breadcrumb area end-->
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

    <!-- Generar Evaluación con IA -->
    <div class="admission-process-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="area-heading font-per style-two">Generar evaluación</h1>
                    <p class="heading-para">Crea tus evaluaciones automáticamente con ayuda de IA</p>
                </div>
            </div>

            <!-- Fila con animaciones a ambos lados y el formulario en el centro -->
            <div class="row justify-content-center align-items-center">
                <!-- Animación izquierda -->
                <div class="col-lg-2 text-center d-none d-lg-block">
                    <div class="animated-img">
                        <img src="{{ asset('assets/img/panel/bg/kiddy-animation.gif') }}" alt="">
                    </div>
                </div>
                <div class="col-xl-8">
                    <form action="{{ route('evaluacion.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Datos de la sesión -->
                        <h3 class="font-green">Datos de la sesión</h3>
                        <div class="form-group">
                            <label for="curso_id">Curso</label>
                            <select name="curso_id" class="form-control" id="curso-select" required
                                @if ($aula_curso_id) disabled @endif>
                                <option value="">Seleccione un curso</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                        {{ (old('curso_id') ?? ($curso_id ?? '')) == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->curso }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sesion_id">Sesión</label>
                            <input type="hidden" value="{{ $sesion_id }}" name="sesion_id"></input>
                            <select name="sesion_id" class="form-control" id="sesion-select" required
                                @if ($sesion_id) disabled 
                                
                                @endif>
                                <option value="">Seleccione una sesión</option>
                                @if (isset($sesion_id) && isset($sesion_titulo)) 
                                    <option value="{{ $sesion_id }}" selected>{{ $sesion_titulo }}</option>
                                @endif
                            </select>
                        </div>

                        <h3 class="font-green">Configuración de evaluación</h3>
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" placeholder="Escribe un título" name="titulo" id="titulo"
                                class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_preguntas">Cantidad de preguntas</label>
                            <input name="cantidad_preguntas" id="cantidad_preguntas" type="number" min="2"
                                max="20" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_intentos">Cantidad de intentos</label>
                            <input name="cantidad_intentos" id="cantidad_intentos" type="number" min="1"
                                max="10" class="form-control" required>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="es_supervisado" id="es_supervisado" class="form-check-input"
                                value="1">
                            <label for="es_supervisado" class="form-check-label">Supervisado</label>
                        </div>

                        <input type="hidden" name="fecha_creacion" value="{{ now() }}">

                        <button type="submit" class="btn btn-primary">Generar evaluación con IA</button>
                    </form>
                </div>
                <div class="col-lg-2 text-center d-none d-lg-block">
                    <div class="animated-img">
                        <img src="{{ asset('assets/img/panel/bg/kiddy-animation.gif') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('curso-select').addEventListener('change', function() {
                const cursoId = this.value;
                const sesionSelect = document.getElementById('sesion-select');

                fetch(`/sesiones/por-curso/${cursoId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        sesionSelect.innerHTML = '<option value="">Seleccione una sesión</option>';
                        data.forEach(sesion => {
                            sesionSelect.innerHTML +=
                                `<option value="${sesion.id}">${sesion.titulo}</option>`;
                        });
                    });
            });
        </script>

        @include('panel.includes.footer3')
        @include('panel.includes.footer')
</body>

</html>
