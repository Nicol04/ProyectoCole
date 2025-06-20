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

    <!--Estudiantes area start-->

    <div class="text-bread-crumb d-flex align-items-center style-six">
        <div class="container-fluid">
            <div class="row">
                <h2>Aula </h2> <!-- grado y seccion-->
                <div class="bread-crumb-line"><span>
                        <a href="/panel/cursos">
                            Mi aula {{ $aula->grado ? $aula->grado : 'Grado no asignado' }}
                            {{ $aula->seccion ? $aula->seccion : '' }} </a>
                    </span>Estudiantes</div>
            </div>
        </div>
    </div>
    </div>

    <!--Estudiantes area end-->

    <!--Staff style four sart-->
    <section class="stuff-area sc-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-sky">Estudiantes del aula
                        {{ $aula->grado ? $aula->grado : 'Grado no asignado' }}
                        {{ $aula->seccion ? $aula->seccion : '' }} </h2>
                </div>
            </div>
            <div class="row justify-content-center no-gutters">
                <div class="col-xl-8">
                    <div class="row justify-content-center">
                        <!--Single staff-->
                        @foreach ($estudiantes as $estudiante)
                            <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                                <div class="sin-staff wow fadeInUp" data-wow-delay=".3s">
                                    <div class="staf-img">
                                        <img src="{{ asset('storage/' . ($estudiante->avatar?->path ?? 'avatares/avatar_defecto.png')) }}"
                                            alt="Avatar del estudiante">
                                    </div>
                                    <div class="staf-det">
                                        <h4>{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}</h4>
                                        <span
                                            style="color: {{ $estudiante->id === Auth::id() ? '#f44336' : '#03a9f4' }}">
                                            {{ $estudiante->id === Auth::id() ? 'Yo' : 'Estudiante' }}
                                        </span>
                                        @if ($roleId != 3)
                                            <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                                class="kids-care-btn bgc-orange">Ver calificaciones</a>
                                            <a href="{{ route('calificacion.index', $estudiante->id) }}"
                                                class="kids-care-btn bg-green" title="Ver promedio">
                                                <i class="fas fa-chart-pie"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
