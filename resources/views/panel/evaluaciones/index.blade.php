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
    <div class="text-bread-crumb d-flex align-items-center style-six sc-page-bc">
        <div class="container-fluid">
            <div class="row">
                <h2>Evaluaciones</h2>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->
    

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>