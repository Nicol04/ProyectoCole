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
    <div class="image-breadcrumb style-two"></div>

    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>Sesion {{ $sesion->titulo }}</h2>
                    <div class="bread-crumb-line"><span> <a
                                href="{{ route('sesiones.index', $sesion->aulaCurso->curso->id) }}">{{ $sesion->aulaCurso->curso->curso }}/
                            </a></span>
                        Sesion {{ $sesion->titulo }}</div>
                </div>
            </div>
        </div>
    </section>
    <!--Text breadcrumb area start-->

    <!--Child care area start-->
    <section class="infant-care">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="area-heading font-red">Sesión <span class="font-per">{{ $sesion->titulo }}</span>
                    </h1>
                </div>
            </div>
            <div class="infant-care-inner">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="sin-inf-care wow fadeInUp" data-wow-delay=".6s">
                            <div class="care-icon">
                                <img src="{{ asset('assets/img/panel/icon/book-1.png') }}" alt="">
                            </div>
                            <div class="care-content">
                                <h6>Objetivo</h6>
                                <p>{{ $sesion->objetivo }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sin-inf-care wow fadeInUp" data-wow-delay=".3s">
                            <div class="care-icon">
                                <img src="{{ asset('assets/img/panel/icon/book-2.png') }}" alt="">
                            </div>
                            <div class="care-content">
                                <h6>Actividades</h6>
                                <p>{{ $sesion->actividades }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sin-inf-care wow fadeInUp" data-wow-delay=".9s">
                            <div class="care-icon">
                                <img src="{{ asset('assets/img/panel/icon/color-palate.png') }}" alt="">
                            </div>
                            <div class="care-content">
                                <h6>Fecha</h6>
                                <p>{{ $sesion->fecha }} {{ $sesion->dia }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->check() && auth()->user()->roles->first()?->id == 2)
                <div class="text-center my-4">
                    <a href="{{ route('sesiones.edit', $sesion->id) }}" class="kids-care-btn bgc-orange mx-2">Editar
                        Sesión</a>
                    <a href="{{ route('evaluacion.create.sesion', ['aula_curso_id' => $sesion->aula_curso_id, 'sesion_id' => $sesion->id]) }}"
                        class="kids-care-btn bgc-blue mx-2">
                        Agregar evaluación
                    </a>
                </div>
            @endif
        </div>
    </section>
    <!--Child care area end-->


    <div class="latest-news-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="area-heading font-sky style-two">Evaluaciones</h1>
                    <p class="heading-para">En este apartado encontrarás las evaluaciones que has generado</p>
                </div>
            </div>
            <div class="row justify-content-center no-gutters">
                <div class="col-xl-8">
                    <div class="row">
                        @foreach ($sesion->evaluaciones as $evaluacion)
                            @php
                                $numeroImagen = $loop->iteration % 8 ?: 8;
                            @endphp
                            <div class="col-md-4 col-xl-4">
                                <div class="single-news wow flipInY" data-wow-delay=".7s">
                                    <img src="{{ asset('assets/img/panel/facilities/fac-' . $numeroImagen . '.jpg') }}"
                                        alt="">
                                    <div class="news-det">
                                        <h4>{{ $evaluacion->titulo }}</h4>
                                        <p>Fecha de creación:
                                            {{ \Carbon\Carbon::parse($evaluacion->fecha_creacion)->format('d/m/Y') }}
                                        </p>
                                        <p>Cantidad de preguntas: {{ $evaluacion->cantidad_preguntas }}</p>

                                        <p>
                                            <strong>Modo:</strong>
                                            @if ($evaluacion->es_supervisado)
                                                <i class="fa fa-eye text-success"></i> Supervisado
                                            @else
                                                <i class="fa fa-robot text-primary"></i> No Supervisado
                                            @endif
                                        </p>
                                        <div class="news-meta">
                                            <a
                                                href="{{ route('evaluaciones.examen', ['evaluacion_id' => $evaluacion->id]) }}"><i
                                                    class="fa fa-angle-right"></i></a>
                                            @if (auth()->check() && auth()->user()->roles->first()?->id == 2)
                                                <form class="form-eliminar-evaluacion"
                                                    action="{{ route('evaluaciones.eliminar', ['evaluacion' => $evaluacion->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.form-eliminar-evaluacion').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar evaluación?',
                    text: 'Se eliminarán también todas sus preguntas.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
