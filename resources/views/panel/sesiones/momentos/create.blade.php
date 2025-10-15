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

    <div class="text-bread-crumb d-flex align-items-center style-seven">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $sesion->titulo }}</h2>
                </div>
            </div>
        </div>
    </div>

    <section class="tution-top">
        <div class="container-fluid">
            <div class="row justify-content-center wow fadeInUp" data-wow-delay=".3s">
                <div class="col-lg-11 col-xl-8">
                    <div class="tuton-top-inner">
                        <h3 class="heading-style-two font-green">Preparación de la Sesión de Aprendizaje</h3>

                        <!-- Botón Generar con IA -->
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#temaModal">
                                <i class="fas fa-robot"></i> Generar con IA
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="inicio" class="form-label"><i class="fa fa-hand-o-right"></i>
                                    Inicio</label>
                                <textarea name="inicio" id="inicio" class="form-control" rows="3"
                                    placeholder="Describa las actividades de inicio..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="desarrollo" class="form-label"><i class="fa fa-hand-o-right"></i>
                                    Desarrollo</label>
                                <textarea name="desarrollo" id="desarrollo" class="form-control" rows="3"
                                    placeholder="Describa las actividades de desarrollo..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="cierre" class="form-label"><i class="fa fa-hand-o-right"></i>
                                    Cierre</label>
                                <textarea name="cierre" id="cierre" class="form-control" rows="3"
                                    placeholder="Describa las actividades de cierre..."></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para el tema -->
    <div class="modal fade" id="temaModal" tabindex="-1" aria-labelledby="temaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="temaModalLabel">Generar momentos con IA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tema" class="form-label">Ingresa el tema:</label>
                        <input type="text" class="form-control" id="tema" name="tema">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="generarConIA()">Generar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generarConIA() {
            const tema = document.getElementById('tema').value;
            if (!tema) {
                alert('Por favor ingresa un tema');
                return;
            }
            $('#temaModal').modal('hide');
        }
    </script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
