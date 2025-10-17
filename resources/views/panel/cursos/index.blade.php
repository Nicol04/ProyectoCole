<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
</head>
<body>
    <div class="preloader"></div>
    
    @if(auth()->check())
    @php
        $roleId = auth()->user()->roles->first()?->id;
    @endphp

    @if($roleId == 3)
        @include('panel.includes.menu_estudiante')
    @elseif($roleId == 2)
        @include('panel.includes.menu_docente')
    @endif
@endif

    <!--CURSOS area Start-->
    <div class="image-breadcrumb">CURSOS</div>
    <div class="text-bread-crumb d-flex align-items-center bgc-orange">
        <div class="container-fluid">
            <div class="bread-crumb-line" style="text-align: center;"> AULA:
                {{ $aula->grado ?? 'Grado no asignado' }} {{ $aula->seccion ?? '' }}<br>
                <a> Docente: {{ $nombreDocente ?? 'No asignado' }}</a>
            </div>
        </div>
    </div>
    <!--CURSOS area end-->

    <!--Cursos area start-->
    <section class="kids-care-event-area">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading st-two font-red">CURSOS</h2>
                    <p class="area-subline">Aquí podrás ver todas las materias en tu salón. En cada curso encontrarás clases, tareas y evaluaciones que te ayudarán a aprender de forma divertida. ¡Haz clic y descubre todo lo que puedes aprender!</p>
                </div>
            </div>

            <!-- Sección de Unidades de Aprendizaje -->
            @if($roleId == 2)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-list"></i> Unidades de Aprendizaje
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-2">Gestión de Unidades Didácticas</h6>
                                    <p class="text-muted mb-0">
                                        Las unidades de aprendizaje integran todos los cursos y competencias. 
                                        Aquí puedes crear y gestionar las unidades didácticas para tu grado.
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                                        <a href="{{ route('unidades.index') }}" class="btn btn-success">
                                            <i class="fas fa-eye"></i> Ver Unidades
                                        </a>
                                        <a href="{{ route('unidades.create') }}" class="btn btn-outline-success">
                                            <i class="fas fa-plus"></i> Crear Unidad
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    
            <div class="row">
                @foreach ($cursos as $index => $curso)
                    @php
                        $backgroundColors = ['bg-green', 'bg-orange', 'bg-red', 'bg-sky'];
                        $bgColor = $backgroundColors[$index % count($backgroundColors)];
                        $imageUrl = $curso->image_url ? asset('storage/' . $curso->image_url) : asset('assets/img/panel/facilities/curso_defecto.jpg');
                    @endphp
                    <div class="col-sm-6 col-xl-3">
                        <div class="sin-upc-event-two">
                            <div class="sp-age {{ $bgColor }}">
                                <p>Curso</p>
                            </div>
                            <img src="{{ $imageUrl }}" alt="{{ $curso->curso }}">
                            <div class="sin-up-content">
                                <h6>{{ $curso->curso }}</h6>
                                <p>{{ Str::limit($curso->descripcion, 100) }}</p>
                                    <a class="{{ $bgColor }}" href="{{ route('curso.show', ['id' => $curso->id]) }}">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--Cursos area end-->

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
