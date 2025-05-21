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
    <section class="text-bread-crumb bc-style-two">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $curso->curso }}</h2> <!-- Curso nombre -->
                    <div class="bread-crumb-line"><span><a href="/panel/cursos">Cursos / </a></span>{{ $curso->curso }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb area end-->

    <!--Class area start-->
    <section class="choose-class-area ">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="area-heading font-orange mb-0 text-center flex-grow-1">
                            SESIONES
                            <img src="{{ asset('assets/img/panel/icon/pen-orange.png') }}" alt="">
                        </h2>

                        @php
                            $rolId = auth()->user()->roles->first()?->id;
                        @endphp

                        @if ($rolId == 2)
                            <!-- Solo Docente -->
                            <a href="{{ route('sesiones.create', ['aula_curso_id' => $aulaCurso->id]) }}"
   class="btn btn-circle-agregar d-flex align-items-center justify-content-center ms-3"
   title="Agregar sesión">
   <i class="fas fa-plus"></i>
   <span class="btn-text-hover ms-2">Agregar sesión</span>
</a>

                        @endif

                    </div>

                    @if ($sesiones->isEmpty())
                        <p>No hay sesiones registradas para este curso.</p>
                    @else
                </div>
            </div>
            <div class="inner-container">
                <div class=" row">
                    @foreach ($sesiones as $sesion)
                        <!--Single class start-->
                        <div class="col-sm-6 col-xl-3">
                            <div class="single-class  wow fadeInUp" data-wow-delay=".4s">
                                @php
                                    $imgNumber = $loop->iteration % 8 ?: 8;
                                @endphp
                                <img src="{{ asset('assets/img/panel/class/class' . $imgNumber . '.jpg') }}"
                                    alt="">
                                <div class="price red-drop">
                                    <p>0{{ $loop->iteration }}</p>
                                    <span>{{ $sesion->dia }}</span>
                                </div>
                                <div class="intro">
                                    <div class="intro-left">
                                        <h3><a href="">{{ Str::limit($sesion->titulo, 30) }}</a></h3>
                                        <span>{{ $sesion->fecha }}</span>
                                    </div>
                                </div>
                                <div class="details">
                                    <p>{{ Str::limit($sesion->objetivo, 60) }}</p>
                                    <a href="{{ route('sesiones.show', $sesion->id) }}"
                                        class="kids-care-btn bgc-orange">Ver detalle</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sesiones->links() }}
                    </div>

                </div>
            </div>

        </div>
    </section>
    @endif
    <!--Class area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
