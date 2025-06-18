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
    <div class="text-bread-crumb d-flex align-items-center style-six sc-page-bc">
        <div class="container-fluid">
            <div class="row">
                <h2>Evaluaciones</h2>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    @php
        $colores = ['bgc-orange', 'bg-blue', 'bg-green', 'bg-red'];
    @endphp
    <div class="our-class-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="area-heading font-per style-two">Evaluaciones a realizar!!</h1>
                    <p class="heading-para">Hola estudiante! aca encontrarás tus examenes que aún no has iniciado! Mucha
                        suerte :D</p>
                </div>
                <div class="row">
                    <!-- Filtro por curso a la izquierda -->
                    <div class="col-md-3 col-lg-3 mb-3">
                        <div class="sort-area-sin">
                            <h5>Filtrar por curso</h5>
                            <ul class="sort-by-age">
                                <li class="{{ !request('curso') ? 'checked' : '' }}">
                                    <a href="{{ route('evaluacion.index', request()->except('curso')) }}">
                                        <i class="fa fa-check-circle"></i>Todos
                                    </a>
                                </li>
                                @foreach ($cursos as $curso)
                                    <li class="{{ request('curso') == $curso->id ? 'checked' : '' }}">
                                        <a
                                            href="{{ route('evaluacion.index', array_merge(request()->all(), ['curso' => $curso->id])) }}">
                                            <i class="fa fa-circle-o"></i>{{ $curso->curso }}
                                            <span class="bgc-orange">{{ $curso->evaluaciones_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Filtro por estado -->
                        <div class="sort-area-sin">
                            <h5>Filtrar por estado</h5>
                            <ul class="tag">
                                <li class="{{ !request('estado') ? 'checked' : '' }}">
                                    <a href="{{ route('evaluacion.index', request()->except('estado')) }}">Todos</a>
                                </li>
                                <li class="{{ request('estado') == 'sin_intento' ? 'checked' : '' }}">
                                    <a
                                        href="{{ route('evaluacion.index', array_merge(request()->all(), ['estado' => 'sin_intento'])) }}">Sin
                                        intento</a>
                                </li>
                                <li class="{{ request('estado') == 'en_progreso' ? 'checked' : '' }}">
                                    <a
                                        href="{{ route('evaluacion.index', array_merge(request()->all(), ['estado' => 'en_progreso'])) }}">En
                                        progreso</a>
                                </li>
                        </div>
                    </div>

                    <!-- Evaluaciones a la derecha -->
                    <div class="col-md-9 col-lg-9">
                        <div class="row">
                            {{-- Evaluaciones en progreso --}}
                            @foreach ($evaluacionesEnProgreso as $i => $evaluacion)
                                @php
                                    $curso = $evaluacion->sesion->aulaCurso->curso ?? null;
                                    $imageUrl =
                                        $curso && $curso->image_url
                                            ? asset('storage/' . $curso->image_url)
                                            : asset('assets/img/panel/facilities/curso_defecto.jpg');
                                @endphp
                                <div class="col-12 col-md-6">
                                    <div class="sin-class wow fadeInUp" data-wow-delay=".5s">
                                        <div class="row no-gutters">
                                            <div class="left-c">
                                                <div class="class-con-top {{ $colores[$i % count($colores)] }}">
                                                    <h5>{{ $evaluacion->titulo }}</h5>
                                                    <h6>
                                                        {{ $evaluacion->sesion->titulo ?? 'Sin sesión' }}<br>
                                                        {{ $curso->curso ?? 'Sin curso' }}
                                                    </h6>
                                                    <p>{{ \Carbon\Carbon::parse($evaluacion->fecha_creacion)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                                <div class="class-con-bot">
                                                    <span>PREGUNTAS<br> {{ $evaluacion->cantidad_preguntas }}</span>
                                                    <a href="{{ route('evaluaciones.examen', ['evaluacion_id' => $evaluacion->id]) }}"
                                                        class="kids-care-btn bg-sky">En progreso...</a>
                                                </div>
                                            </div>
                                            <div class="r-class">
                                                <img src="{{ $imageUrl }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Evaluaciones no iniciadas --}}
                            @forelse($evaluacionesNoIniciadas as $i => $evaluacion)
                                @php
                                    $curso = $evaluacion->sesion->aulaCurso->curso ?? null;
                                    $imageUrl =
                                        $curso && $curso->image_url
                                            ? asset('storage/' . $curso->image_url)
                                            : asset('assets/img/panel/facilities/curso_defecto.jpg');
                                @endphp
                                <div class="col-12 col-md-6">
                                    <div class="sin-class wow fadeInUp" data-wow-delay=".5s">
                                        <div class="row no-gutters">
                                            <div class="left-c">
                                                <div class="class-con-top {{ $colores[$i % count($colores)] }}">
                                                    <h5>{{ $evaluacion->titulo }}</h5>
                                                    <h6>
                                                        {{ $evaluacion->sesion->titulo ?? 'Sin sesión' }}<br>
                                                        {{ $curso->curso ?? 'Sin curso' }}
                                                    </h6>
                                                    <p>{{ \Carbon\Carbon::parse($evaluacion->fecha_creacion)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                                <div class="class-con-bot">
                                                    <span>PREGUNTAS<br> {{ $evaluacion->cantidad_preguntas }}</span>
                                                    <a href="{{ route('evaluaciones.examen', ['evaluacion_id' => $evaluacion->id]) }}"
                                                        class="kids-care-btn bg-red">Sin iniciar</a>
                                                </div>
                                            </div>
                                            <div class="r-class">
                                                <img src="{{ $imageUrl }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>No tienes evaluaciones pendientes.</p>
                                </div>
                            @endforelse
                            <div class="col-12 d-flex justify-content-center mt-4">
                                {{ $evaluaciones->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('panel.includes.footer3')
            @include('panel.includes.footer')
</body>

</html>
