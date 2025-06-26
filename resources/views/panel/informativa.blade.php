<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>

    @if ($roleId == 3)
        @include('panel.includes.menu_estudiante')
    @elseif ($roleId == 2)
        @include('panel.includes.menu_docente')
    @endif
    <!--Breadcrumb area start-->
    <div class="text-bread-crumb d-flex align-items-center style-six">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Conoce acerca de AprendiBot tu aula virtual</h2>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    <!--Wellcome video area start-->
    <section class="wellcome-video-area">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-xl-1 col-md-7 col-lg-6 col-xl-5">
                    <div class="wellcome-content style-two">
                        @if ($roleId == 3)
                            <h2 class="font-green area-heading">BIENVENIDO ESTUDIANTE<br>A TU AULA VIRTUAL</h2>
                            <p>Hola, en esta aula virtual podrás encontrar tus cursos y clases para acceder a tus
                                evaluaciones. También podrás ver tus notas de manera dinámica. Si tienes dudas sobre tus
                                exámenes, podrás consultarlas con una inteligencia artificial que te orientará. Y si aún
                                no estás seguro, consulta con tu docente. Además, tendrás acceso a contenido 3D para
                                aprender de manera interactiva. ¡Bienvenido a tu aula virtual!
                                Puedes revisar nuestro tutorial para entender cómo usar la plataforma 😉</p>
                        @elseif ($roleId == 2)
                            <h2 class="font-green area-heading">BIENVENIDO DOCENTE<br>A TU AULA VIRTUAL</h2>
                            <p>Hola, en esta aula virtual podrás crear sesiones, generar evaluaciones, y ver los
                                resultados de tus estudiantes en tiempo real. También contarás con herramientas de
                                retroalimentación docente y un espacio para publicar comunicados a tu aula. Además,
                                puedes explorar contenido 3D que enriquecerá tus clases. ¡Gracias por ser parte de esta
                                experiencia educativa!
                            </p>
                            <h2>¡Revisa nuestro tutorial para aprender a usar la plataforma!</h2>
                            <a href="{{ route('comunicados.create') }}" class="kids-care-btn bg-green">Crear un
                                comunicado para mi aula</a>
                        @endif
                    </div>
                </div>
                <div class="col-xl-5 col-md-5 col-lg-6">
                    <div class="video_content text-center d-flex align-items-center">
                        <a class="about_video" data-autoplay="true" data-vbtype="video"
                            href="@if ($roleId == 3) https://www.youtube.com/watch?v=zrroUQ1Bapo {{-- Estudiante --}}
                            @elseif ($roleId == 2)
                                https://www.youtube.com/watch?v=pDVMK_9oFwo {{-- Docente --}} @endif">
                            <img src="{{ asset('assets/img/panel/icon/youtube-play.png') }}" alt="Video tutorial">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Wellcome video area end-->

    <section class="quick-contact-two">
        <div class="container-fluid">
            <div class="col-md-12">
                <h1 class="area-heading font-per style-two">Conoce a nuestros docentes</h1>
                <p class="heading-para">Estos son los docentes que forman parte de nuestra institución educativa.
                    Cada uno de ellos
                    está comprometido con la enseñanza y el desarrollo de nuestros estudiantes.</p>
            </div>
        </div>
    </section>

    <section class="stuff-area">
        <div class="container-fluid">
            <div class="row justify-content-center no-gutters">
                <div class="col-xl-8">
                    <div class="row justify-content-center">

                        @foreach ($docentes as $docente)
                            @php
                                $persona = $docente->persona;
                                $aula = $docente->aulas->first(); // si tiene solo un aula asignada
                                $grado = $aula->grado ?? '---';
                                $seccion = $aula->seccion ?? '---';
                                $avatarPath = $docente->avatar->path ?? 'default-avatar.png';
                            @endphp

                            <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                                <div class="sin-staff wow fadeInUp" data-wow-delay=".3s">
                                    <div class="staf-img">
                                        <img src="{{ asset('storage/' . $avatarPath) }}"
                                            style="width: 170px; height: 190px;" alt="Avatar de {{ $persona->nombre }}">
                                    </div>
                                    <div class="staf-det">
                                        <h4>{{ $persona->nombre }} {{ $persona->apellido }}</h4>
                                        <span>Docente - Aula: {{ $grado }}° "{{ $seccion }}"</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Estudiantes primeros puestos-->
    <section class="kids-care-teachers-area style-3">
        <div class="container-fluid custom-container text-center">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading st-two font-sky">Top 3 estudiantes con mejor rendimiento</h2>
                    <p class="area-subline">Estos estudiantes han destacado por su alto rendimiento académico en el aula
                        virtual.</p>
                </div>
            </div>

            @php
                $puestos = ['🥇', '🥈', '🥉'];
                $orden = [1, 0, 2];
            @endphp

            <div class="d-flex justify-content-center align-items-end gap-4 mt-5" style="flex-wrap: wrap;">
                @foreach ($orden as $i)
                    @php
                        $item = $mejoresEstudiantes[$i];
                        $estudiante = $item['estudiante'];
                        $avatar = $estudiante->avatar->path ?? 'img/default.png';
                        $nombre = $estudiante->persona->nombre;
                        $apellido = $estudiante->persona->apellido;
                        $promedio = $item['promedio'];
                        $tamanio = $i === 1 ? 180 : 140;
                    @endphp

                    <div style="width: 200px;">
                        <div class="text-center mb-2">
                            <span style="font-size: 2rem;">{{ $puestos[$i] }}</span><br>
                            <small class="text-muted">Puesto {{ $i + 1 }}</small>
                        </div>
                        <div class="single-teacher style-b"
                            style="border: 2px solid #ccc; border-radius: 10px; padding: 15px;">
                            <div class="teacher-img mb-2">
                                <img src="{{ asset('storage/' . $avatar) }}" alt="Avatar de {{ $nombre }}"
                                    style="width: {{ $tamanio }}px; height: {{ $tamanio }}px; object-fit: cover; border-radius: 50%;">
                            </div>
                            <div class="teacher-detail">
                                <h5>{{ $nombre }} {{ $apellido }}</h5>
                                <p class="mb-0">Promedio: <strong>{{ $promedio }}%</strong></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
