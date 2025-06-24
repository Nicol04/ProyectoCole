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
    <div class="text-bread-crumb d-flex align-items-center style-nine">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="font-sky">Calificaciones del aula {{ $aula->grado }} {{ $aula->seccion }} </h2>
                </div>

            </div>
        </div>
    </div>
    <!--Text breadcrumb area start-->
    <!--Shop area start-->
    <section class="shop-area-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-9">
                    <div class="shop-sorting">
                        <div class="sort-by">
                            <label>Filtrar por:</label>
                            <form method="GET">
                                <select name="estudiante" onchange="this.form.submit()">
                                    <option value="">-- Todos --</option>
                                    @foreach ($todosLosEstudiantes as $e)
                                        @php
                                            $nombreCompleto = $e->persona->nombre . ' ' . $e->persona->apellido;
                                        @endphp
                                        <option value="{{ $nombreCompleto }}"
                                            {{ request('estudiante') == $nombreCompleto ? 'selected' : '' }}>
                                            {{ $nombreCompleto }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="shop-product-area tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="home">
                            <div class="row">
                                <table
                                    class="table table-bordered align-middle table-historial-estudiantes shadow-sm rounded">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Estudiante</th>
                                            <th>Curso</th>
                                            <th>Evaluación</th>
                                            <th>Puntaje obtenido</th>
                                            <th>Puntaje máximo</th>
                                            <th>Porcentaje</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($estudiantes as $estudiante)
                                            @php
                                                $calificaciones = $calificacionesPorEstudiante[$estudiante->id] ?? [];
                                            @endphp

                                            @forelse ($calificaciones as $calificacion)
                                                @php
                                                    $puntaje = $calificacion['puntaje_total'];
                                                    $puntajeMax = $calificacion['puntaje_maximo'];
                                                    $porcentaje =
                                                        $puntajeMax > 0 ? round(($puntaje / $puntajeMax) * 100) : 0;
                                                    $estadoCalificacion = strtoupper($calificacion['estado']);
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
                                                <tr>
                                                    <td>{{ $estudiante->persona->nombre }}
                                                        {{ $estudiante->persona->apellido }}</td>
                                                    <td>{{ $calificacion['curso'] }}</td>
                                                    <td>{{ $calificacion['evaluacion'] }}</td>
                                                    <td class="text-center fw-bold">{{ $puntaje }}</td>
                                                    <td class="text-center">{{ $puntajeMax }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-bold">{{ $porcentaje }}%</span>
                                                            <div class="progress flex-grow-1"
                                                                style="height: 18px; min-width: 80px;">
                                                                <div class="progress-bar 
                                @if ($porcentaje >= 70) bg-success 
                                @elseif($porcentaje >= 50) bg-warning 
                                @else bg-danger @endif"
                                                                    role="progressbar"
                                                                    style="width: {{ $porcentaje }}%;"
                                                                    aria-valuenow="{{ $porcentaje }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($calificacion['fecha_fin'])
                                                            {{ \Carbon\Carbon::parse($calificacion['fecha_fin'])->format('d/m/Y H:i') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="{{ $badgeEstado }}">{{ ucfirst(strtolower($estadoCalificacion)) }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if (isset($calificacion['intento_id']))
                                                            <a href="javascript:void(0);"
                                                                onclick="verRevision('{{ route('examen.revision', ['intento_id' => $calificacion['intento_id']]) }}', {{ $calificacion['intentos'] ?? 0 }}, {{ $calificacion['revision_vista'] ? 'true' : 'false' }})"
                                                                class="btn btn-sm btn-info" title="Ver revisión">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>{{ $estudiante->persona->nombre }}
                                                        {{ $estudiante->persona->apellido }}</td>
                                                    <td colspan="8" class="text-center text-muted">Sin
                                                        calificaciones
                                                        registradas</td>
                                                </tr>
                                            @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No hay estudiantes
                                                    registrados en
                                                    esta aula.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $estudiantes->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--Shop sidebar area start-->
                <div class="col-md-10 col-lg-4 col-xl-3">
                    <div class="shop-search-box">
                        <form id="form-busqueda" method="GET" autocomplete="off">

                            <div class="input-group" id="search">
                                <input name="buscar" class="form-control" placeholder="Buscar por evaluación"
                                    type="text" value="{{ request('buscar') }}">
                                <button class="btn btn-default button-search" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="sort-area-sin">
                        <h5>Filtrar por curso</h5>
                        <ul class="sort-by-age">
                            <li class="{{ !request('curso') ? 'checked' : '' }}">
                                <a href="{{ request()->fullUrlWithQuery(['curso' => null]) }}">
                                    @if (!request('curso'))
                                        <i class="fa fa-check-circle"></i>
                                    @else
                                        <i class="fa fa-circle-o"></i>
                                    @endif
                                    Todos
                                    <span class="bgc-orange">{{ array_sum($cursosContados) }}</span>
                                </a>
                            </li>

                            @foreach ($cursosAula as $curso)
                                <li class="{{ request('curso') == $curso->curso ? 'checked' : '' }}">
                                    <a href="{{ request()->fullUrlWithQuery(['curso' => $curso->curso]) }}">
                                        @if (request('curso') == $curso->curso)
                                            <i class="fa fa-check-circle"></i>
                                        @else
                                            <i class="fa fa-circle-o"></i>
                                        @endif
                                        {{ $curso->curso }}
                                        <span class="bgc-orange">
                                            {{ $cursosContados[$curso->curso] ?? 0 }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!--sort by age-->
                    <div class="sort-area-sin">
                        <h5>Filtrar por estado</h5>
                        <ul class="tag">
                            <li class="{{ !request('estado') ? 'checked' : '' }}">
                                <a href="{{ request()->fullUrlWithQuery(['estado' => null]) }}">Todos</a>
                            </li>
                            <li class="{{ request('estado') == 'aprobado' ? 'checked' : '' }}">
                                <a href="{{ request()->fullUrlWithQuery(['estado' => 'aprobado']) }}">Aprobado</a>
                            </li>
                            <li class="{{ request('estado') == 'desaprobado' ? 'checked' : '' }}">
                                <a
                                    href="{{ request()->fullUrlWithQuery(['estado' => 'desaprobado']) }}">Desaprobado</a>
                            </li>
                        </ul>

                    </div>
                    <div class="sort-area-sin">
                        <h5>Filtrar por fecha</h5>
                        <form method="GET" action="" id="formFiltroFecha">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha exacta:</label>
                                <div class="input-group">
                                    <input type="date" name="fecha" id="fecha" class="form-control"
                                        value="{{ request('fecha') }}">
                                    <button type="button" class="btn btn-outline-secondary" id="clearFecha"
                                        title="Limpiar fecha exacta">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-2 text-center fw-bold text-secondary">o</div>
                            <div class="mb-2">
                                <label for="fecha_inicio" class="form-label">Desde:</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                    value="{{ request('fecha_inicio') }}">
                            </div>
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Hasta:</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                    value="{{ request('fecha_fin') }}">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">
                                    <i class="fa fa-search"></i> Filtrar
                                </button>
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary"
                                    title="Quitar filtros">
                                    <i class="fa fa-eraser"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                    <!--Best Product-->
                    <div class="sort-area-sin">
                        <h5>Mejores estudiantes</h5>

                        @forelse ($mejoresEstudiantes as $item)
                            @php
                                $e = $item['estudiante'];
                                $persona = $e->persona;
                                $promedio = $item['promedio'];
                                $avatarPath = $e->avatar?->path ?? 'avatares/avatar_defecto.png';
                            @endphp

                            <div class="sidebar-sin-pro mb-3 d-flex align-items-center">
                                <div class="sm-img me-2">
                                    <img src="{{ asset('storage/' . $avatarPath) }}"
                                        alt="Avatar de {{ $persona->nombre }}" width="60" height="60"
                                        class="rounded-circle object-fit-cover">
                                </div>
                                <div class="sm-img-right">
                                    <h6 class="mb-1">{{ $persona->nombre }} {{ $persona->apellido }}</h6>
                                    <p class="mb-0 text-muted">Promedio: {{ $promedio }}%</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No registrado</p>
                        @endforelse
                    </div>
                </div>
                <!--Shop sidebar area end-->
            </div>
        </div>
    </section>
    <!--Shop area end-->
    <div id="revisionFullScreen"
        style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:#fff; z-index:9999;">
        <button onclick="cerrarRevision()" class="btn btn-danger m-3 position-absolute"
            style="z-index:10001; right:20px; top:20px;">Cerrar revisión</button>
        <iframe id="iframeRevision" src="" width="100%" height="100%" frameborder="0"
            style="border: none; min-height:100vh; background:#fff;">

        </iframe>
    </div>
    <script>
        // Si escribes en fecha exacta, limpia intervalo
        document.getElementById('fecha').addEventListener('input', function() {
            if (this.value) {
                document.getElementById('fecha_inicio').value = '';
                document.getElementById('fecha_fin').value = '';
            }
        });
        // Si escribes en intervalo, limpia fecha exacta
        document.getElementById('fecha_inicio').addEventListener('input', function() {
            if (this.value) document.getElementById('fecha').value = '';
        });
        document.getElementById('fecha_fin').addEventListener('input', function() {
            if (this.value) document.getElementById('fecha').value = '';
        });
        // Botón para limpiar fecha exacta
        document.getElementById('clearFecha').addEventListener('click', function() {
            document.getElementById('fecha').value = '';
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
    </script>
</body>
@include('panel.includes.footer3')
@include('panel.includes.footer')

</body>

</html>
