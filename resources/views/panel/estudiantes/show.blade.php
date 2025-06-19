<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>
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
<div class="image-breadcrumb nu-bc"> </div>
@if ($roleId != 3)
    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center bgc-orange">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }} <span>(
                            {{ $estudiante->name }} )</span></h2>
                    <div class="bread-crumb-line"><span><a href="/panel/estudiantes">Estudiantes
                                /</a></span>Calificaciones
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <a href="#" class="kids-care-btn bg-sky f14">Descargar calificaciones</a>
                </div>

            </div>
        </div>
    </section>
@endif
<section class="shop-area-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- Columna principal: Tabla -->
            <div class="col-lg-8 col-xl-9">
                <div class="shop-sorting">
                    <ul class="nav grid-list-button" role="tablist">
                        <li role="presentation"><a class="active" href="#home" aria-controls="home" role="tab"
                                data-toggle="tab"><i class="fa fa-th"></i></a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                data-toggle="tab"><i class="fa fa-th-list"></i></a></li>
                    </ul>

                    <div class="inner-container my-4">
                        <div class="d-flex align-items-center mb-4">
                            @if ($estudiante->avatar && $estudiante->avatar->path)
                                <img src="{{ asset('storage/' . $estudiante->avatar->path) }}" alt="Avatar"
                                    class="rounded-circle me-3" style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <img src="" alt="Avatar" class="rounded-circle me-3"
                                    style="width: 70px; height: 70px; object-fit: cover;">
                            @endif
                            <h3 class="mb-0">
                                Calificaciones de {{ $estudiante->persona->nombre }}
                                {{ $estudiante->persona->apellido }}
                                @if (auth()->check() && auth()->id() == $estudiante->id)
                                    <span class="text-primary">(yo)</span>
                                @endif
                            </h3>
                        </div>
                        <div class="shop-product-area tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="home">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered align-middle table-historial-estudiantes shadow-sm rounded">
                                        <thead class="table-light">
                                            <tr>
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
                                            @forelse($calificacionesPaginadas as $calificacion)
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
                                                    <td colspan="6" class="text-center">No hay calificaciones
                                                        registradas.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $calificacionesPaginadas->links() }}
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="profile">


                                <div class="row">
                                    @forelse($calificacionesPaginadas as $calificacion)
                                        @php
                                            $puntaje = $calificacion['puntaje_total'];
                                            $puntajeMax = $calificacion['puntaje_maximo'];
                                            $porcentaje = $puntajeMax > 0 ? round(($puntaje / $puntajeMax) * 100) : 0;
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
                                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2">{{ $calificacion['evaluacion'] }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">
                                                        {{ $calificacion['curso'] }}</h6>
                                                    <div class="mb-2">
                                                        <span class="fw-bold">Puntaje:</span>
                                                        <span class="fw-bold text-primary">{{ $puntaje }}</span> /
                                                        <span>{{ $puntajeMax }}</span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="fw-bold">Porcentaje:</span>
                                                        <span class="fw-bold">{{ $porcentaje }}%</span>
                                                        <div class="progress" style="height: 16px;">
                                                            <div class="progress-bar 
                                @if ($porcentaje >= 70) bg-success 
                                @elseif($porcentaje >= 50) bg-warning 
                                @else bg-danger @endif"
                                                                role="progressbar" style="width: {{ $porcentaje }}%;"
                                                                aria-valuenow="{{ $porcentaje }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="fw-bold">Fecha:</span>
                                                        @if ($calificacion['fecha_fin'])
                                                            {{ \Carbon\Carbon::parse($calificacion['fecha_fin'])->format('d/m/Y H:i') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="fw-bold">Estado:</span>
                                                        <span
                                                            class="{{ $badgeEstado }}">{{ ucfirst(strtolower($estadoCalificacion)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white border-0 text-end">
                                                    @if (isset($calificacion['intento_id']))
                                                        <a href="javascript:void(0);"
                                                            onclick="verRevision('{{ route('examen.revision', ['intento_id' => $calificacion['intento_id']]) }}', {{ $calificacion['intentos'] ?? 0 }}, {{ $calificacion['revision_vista'] ? 'true' : 'false' }})"
                                                            class="btn btn-sm btn-info" title="Ver revisión">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                No hay calificaciones registradas.
                                            </div>
                                        </div>
                                    @endforelse

                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $calificacionesPaginadas->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Columna sidebar: Filtro a la derecha -->
            <div class="col-md-10 col-lg-4 col-xl-3">
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
                            <a href="{{ request()->fullUrlWithQuery(['estado' => 'desaprobado']) }}">Desaprobado</a>
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
            </div>
        </div>
    </div>
</section>
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
<!--Text breadcrumb area start-->
@include('panel.includes.footer3')
@include('panel.includes.footer')

</body>

</html>
