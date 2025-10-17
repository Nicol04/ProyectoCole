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

    <!--Breadcrumb area start-->
    <div class="text-bread-crumb d-flex align-items-center style-six">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $curso->curso }}</h2>
                    <div class="bread-crumb-line">
                        <span><a href="{{ route('panel.cursos') }}">Cursos / </a></span>{{ $curso->curso }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    <!-- Información del curso -->
    <section class="kids-care-event-area py-5">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-book"></i> {{ $curso->curso }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-card mb-3">
                                        <h6><i class="fas fa-info-circle text-info"></i> Descripción</h6>
                                        <p class="text-muted">{{ $curso->descripcion ?? 'Sin descripción disponible' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card mb-3">
                                        <h6><i class="fas fa-graduation-cap text-success"></i> Información del Aula</h6>
                                        <p class="mb-1"><strong>Grado:</strong> {{ $aula->grado ?? 'No asignado' }}</p>
                                        <p class="mb-1"><strong>Sección:</strong> {{ $aula->seccion ?? 'No asignado' }}</p>
                                        <p class="mb-0"><strong>Docente:</strong> {{ $nombreDocente }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Opciones del curso -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                                    <h5>Sesiones de Clase</h5>
                                    <p class="text-muted">Ver y crear sesiones de aprendizaje</p>
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('sesiones.index', $curso->id) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i> Ver Sesiones
                                        </a>
                                        @if(auth()->user()->roles->first()?->id == 2 && $aulaCurso)
                                        <a href="{{ route('sesiones.create', ['aula_curso_id' => $aulaCurso->id]) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-plus"></i> Crear Sesión
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(auth()->user()->roles->first()?->id == 2)
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                                    <h5>Fichas de Aprendizaje</h5>
                                    <p class="text-muted">Crear y gestionar fichas didácticas</p>
                                    <a href="#" class="btn btn-info">
                                        <i class="fas fa-plus"></i> Crear Ficha
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
