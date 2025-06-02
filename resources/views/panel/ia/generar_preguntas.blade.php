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
    <div class="text-bread-crumb d-flex align-items-center style-prueba sc-page-bc"></div>
    <!--Breadcrumb area end-->

    <iframe id="iframeExamen"
        src="{{ route('examen.formulario_examen', [
            'evaluacion_id' => $evaluacion_id,
            'cantidad_preguntas' => $cantidad_preguntas,
            'titulo' => $titulo,
            'objetivo' => urlencode($objetivo),
            'actividades' => urlencode($actividades),
        ]) }}"
        width="100%" frameborder="0" style="border: none; overflow: hidden;">
    </iframe>

    <script>
        window.addEventListener("message", function(event) {
            if (event.data.type === "iframeHeight") {
                const iframe = document.getElementById("iframeExamen");
                if (iframe && event.data.height) {
                    iframe.style.height = event.data.height + "px";
                }
            }
        });
    </script>


    <style>
        .sc-page {
            margin-top: 100px;
        }

        .text-bread-crumb.style-six.sc-page-bc {
            background-image: url(img/bg/breadcrumb-4.jpg);
            background: #b6cf4d;
        }
    </style>
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
