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
    <div class="image-breadcrumb style-two"></div>

    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>Sesion {{ $sesion->titulo }}</h2>
                    <div class="bread-crumb-line"><span> <a href="{{ route('sesiones.index', $sesion->aulaCurso->curso->id) }}">{{ $sesion->aulaCurso->curso->curso }}/ </a></span>
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
                    <p class="heading-para font-red">Our World</p>
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


            <!-- Botón solo visible si el usuario es docente (rol_id == 2) -->
@if (auth()->check() && auth()->user()->roles->first()?->id == 2)
    <a href="{{ route('sesiones.edit', $sesion->id) }}" class="kids-care-btn bgc-orange">Editar Sesión</a>
@endif

        </div>
    </section>
    <!--Child care area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
