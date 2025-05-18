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
                <h2>Sesion </h2>
                <div class="bread-crumb-line"><span><a href="">Home / </a></span>News & Events</div>
                </div>
            </div>
        </div>
    </section> 
    <!--Breadcrumb area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>