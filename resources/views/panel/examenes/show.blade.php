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
                                                            @if (($intentos ?? 0) > 0 && (!$ultimoIntento || !$ultimoIntento->revision_vista))
                                                                <a href="{{ route('evaluacion.iniciar', $evaluacion->id) }}"
                                                                    class="btn btn-primary mt-3" id="btnNuevoIntento">
                                                                    Hacer nuevo intento
                                                                </a>
                                                            @endif
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
    @if ($roleId == 3)
        {{-- Historial de exámenes finalizados --}}
        @if (!$intentoEnProceso)
            <intentos_evaluacion <div class="container-fluid custom-container">
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
                                $colorEstado =
                                    $estado === 'Aprobado' ? 'bg-success text-white' : 'bg-danger text-white';
                                $textoEstado = $estado ? strtoupper($estado) : 'SIN ESTADO';
                                $puntaje = $calificacion
                                    ? "{$calificacion->puntaje_total}/{$calificacion->puntaje_maximo}"
                                    : "{$puntajeTotal}";
                            @endphp
                            @if ($registro['respuesta_json'])
                                <div class="col-sm-6 col-xl-3 d-flex justify-content-center">
                                    <div class="single-event wow fadeInUp position-relative" data-wow-delay=".5s">
                                        <img src="{{ $img }}" alt="">
                                        <span
                                            class="badge-intento position-absolute top-0 start-0 translate-middle-y ms-3 mt-3">
                                            <span class="num-intento">{{ $loop->iteration }}</span>
                                            <span class="txt-intento">intento</span>
                                        </span>
                                        <div class="intro d-flex justify-content-between align-items-center">
                                            <div class="intro-left text-center">
                                                <h3><a href="#">{{ $examenTitulo }}</a></h3>
                                                <span>{{ $fechaFin }}</span>
                                            </div>
                                            <div class="intro-right ms-2">
                                                <span
                                                    class="age {{ $colorEstado }} px-3 py-1 rounded-pill d-block mb-1">
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
                                                    onclick="verRevision('{{ route('examen.revision', ['intento_id' => $registro['intento']->id]) }}', {{ $intentos ?? 0 }}, {{ $registro['intento']->revision_vista ? 'true' : 'false' }})"
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
            @else
                <div class="alert alert-warning text-center my-4">
                    Tienes un examen en proceso. Finalízalo antes de ver tu historial.
                </div>
        @endif
    @endif

    @if ($roleId == 2)
        <section class="kids-care-event-area">
            <div class="container-fluid custom-container">
                <div class="row">
                    <div class="col-xl-12">
                        <h2 class="area-heading font-red">Historial de estudiantes</h2>
                    </div>
                </div>
                <div class="inner-container">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-historial-estudiantes">
                            <thead class="table-light">
                                <tr>
                                    <th>Avatar</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Estado</th>
                                    <th>Puntaje</th>
                                    <th>Intentos realizados</th>
                                    <th>Porcentaje</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $estudiante)
                                    @php

                                        $persona = $estudiante->persona;
                                        $intentos = $estudiante->intentos ?? [];
                                        $ultimoIntento = $intentos->last();
                                        $mejorIntento = $intentos
                                            ->sortByDesc(function ($i) {
                                                return $i->calificacion->puntaje_total ?? 0;
                                            })
                                            ->first();

                                        $estado = $ultimoIntento ? ucfirst($ultimoIntento->estado) : 'Sin intento';
                                        $puntaje =
                                            $mejorIntento && $mejorIntento->calificacion
                                                ? $mejorIntento->calificacion->puntaje_total
                                                : 0;
                                        $puntajeMax =
                                            $mejorIntento && $mejorIntento->calificacion
                                                ? $mejorIntento->calificacion->puntaje_maximo
                                                : 0;
                                        $porcentaje = $puntajeMax > 0 ? round(($puntaje / $puntajeMax) * 100) : 0;
                                        $estadoCalificacion =
                                            $mejorIntento && $mejorIntento->calificacion
                                                ? strtoupper($mejorIntento->calificacion->estado)
                                                : 'SIN ESTADO';
                                        $colorEstado = $estadoCalificacion === 'APROBADO' ? 'bg-success' : 'bg-danger';
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . ($estudiante->avatar?->path ?? 'avatares/avatar_defecto.png')) }}"
                                                alt="Avatar del estudiante" class="avatar-img">
                                        </td>
                                        <td class="nombre">{{ $persona->nombre ?? '-' }}</td>
                                        <td class="apellido">{{ $persona->apellido ?? '-' }}</td>
                                        <td>
                                            @if ($estado == 'En progreso')
                                                <span class="badge bg-warning text-dark">{{ $estado }}</span>
                                            @elseif($estado == 'Finalizado')
                                                <span class="badge bg-success">{{ $estado }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $estado }}</span>
                                            @endif
                                        </td>
                                        @php
                                            $badgeEstado = 'badge ';
                                            if ($estadoCalificacion === 'APROBADO') {
                                                $badgeEstado .= 'bg-success text-white';
                                            } elseif ($estadoCalificacion === 'DESAPROBADO') {
                                                $badgeEstado .= 'bg-danger text-white';
                                            } elseif ($estadoCalificacion === 'SIN ESTADO') {
                                                $badgeEstado .= 'bg-primary text-white';
                                            } else {
                                                $badgeEstado .= 'bg-secondary text-white';
                                            }
                                        @endphp
                                        <td>{{ $puntaje }}/{{ $puntajeMax }}</td>

                                        <td>{{ $intentos->count() }}</td>
                                        <td style="min-width:120px;">
                                            <div class="progress" style="height: 22px;">
                                                <div class="progress-bar {{ $colorEstado }}" role="progressbar"
                                                    style="width: {{ $porcentaje }}%;"
                                                    aria-valuenow="{{ $porcentaje }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $porcentaje }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="{{ $badgeEstado }}">{{ $estadoCalificacion }}</span>
                                        </td>
                                        <td>
                                            @if ($ultimoIntento)
                                                @if ($ultimoIntento->estado === 'finalizado')
                                                    <a href="javascript:void(0);"
                                                        onclick="verRevision('{{ route('examen.revision', ['intento_id' => $ultimoIntento->id]) }}', {{ $intentos ?? 0 }}, {{ $ultimoIntento->revision_vista ? 'true' : 'false' }})"
                                                        class="btn btn-sm btn-info" title="Ver revisión">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger ms-1"
                                                        onclick="confirmarEliminarIntento({{ $ultimoIntento->id }})"
                                                        title="Eliminar intento">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @else
                                                    <span class="text-warning">En proceso...</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Sin intento</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <div id="revisionFullScreen"
        style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:#fff; z-index:9999;">
        <button onclick="cerrarRevision()" class="btn btn-danger m-3 position-absolute"
            style="z-index:10001; right:20px; top:20px;">Cerrar revisión</button>
        <iframe id="iframeRevision" src="" width="100%" height="100%" frameborder="0"
            style="border: none; min-height:100vh; background:#fff;">
        
        </iframe>
                               
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

        function verRevision(url, quedanIntentos, revisionVista) {
            // Si es docente, abre directamente la revisión
            @if ($roleId == 2)
                abrirRevision(url);
                return;
            @endif

            // Para estudiantes, sigue la lógica normal
            if (quedanIntentos <= 0 || revisionVista) {
                abrirRevision(url);
                return;
            }
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Si ves la revisión, ya no podrás enviar más intentos para este examen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, ver revisión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    abrirRevision(url);
                }
            });
        }

        function abrirRevision(url) {
            document.body.style.overflow = 'hidden';
            document.getElementById('revisionFullScreen').style.display = 'block';
            document.getElementById('iframeRevision').src = url;
            ocultarBotonNuevoIntento();
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

        function confirmarEliminarIntento(intentoId) {
            Swal.fire({
                title: '¿Eliminar intento?',
                text: 'Esta acción eliminará el ÚLTIMO intento, su calificación y sus respuestas. ¿Deseas continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarIntento(intentoId);
                }
            });
        }

        function eliminarIntento(intentoId) {
            fetch("{{ url('/intentos') }}/" + intentoId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', 'No se pudo eliminar el intento.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo eliminar el intento.', 'error');
                });
        }
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
    {{-- ...existing code... --}}
    {{-- ...existing code... --}}


</body>

</html>
