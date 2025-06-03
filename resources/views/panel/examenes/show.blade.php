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
                        <span><a href="{{ route('sesiones.show', $evaluacion->sesion->id) }}">Evaluación / </a></span>{{ $evaluacion->titulo }}
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
                    width="100%" height="600" frameborder="0" style="border: none; overflow: hidden;">
                </iframe>
            @else
                <section class="enroll-area style-two">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6">
                                <img src="{{ asset('assets/img/panel/icon/reading.png') }}" alt="" class="wow fadeInUp" data-wow-delay=".3s">
                                <h1 class="area-heading font-w style-three wow fadeInDown" data-wow-delay=".4s">No hay un examen creado para esta evaluación.</h1>
                                <a href="{{ route('evaluaciones.generarExamen', $evaluacion->id) }}" class="kids-care-btn bg-per wow fadeInUp" data-wow-delay=".5s">Generar examen</a>
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
                <div class="mb-3">
                    <strong>Intentos restantes:</strong> {{ $intentos ?? '-' }}
                </div>
                @if (!empty($preguntas_json))
                    <div id="formularioExamenEstudiante" class="my-4"></div>
                @else
                    <div class="alert alert-warning">No hay preguntas disponibles para este examen.</div>
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
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
