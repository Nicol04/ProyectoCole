<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>
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
<body>
    hola
</body>
@include('panel.includes.footer3')
@include('panel.includes.footer')

</body>

</html>