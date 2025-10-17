<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
    <link rel="stylesheet" href="{{ asset('css/panel/unidad_show.css') }}">
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

    <!--Breadcrumb area start-->
    <div class="text-bread-crumb d-flex align-items-center style-six blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $unidad->nombre }}</h2>
                    <div class="bread-crumb-line">
                        <span><a href="{{ route('unidades.index') }}">Unidades</a></span> /
                        <span>{{ $unidad->nombre }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    <!-- Mensajes de estado -->
    @if (session('mensaje'))
        <div class="container-fluid mt-3">
            <div class="alert alert-{{ session('icono', 'success') }} alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Botones de acción -->
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-warning btn-action" onclick="editarUnidad()">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button type="button" class="btn btn-info btn-action" onclick="previsualizarUnidad()">
                            <i class="fas fa-eye"></i> Previsualizar
                        </button>
                        <button type="button" class="btn btn-success btn-action" onclick="publicarUnidad()">
                            <i class="fas fa-share"></i> Publicar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-12">

                <!-- Información General -->
                <div class="card shadow-sm mb-4">
                    <h5 class="section-header">
                        <i class="fas fa-info-circle"></i> Información General
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card card p-3 mb-3">
                                    <h6><i class="fas fa-bookmark text-primary"></i> Nombre de la Unidad</h6>
                                    <p class="mb-0 fw-bold">{{ $unidad->nombre }}</p>
                                </div>
                                <div class="info-card card p-3 mb-3">
                                    <h6><i class="fas fa-graduation-cap text-success"></i> Grado y Secciones</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success badge-custom">{{ $unidad->grado }}</span>
                                        @if ($unidad->secciones && count($unidad->secciones) > 0)
                                            @foreach ($unidad->secciones as $seccion)
                                                <span class="badge bg-info badge-custom">{{ $seccion }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted small">Sin secciones</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card card p-3 mb-3">
                                    <h6><i class="fas fa-calendar-alt text-warning"></i> Fechas</h6>
                                    <p class="mb-1"><strong>Inicio:</strong>
                                        {{ $unidad->fecha_inicio->format('d/m/Y') }}</p>
                                    <p class="mb-0"><strong>Fin:</strong> {{ $unidad->fecha_fin->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="info-card card p-3 mb-3">
                                    <h6><i class="fas fa-chalkboard-teacher text-primary"></i> Profesores Responsables
                                    </h6>
                                    @if ($profesores->count() > 0)
                                        @foreach ($profesores as $profesor)
                                            <span
                                                class="badge bg-primary badge-custom d-block mb-1">{{ $profesor['nombre_completo'] }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No asignados</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Situación Significativa y Productos -->
                <div class="card shadow-sm mb-4">
                    <h5 class="section-header">
                        <i class="fas fa-lightbulb"></i> Situación Significativa y Productos
                    </h5>
                    <div class="card-body">
                        <div class="content-section">
                            <h6><i class="fas fa-exclamation-circle text-warning"></i> Situación Significativa</h6>
                            <p class="text-justify">{{ $unidad->situacion_significativa }}</p>
                        </div>
                        <div class="content-section">
                            <h6><i class="fas fa-box-open text-success"></i> Productos Esperados</h6>
                            <p class="text-justify">{{ $unidad->productos }}</p>
                        </div>
                    </div>
                </div>
<!-- Contenido Curricular -->
                
                <!-- Contenido Curricular -->
                @if (count($cursosInfo) > 0)
                    <div class="card shadow-sm mb-4">
                        <h5 class="section-header">
                            <i class="fas fa-book me-2"></i> Contenido Curricular
                        </h5>
                        <div class="card-body">
                            <div class="contenido-curricular-container">
                                @foreach ($cursosInfo as $index => $cursoInfo)
                                    <div class="curso-block-show">
                                        <div class="curso-header-show">
                                            <h6>
                                                <i class="fas fa-graduation-cap me-2"></i>
                                                {{ $index + 1 }}. {{ $cursoInfo['curso']->curso }}
                                            </h6>
                                        </div>
                                        <div class="curso-body-show">
                                            @if (count($cursoInfo['competencias']) > 0)
                                                @foreach ($cursoInfo['competencias'] as $compIndex => $competenciaInfo)
                                                    <div class="competencia-block-show">
                                                        <div class="competencia-header-show">
                                                            <h6>
                                                                <i class="fas fa-target me-2"></i>
                                                                Competencia {{ $compIndex + 1 }}: {{ $competenciaInfo['competencia']->nombre }}
                                                            </h6>
                                                        </div>
                                                        <div class="competencia-content-show">
                                                            <!-- Capacidades -->
                                                            @if ($competenciaInfo['capacidades']->count() > 0)
                                                                <div class="capacidades-section-show">
                                                                    <div class="section-title text-success">
                                                                        <i class="fas fa-puzzle-piece me-2"></i>Capacidades
                                                                    </div>
                                                                    <div>
                                                                        @foreach ($competenciaInfo['capacidades'] as $capacidad)
                                                                            <span class="badge-capacidad">
                                                                                {{ $capacidad->nombre }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Desempeños -->
                                                            @if ($competenciaInfo['desempenos']->count() > 0)
                                                                <div class="desempenos-section-show">
                                                                    <div class="section-title text-info">
                                                                        <i class="fas fa-chart-line me-2"></i>Desempeños
                                                                    </div>
                                                                    @foreach ($competenciaInfo['desempenos'] as $desempeno)
                                                                        <div class="desempeno-item">
                                                                            <i class="fas fa-chevron-right text-info me-2"></i>
                                                                            {{ $desempeno->descripcion }}
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- Información de Evaluación -->
                                                            <div class="evaluacion-grid">
                                                                <div class="evaluacion-card criterios-card">
                                                                    <div class="evaluacion-title text-warning">
                                                                        <i class="fas fa-clipboard-check"></i>
                                                                        Criterios de Evaluación
                                                                    </div>
                                                                    <div class="evaluacion-content">
                                                                        {{ $competenciaInfo['criterios'] ?: 'No especificado' }}
                                                                    </div>
                                                                </div>

                                                                <div class="evaluacion-card evidencias-card">
                                                                    <div class="evaluacion-title text-danger">
                                                                        <i class="fas fa-file-alt"></i>
                                                                        Evidencias de Aprendizaje
                                                                    </div>
                                                                    <div class="evaluacion-content">
                                                                        {{ $competenciaInfo['evidencias'] ?: 'No especificado' }}
                                                                    </div>
                                                                </div>

                                                                <div class="evaluacion-card instrumentos-card">
                                                                    <div class="evaluacion-title text-secondary">
                                                                        <i class="fas fa-tools"></i>
                                                                        Instrumentos de Evaluación
                                                                    </div>
                                                                    <div class="evaluacion-content">
                                                                        @if (is_array($competenciaInfo['instrumentos']) && count($competenciaInfo['instrumentos']) > 0)
                                                                            @foreach ($competenciaInfo['instrumentos'] as $instrumento)
                                                                                <span class="badge-instrumento">
                                                                                    {{ $instrumento }}
                                                                                </span>
                                                                            @endforeach
                                                                        @else
                                                                            <span class="text-muted">No especificado</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="no-content-message">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    No hay competencias definidas para este curso.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm mb-4">
                        <h5 class="section-header">
                            <i class="fas fa-book me-2"></i> Contenido Curricular
                        </h5>
                        <div class="card-body">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-book-open fa-3x mb-3"></i>
                                <p>No se ha definido contenido curricular para esta unidad.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Enfoques Transversales -->
                @if (count($enfoquesInfo) > 0)
                    <div class="card shadow-sm mb-4">
                        <h5 class="section-header">
                            <i class="fas fa-arrows-alt"></i> Enfoques Transversales
                        </h5>
                        <div class="card-body">
                            @foreach ($enfoquesInfo as $enfoqueInfo)
                                <div class="enfoque-card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-compass text-info"></i>
                                            {{ $enfoqueInfo['enfoque']->nombre }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if (count($enfoqueInfo['valores']) > 0)
                                            @foreach ($enfoqueInfo['valores'] as $valor)
                                                <div class="valor-item">
                                                    <strong>Valor:</strong> {{ $valor['valor'] }}
                                                    <p class="mb-0 small"><strong>Actitud:</strong>
                                                        {{ $valor['actitud'] }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No hay valores definidos</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Materiales y Recursos -->
                @if ($materialesBasicos || $recursos)
                    <div class="card shadow-sm mb-4">
                        <h5 class="section-header">
                            <i class="fas fa-tools"></i> Materiales y Recursos
                        </h5>
                        <div class="card-body">
                            <div class="row">
                                @if ($materialesBasicos)
                                    <div class="col-md-6">
                                        <div class="content-section">
                                            <h6><i class="fas fa-hammer text-warning"></i> Materiales Básicos</h6>
                                            <p class="text-justify">{{ $materialesBasicos }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($recursos)
                                    <div class="col-md-6">
                                        <div class="content-section">
                                            <h6><i class="fas fa-laptop text-info"></i> Recursos</h6>
                                            <p class="text-justify">{{ $recursos }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function editarUnidad() {
            // Aquí implementarás la funcionalidad para editar
            alert('Función de editar - En desarrollo');
        }

        function previsualizarUnidad() {
            Swal.fire({
                title: '📄 Vista Previa del Documento',
                text: 'Seleccione el formato para previsualizar:',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-file-alt"></i> Vista Previa Vertical',
                cancelButtonText: '<i class="fas fa-file"></i> Vista Previa Horizontal',
                denyButtonText: '<i class="fas fa-times"></i> Cancelar',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#007bff',
                denyButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed || result.dismiss === Swal.DismissReason.cancel) {
                    const orientacion = result.isConfirmed ? 'vertical' : 'horizontal';

                    // Abrir vista previa en nueva ventana
                    const ventanaPrevia = window.open(
                        `/unidades/{{ $unidad->id }}/vista-previa?orientacion=${orientacion}`,
                        'vistaPreviaUnidad',
                        'width=1200,height=800,scrollbars=yes,resizable=yes'
                    );

                    if (ventanaPrevia) {
                        ventanaPrevia.focus();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo abrir la ventana de vista previa. Verifique que no esté bloqueando pop-ups.',
                            icon: 'error'
                        });
                    }
                }
            });
        }

        function publicarUnidad() {
            if (confirm(
                    '¿Está seguro de que desea publicar esta unidad? Una vez publicada, estará disponible para los estudiantes.'
                )) {
                // Aquí implementarás la funcionalidad para publicar
                alert('Función de publicar - En desarrollo');
            }
        }
    </script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
