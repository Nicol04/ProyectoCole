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

    <div class="text-bread-crumb d-flex align-items-center style-six blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Evaluación</h2>
                    <div class="bread-crumb-line">
                        <span><a href="{{ route('sesiones.show', $evaluacion->sesion->id) }}">Evaluación /
                            </a></span>{{ $evaluacion->titulo }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    @if (auth()->check())
        @php
            $roleId = auth()->user()->roles->first()?->id;
        @endphp

        @if ($roleId == 2)
            {{-- DOCENTE --}}
            <div class="latest-news-area">
                <div class="container-fluid">
                    <h1 class="area-heading font-sky style-two">{{ $evaluacion->titulo }}</h1>
                    <div class="mb-3">
                        <strong>Cantidad de intentos:</strong> {{ $evaluacion->cantidad_intentos ?? '-' }}
                    </div>
                    @if (!empty($preguntas_json))
                        @php
                            $evaluacion_id = $evaluacion->id;
                            $cantidad_preguntas = $evaluacion->cantidad_preguntas;
                            $titulo = $evaluacion->titulo;
                        @endphp

                        <iframe id="iframeExamen"
                            src="{{ route('examen.renderizar', [
                                'evaluacion_id' => $evaluacion_id,
                                'cantidad_preguntas' => $cantidad_preguntas,
                            ]) }}"
                            width="100%" height="350" frameborder="0" style="border: none; overflow: hidden;">
                        </iframe>
                    @else
                        <section class="enroll-area style-two">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6">
                                        <img src="{{ asset('assets/img/panel/icon/reading.png') }}" alt=""
                                            class="wow fadeInUp" data-wow-delay=".3s">
                                        <h1 class="area-heading font-w style-three wow fadeInDown" data-wow-delay=".4s">
                                            No hay un examen creado para esta evaluación.</h1>
                                        <a href="{{ route('evaluaciones.generarExamen', $evaluacion->id) }}"
                                            class="kids-care-btn bg-per wow fadeInUp" data-wow-delay=".5s">Generar
                                            examen</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        @elseif ($roleId == 3)
            {{-- ESTUDIANTE --}}
            <div class="latest-news-area">
                <div class="container-fluid">
                    <h1 class="area-heading font-sky style-two">{{ $evaluacion->titulo }}</h1>
                    @if (!empty($preguntas_json))
                        {{-- Si hay intento en progreso, muestra solo el iframe FUERA del diseño --}}
                        @if (isset($ultimoIntento) && $ultimoIntento->estado === 'en progreso')
                            <div class="mb-4">
                                <h2 class="font-orange area-heading">
                                    Cantidad de intentos restantes: {{ $intentos ?? '-' }}
                                </h2>
                                <p>Tienes un examen en progreso.</p>
                            </div>
                            <iframe id="iframeExamen"
                                src="{{ route('examen.estudiantes', [
                                    'evaluacion_id' => $evaluacion->id,
                                    'intento_id' => $ultimoIntento->id,
                                ]) }}"
                                width="100%" height="600" frameborder="0" style="border: none; overflow: hidden;">
                            </iframe>
                            {{-- Si el último intento está finalizado y quedan intentos, muestra botón para nuevo intento --}}
                        @elseif(isset($ultimoIntento) && $ultimoIntento->estado === 'finalizado' && ($intentos ?? 0) > 0)
                            <section class="welcome-boxed bol-bol-bg">
                                <div class="container-fluid">
                                    <div class="row no-gutters ">
                                        <div class="col-md-12">
                                            <div class="wellcome-area-wrapper ">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-5 col-xl-6">
                                                        <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                                            <h2 class="font-orange area-heading display-6 fw-bold mb-3">
                                                                Cantidad de intentos restantes: {{ $intentos ?? '-' }}
                                                            </h2>
                                                            <div class="alert alert-success mt-3">
                                                                Examen finalizado.
                                                            </div>
                                                            <a href="{{ route('evaluacion.iniciar', $evaluacion->id) }}"
                                                                class="btn btn-primary mt-3">
                                                                Hacer nuevo intento
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Si el último intento está finalizado y NO quedan intentos, mensaje de éxito --}}
                        @elseif(isset($ultimoIntento) && $ultimoIntento->estado === 'finalizado' && ($intentos ?? 0) <= 0)
                            <section class="welcome-boxed bol-bol-bg">
                                <div class="container-fluid">
                                    <div class="row no-gutters ">
                                        <div class="col-md-12">
                                            <div class="wellcome-area-wrapper ">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-5 col-xl-6">
                                                        <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                                            <h2 class="font-orange area-heading display-6 fw-bold mb-3">
                                                                Cantidad de intentos restantes: {{ $intentos ?? '-' }}
                                                            </h2>
                                                            <div
                                                                class="alert alert-success fs-4 fw-bold text-center mt-3">
                                                                ¡Ya lograste resolver tu examen con éxito!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Si no hay intentos en progreso ni finalizados, pero quedan intentos --}}
                        @elseif(($intentos ?? 0) > 0)
                            <section class="welcome-boxed bol-bol-bg">
                                <div class="container-fluid">
                                    <div class="row no-gutters ">
                                        <div class="col-md-12">
                                            <div class="wellcome-area-wrapper ">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-5 col-xl-6">
                                                        <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                                            <h2 class="font-orange area-heading">
                                                                Cantidad de intentos restantes: {{ $intentos ?? '-' }}
                                                            </h2>
                                                            <p>Hola estudiante, acá puedes resolver tu examen.
                                                                Dale clic en comenzar para empezar.</p>
                                                            <a href="{{ route('evaluacion.iniciar', $evaluacion->id) }}"
                                                                class="kids-care-btn bg-red">Comenzar evaluación</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @else
                            <section class="welcome-boxed bol-bol-bg">
                                <div class="container-fluid">
                                    <div class="row no-gutters ">
                                        <div class="col-md-12">
                                            <div class="wellcome-area-wrapper ">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-5 col-xl-6">
                                                        <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                                            <h2 class="font-orange area-heading display-6 fw-bold mb-3">
                                                                Cantidad de intentos restantes: {{ $intentos ?? '-' }}
                                                            </h2>
                                                            <div
                                                                class="alert alert-danger fs-4 fw-bold text-center mt-3">
                                                                Ya alcanzaste el número máximo de intentos.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    @else
                        <section class="welcome-boxed bol-bol-bg">
                            <div class="container-fluid">
                                <div class="row no-gutters ">
                                    <div class="col-md-12">
                                        <div class="wellcome-area-wrapper ">
                                            <div class="row">
                                                <div class="col-md-7 col-lg-5 col-xl-6">
                                                    <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                                        <div class="alert alert-warning fs-4 fw-bold text-center mt-3">
                                                            No hay preguntas disponibles para este examen.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
            @if (!empty($preguntas_json))
            @endif
        @endif
    @endif

    <script>
        window.addEventListener("message", function(event) {
            if (event.data.type === "iframeHeight") {
                const iframe = document.getElementById("iframeExamen");
                if (iframe && event.data.height) {
                    iframe.style.height = event.data.height + "px";
                }
            }
        });

        function sendIframeHeight() {
            const height = document.body.scrollHeight;
            window.parent.postMessage({
                type: "iframeHeight",
                height: height
            }, "*");
        }

        window.onload = sendIframeHeight;
        window.onresize = sendIframeHeight;

        window.addEventListener("message", function(event) {
            if (event.data.type === "redirect" && event.data.url) {
                window.location.href = event.data.url;
            }
        });
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>
</html>
