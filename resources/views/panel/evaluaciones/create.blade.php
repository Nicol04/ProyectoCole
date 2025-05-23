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

    <!--Admission application form area start-->
<div class="admission-process-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="area-heading font-per style-two">Generar evaluación</h1>
                <p class="heading-para">En este apartado podrás crear tus evaluaciones con IA (Inteligencia artificial)</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="row">
                    <div class="admission-form contact-page-form">
                        <div class="contact-page-form">
                            <h3 class="font-green">Datos de sesiones</h3>
                        </div>
                        <form action="">
                            <!-- elige el curso y el nombre de la sesion que quiere agregar una evaluacion -->
                            <div class="form-group">
                                <label for="curso">Curso</label>
                                <select name="curso_id" class="form-control" id="curso-select" required>
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}">{{ $curso->curso }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sesion_id">Sesión</label>
                                <select name="sesion_id" class="form-control" id="sesion-select" required>
                                    <option value="">Seleccione una sesión</option>
                                    <!-- Se llenará con JavaScript usando AJAX -->
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-xl-8">
                <div class="row">
                    <div class="admission-form contact-page-form">
                        <div class="contact-page-form">
                            <h3 class="font-green">Evaluaciones</h3>
                        </div>
                        <form action="">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input name="titulo" id="titulo" placeholder="Título" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="archivo">Archivo (opcional)</label>
                                <input type="file" name="archivo" id="archivo" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="cantidad_preguntas">Cantidad de preguntas</label>
                                <input name="cantidad_preguntas" id="cantidad_preguntas" type="number" min="1" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="cantidad_intentos">Cantidad de intentos</label>
                                <input name="cantidad_intentos" id="cantidad_intentos" type="number" min="1" class="form-control" required>
                            </div>

                            <div class="form-group form-check">
                                <input class="form-check-input" type="checkbox" name="es_supervisado" id="es_supervisado" value="1">
                                <label class="form-check-label" for="es_supervisado">Supervisado</label>
                            </div>

                            <input value="Generar evaluación con IA" type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="admission-form contact-page-form">
                        <div class="con-page-info">
                            <h3>Evaluación</h3>
                        </div>
                        <form action="">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input name="titulo" id="titulo" placeholder="Título" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="archivo">Archivo (opcional)</label>
                                <input type="file" name="archivo" id="archivo" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="cantidad_preguntas">Cantidad de preguntas</label>
                                <input name="cantidad_preguntas" id="cantidad_preguntas" type="number" min="1" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="cantidad_intentos">Cantidad de intentos</label>
                                <input name="cantidad_intentos" id="cantidad_intentos" type="number" min="1" class="form-control" required>
                            </div>

                            <div class="form-group form-check">
                                <input class="form-check-input" type="checkbox" name="es_supervisado" id="es_supervisado" value="1">
                                <label class="form-check-label" for="es_supervisado">Supervisado</label>
                            </div>

                            <input value="Generar evaluación con IA" type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--Admission Application form area end-->



<script>
    document.getElementById('curso-select').addEventListener('change', function () {
        const cursoId = this.value;
        const sesionSelect = document.getElementById('sesion-select');

        fetch(`/sesiones/por-curso/${cursoId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                sesionSelect.innerHTML = '<option value="">Seleccione una sesión</option>';
                data.forEach(sesion => {
                    sesionSelect.innerHTML += `<option value="${sesion.id}">${sesion.titulo}</option>`;
                });
            });
    });
</script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
