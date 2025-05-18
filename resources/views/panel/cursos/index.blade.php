<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
</head>
<body>
    <div class="preloader"></div>
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
                                    <a class="{{ $bgColor }}" href="{{ route('sesiones.index', ['id' => $curso->id]) }}">Ver más</a>
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
