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
                                                                class="btn btn-primary mt-3"
                                                                id="btnNuevoIntento">
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

                            {{-- Mostrar historial de intentos del estudiante --}}
                            @if (isset($intentosConRespuestas) && count($intentosConRespuestas) > 0)
                                <div class="container my-4">
                                    <h3 class="mb-3">Historial de intentos</h3>
                                    <div class="accordion" id="historialIntentosAccordion">
                                        @foreach ($intentosConRespuestas as $idx => $registro)
                                            @php
                                                $respuestas = $registro['respuesta_json']
                                                    ? json_decode($registro['respuesta_json'], true)
                                                    : [];
                                                $puntajeTotal = array_sum(array_column($respuestas, 'valor_respuesta'));
                                            @endphp
                                            <div class="accordion-item mb-2">
                                                <h2 class="accordion-header" id="heading{{ $idx }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $idx }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse{{ $idx }}">
                                                        Intento #{{ $idx + 1 }} - Fecha:
                                                        {{ $registro['fecha_respuesta'] ? \Carbon\Carbon::parse($registro['fecha_respuesta'])->format('d/m/Y H:i') : '-' }}
                                                        - Puntaje: <span class="fw-bold">{{ $puntajeTotal }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $idx }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="heading{{ $idx }}"
                                                    data-bs-parent="#historialIntentosAccordion">
                                                    <div class="accordion-body">
                                                        @if ($respuestas)
                                                            <form>
                                                                @foreach ($respuestas as $i => $respuesta)
                                                                    <div class="mb-3 p-3 border rounded">
                                                                        <div class="mb-2">
                                                                            <strong>{{ $i + 1 }}.
                                                                                {{ $respuesta['pregunta'] }}</strong>
                                                                            <span
                                                                                class="badge bg-info text-dark ms-2">Valor:
                                                                                {{ $respuesta['valor_pregunta'] }}</span>
                                                                        </div>
                                                                        @foreach ($respuesta['opciones'] as $key => $opcion)
                                                                            @php
                                                                                $letra = chr(97 + $key); // a, b, c...
                                                                                $esCorrecta =
                                                                                    $letra ==
                                                                                    $respuesta['respuesta_correcta'];
                                                                                $esSeleccionada =
                                                                                    $letra ==
                                                                                    $respuesta[
                                                                                        'respuesta_seleccionada'
                                                                                    ];
                                                                                $clase = '';
                                                                                if ($esSeleccionada && $esCorrecta) {
                                                                                    $clase =
                                                                                        'border border-success bg-success bg-opacity-10';
                                                                                } elseif (
                                                                                    $esSeleccionada &&
                                                                                    !$esCorrecta
                                                                                ) {
                                                                                    $clase =
                                                                                        'border border-danger bg-danger bg-opacity-10';
                                                                                } elseif ($esCorrecta) {
                                                                                    $clase =
                                                                                        'border border-success bg-success bg-opacity-10';
                                                                                }
                                                                            @endphp
                                                                            <div
                                                                                class="form-check mb-1 {{ $clase }}">
                                                                                <input class="form-check-input"
                                                                                    type="radio" disabled
                                                                                    @if ($esSeleccionada) checked @endif>
                                                                                <label class="form-check-label">
                                                                                    {{ strtoupper($letra) }})
                                                                                    {{ $opcion }}
                                                                                    @if ($esCorrecta)
                                                                                        <span
                                                                                            class="badge bg-success ms-2">Correcta</span>
                                                                                    @endif
                                                                                    @if ($esSeleccionada && !$esCorrecta)
                                                                                        <span
                                                                                            class="badge bg-danger ms-2">Tu
                                                                                            respuesta</span>
                                                                                    @elseif($esSeleccionada && $esCorrecta)
                                                                                        <span
                                                                                            class="badge bg-success ms-2">Tu
                                                                                            respuesta</span>
                                                                                    @endif
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                        <div class="mt-2">
                                                                            <span class="fw-bold">Valor obtenido:
                                                                            </span>
                                                                            <span
                                                                                class="{{ $respuesta['valor_respuesta'] > 0 ? 'text-success' : 'text-danger' }}">
                                                                                {{ $respuesta['valor_respuesta'] }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <div class="alert alert-primary fw-bold text-center">
                                                                    Puntaje total obtenido: {{ $puntajeTotal }}
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-warning">No hay respuestas
                                                                registradas para este intento.</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            examen {{-- Si no hay intentos en progreso ni finalizados, pero quedan intentos --}}
                        @elseif(($intentos ?? 0) > 0)
                            <section class="welcome-boxed bol-bol-bg">
                                <div class="container-fluid">
                                    <div class="row no-gutters ">
                                        <div class="col-md-12">
                                            <div class="wellcome-area-wrapper ">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-5 col-xl-6">
                                                        <div class="wellcome-content wow fadeInUp"
                                                            data-wow-delay=".5s">
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
                                                        <div class="wellcome-content wow fadeInUp"
                                                            data-wow-delay=".5s">
                                                            <h2
                                                                class="font-orange area-heading display-6 fw-bold mb-3">
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

    {{-- Historial de exámenes finalizados --}}
    <section class="kids-care-event-area">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-red">Historial de exámenes finalizados</h2>
                </div>
            </div>
            <div class="inner-container">
                <div class="row justify-content-center">
                    @php
                        $imagenes = [
                            asset('assets/img/panel/event-1.jpg'),
                            asset('assets/img/panel/event-2.jpg'),
                            asset('assets/img/panel/event-3.jpg'),
                            asset('assets/img/panel/event-4.jpg'),
                        ];
                    @endphp
                    @foreach ($intentosConRespuestas as $idx => $registro)
    @php
        $respuestas = $registro['respuesta_json']
            ? json_decode($registro['respuesta_json'], true)
            : [];
        $puntajeTotal = array_sum(array_column($respuestas, 'valor_respuesta'));
        $examenTitulo = $evaluacion->titulo ?? 'Examen';
        $fechaFin = $registro['fecha_respuesta']
            ? \Carbon\Carbon::parse($registro['fecha_respuesta'])->format('d/m/Y H:i')
            : '-';
        $img = $imagenes[$idx % count($imagenes)];
        $calificacion = $registro['calificacion'] ?? null;
    $estado = $calificacion->estado ?? null;
    $colorEstado = $estado === 'Aprobado' ? 'bg-success text-white' : 'bg-danger text-white';
    $textoEstado = $estado ? strtoupper($estado) : 'SIN ESTADO';
    $puntaje = $calificacion ? "{$calificacion->puntaje_total}/{$calificacion->puntaje_maximo}" : "{$puntajeTotal}";
    @endphp
                        @if ($registro['respuesta_json'])
        <div class="col-sm-6 col-xl-3 d-flex justify-content-center">
            <div class="single-event wow fadeInUp" data-wow-delay=".5s">
                <img src="{{ $img }}" alt="">
                <div class="intro d-flex justify-content-between align-items-center">
                    <div class="intro-left text-center">
                        <h3><a href="#">{{ $examenTitulo }}</a></h3>
                        <span>{{ $fechaFin }}</span>
                    </div>
                    <div class="intro-right ms-2">
                        <span class="age {{ $colorEstado }} px-3 py-1 rounded-pill d-block mb-1">
                            {{ $textoEstado }}
                        </span>
                        <span class="fw-bold d-block text-dark">
                            Puntaje: {{ $puntaje }}
                        </span>
                    </div>
                </div>
                <div class="details">
                    <div class="event-btn">
                        <a href="javascript:void(0);"
                            onclick="verRevision('{{ route('examen.revision', ['intento_id' => $registro['intento']->id]) }}')"
                            class="kids-care-btn bgc-orange">
                            Ver revisión del examen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
                    @if (count($intentosConRespuestas) == 0)
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No tienes exámenes finalizados aún.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <div id="revisionFullScreen"
        style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:#fff; z-index:9999;">
        <button onclick="cerrarRevision()" class="btn btn-danger m-3 position-absolute"
            style="z-index:10001; right:20px; top:20px;">Cerrar revisión</button>
        <iframe id="iframeRevision" src="" width="100%" height="100%" frameborder="0"
            style="border: none; min-height:100vh; background:#fff;"></iframe>
    </div>
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
        function verRevision(url) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Si ves la revisión, ya no podrás enviar más intentos para este examen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, ver revisión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.body.style.overflow = 'hidden';
                    document.getElementById('revisionFullScreen').style.display = 'block';
                    document.getElementById('iframeRevision').src = url;
                    // Aquí puedes llamar a una función para ocultar el botón de nuevo intento si quieres hacerlo por JS
                    ocultarBotonNuevoIntento();
                }
            });
        }

        function cerrarRevision() {
            document.body.style.overflow = '';
            document.getElementById('revisionFullScreen').style.display = 'none';
            document.getElementById('iframeRevision').src = '';
        }
        function ocultarBotonNuevoIntento() {
            var btn = document.getElementById('btnNuevoIntento');
            if (btn) btn.style.display = 'none';
        }
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
