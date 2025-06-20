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

    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center style-five">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Recursos</h2>
                    <div class="bread-crumb-line"><span><a href="/recursos">Recursos</a>/</span>{{ $recurso->nombre }}</div>
                </div>
            </div>
        </div>
    </section>
    <!--Text breadcrumb area start-->

    <!--Blog area start -->
    <section class="post-page">
        <div class="container-fluid">
            <div class="row justify-content-center no-gutters">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-post-wrapper">
                                <div class="text-center mt-2">
                                    <button class="btn btn-info" onclick="mostrarAyuda()">?</button>
                                    <button class="btn btn-primary" onclick="activarPantallaCompleta()">🔍 Pantalla completa</button>
                                </div>
                                <!--
                                <div class="text-center mt-2">
                                    <button class="btn btn-info" onclick="mostrarAyuda()">?</button>
                                    <button class="btn btn-primary" onclick="activarPantallaCompleta()">🔍 Ver en realidad aumentada</button>
                                </div>
                            -->
                                <!-- Modal flotante de ayuda -->
                                <div id="ayudaModal"
                                    style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:#fff; color:#000; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); z-index:9999; max-width:90%;">
                                    <h5><strong>Navegación básica</strong></h5>
                                    <p><strong>Todos los controles:</strong></p>
                                    <ul style="text-align:left;">
                                        <li><strong>Orbita:</strong> Clic izquierdo + arrastrar / Arrastrar con un dedo (tocar)</li>
                                        <li><strong>Zoom:</strong> Doble clic en el modelo / Desplazarse / Pellizcar (tocar)</li>
                                        <li><strong>Pan:</strong> Clic derecho + arrastrar / Arrastrar con dos dedos (tocar)</li>
                                    </ul>
                                    <div class="text-center">
                                        <button class="btn btn-secondary btn-sm" onclick="cerrarAyuda()">Cerrar</button>
                                    </div>
                                </div>

                                <model-viewer id="modelo3D" src="{{ $recurso->url }}" alt="Modelo 3D interactivo"
                                    camera-controls background-color="#ffffff"
                                    style="width: 100%; height: 500px; margin-top: 20px;" shadow-intensity="1"
                                    exposure="1" interaction-prompt="when-focused" ar fullscreen>
                                </model-viewer>

                                <div class="post-details">
                                    <h2 class="post-heading">{{ $recurso->nombre }}</h2>
                                    <p>{{ $recurso->descripcion }}</p>
                                    <h5 class="font-green">
                                        <div>Curso: {{ $recurso->curso->curso ?? 'Sin curso asignado' }}</div>
                                        <div>Categoría: {{ $recurso->categoria->nombre ?? 'Sin categoría asignada' }}</div>
                                    </h5>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Blog area end -->
    <script>
        function activarPantallaCompleta() {
            const viewer = document.getElementById('modelo3D');
            if (viewer.requestFullscreen) {
                viewer.requestFullscreen();
            } else if (viewer.webkitRequestFullscreen) {
                viewer.webkitRequestFullscreen();
            } else if (viewer.msRequestFullscreen) {
                viewer.msRequestFullscreen();
            } else {
                alert("Tu navegador no soporta pantalla completa");
            }
        }

        function mostrarAyuda() {
            document.getElementById('ayudaModal').style.display = 'block';
        }

        function cerrarAyuda() {
            document.getElementById('ayudaModal').style.display = 'none';
        }
    </script>


    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
