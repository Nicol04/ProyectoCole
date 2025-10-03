    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AprendiBot</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo_colegio.png') }}">
    <!-- === webfont=== -->
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <!--Font awesome css-->
    <!-- <link rel="stylesheet" href="{{ asset('css/panel/font-awesome.min.css') }}"> -->
    <!--Bootstrap
    <link href="{{ asset('css/panel/boostrap.min.css') }}" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--UI css-->
    <link rel="stylesheet" href="{{ asset('css/panel/jquery-ui.css') }}">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="{{ asset('css/panel/venobox.css') }}">
    <!--Owl Carousel css-->
    <link href="{{ asset('css/panel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel/owl.theme.css') }}" rel="stylesheet">
    <!--Animate css-->
    <link href="{{ asset('css/panel/animate.css') }}" rel="stylesheet">
    <!--Main Stylesheet -->
    <link href="{{ asset('css/panel/style.css') }}" rel="stylesheet">
    <!--Responsive Stylesheet -->
    <link href="{{ asset('css/panel/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/panel/venobox.css') }}" type="text/css" media="screen" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

    @csrf
    <div class="input-container">
        @if (($message = Session::get('mensaje')) && ($icono = Session::get('icono')))
            <script>
                Swal.fire({
                    title: "Mensaje",
                    text: "{{ $message }}",
                    icon: "{{ $icono }}"
                });
            </script>
        @endif
