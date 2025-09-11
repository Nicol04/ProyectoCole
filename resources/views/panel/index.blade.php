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

    <!-- Slides start -->
    <div class="slider-wrapper">
        <div class="homepage-s  owl-carousel owl-theme">

            <div class="item bg-10">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 slider-ext-wrap">
                        </div>
                    </div>
                </div>
            </div>
            <div class="item bg-11">
                <div class="container">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slides end -->

    <!--Features area start-->
    <section class="feature-area-wrapper style-two">
        <div class="container-fluid">
            <div class="row no-gutters justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <!--Single Features-->
                        <div class="col-sm-6 col-xl-4 col-md-4">
                            <div class="single-features bg-orange wow fadeInUp" data-wow-delay=".4s">
                                <div class="fet-icon">
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-1.png') }}" alt="">
                                </div>
                                <h3>Formación en valores</h3>
                                <p>Creemos que la educación va más allá del aula. Por eso, integramos en cada actividad
                                    la práctica de valores que forman personas íntegras, solidarias y conscientes de su
                                    entorno. </p>
                            </div>
                        </div>
                        <!--Single Features-->
                        <div class="col-sm-6 col-xl-4 col-md-4">
                            <div class="single-features bg-sky wow fadeInUp" data-wow-delay=".6s">
                                <div class="fet-icon">
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-2.png') }}" alt="">
                                </div>
                                <h3>Pensamiento crítico</h3>
                                <p>Preparamos a nuestros estudiantes para enfrentar el mundo con criterio propio. Les
                                    enseñamos a cuestionar, investigar, comparar y argumentar.</p>
                            </div>
                        </div>
                        <!--Single Features-->
                        <div class="col-sm-6 col-xl-4 col-md-4">
                            <div class="single-features bg-per wow fadeInUp" data-wow-delay=".8s">
                                <div class="fet-icon">
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-3.png') }}" alt="">
                                </div>
                                <h3>Metodologías Innovadoras</h3>
                                <p>Implementamos estrategias activas que convierten el aprendizaje en una experiencia
                                    dinámica: proyectos colaborativos. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Features area end-->

    <!--Wellcome area start-->
    <section class="welcome-boxed bol-bol-bg">
        <div class="container-fluid">
            <div class="row no-gutters ">
                <div class="col-md-12">
                    <div class="wellcome-area-wrapper ">
                        <div class="row">
                            <div class="col-md-7 col-lg-5 col-xl-6">
                                <div class="wellcome-content wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="font-orange area-heading">BIENVENIDOS A<br>SU AULA VIRTUAL</h2>
                                    <p>El <strong>Colegio Ann Goulden</strong> te da la bienvenida a su Aula Virtual,
                                        un entorno digital seguro e innovador, donde podrás acceder a tus clases,
                                        materiales, tareas y mucho más. ¡Aprender nunca fue tan accesible y emocionante!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Wellcome area end-->

    <!--Expect area start-->
    <section class="expect-area bg-white">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-w st-two">¿Qué nos hace destacar?</h2>
                    <p class="area-subline font-w">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat
                        cupidatat non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem
                        ipsum dolor sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon1.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Metodología innovadora</h5>
                            <p>Adaptamos nuestras técnicas educativas para que cada niño descubra su potencial.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon2.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Personal capacitado</h5>
                            <p>Contamos con un equipo docente comprometido y apasionado por la enseñanza.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon3.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Ambiente seguro y estimulante</h5>
                            <p>Nuestra infraestructura está diseñada para brindar a los niños
                                aprendizaje con confianza.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon4.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Salud y bienestar emocional</h5>
                            <p>Educamos a nuestros estudiantes para que desarrollen estilos de vida activos y
                                saludables. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Expect area end-->

    <!--Popular testimonial area start-->
    <section class="tes-popular bol-bol-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-red st-two">BIENVENIDOS A ANN GOULDEN !</h2>
                    <p class="area-subline">En nuestra institución, creemos firmemente que
                        cada estudiante tiene un gran potencial por descubrir. A través del
                        compromiso, la disciplina y el amor por el aprendizaje, podemos
                        construir juntos un mejor futuro.
                        ¡Nunca dejen de aprender, de soñar y de dar lo mejor de ustedes!</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="row srart-popular-tes owl-carousel owl-theme  no-gutters">
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes color-per">
                                <div class="con-part">
                                    <h6>Mensaje</h6>
                                    <p>Ustedes son el presente que construye el futuro, y estamos
                                        orgullosos de acompañarlos en este proceso. Saludos a todos los estudiantes.
                                    </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c3.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Felix Harle Silupú Ramírez</h6>
                                        <p>Subdirector</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes color-red">
                                <div class="con-part">
                                    <h6>Mensaje</h6>
                                    <p>IE Ann Goulden se destaca por su enfoque en la formación integral de los
                                        estudiantes, incorporando valores como el respeto, la responsabilidad y la
                                        solidaridad. </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/directora.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Maricarmen Julliana Ruiz Falero</h6>
                                        <p>Directora</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes">
                                <div class="con-part">
                                    <h6>Mensaje</h6>
                                    <p>Nunca olviden que la educación es la herramienta más
                                        poderosa para transformar sus vidas.
                                        Aprovechen cada oportunidad para aprender y crecer.
                                    </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c1.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Feliscar Elizabeth Arellano Siancas</h6>
                                        <p>Subdirectora</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Popular testimonial area end-->

    <!--Gallery area start-->
    <section class="kids-care-gallery style-three" id="gallery">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-w st-two">Galería de fotos de la institución</h2>
                    <p class="area-subline font-w">Cada imagen cuenta una historia… Aquí encontrarás
                        recuerdos especiales de nuestras actividades, celebraciones, y del día a
                        día junto a nuestros docentes, estudiantes y la directora del colegio.
                        ¡Gracias por ser parte de esta gran familia!</p>
                </div>
            </div>
            <div class="inner-container">
                <ul class="filter-menu filters">
                    <!-- For filtering controls add -->
                    <li class="filtr-active filtr" data-filter="all">Todos</li>
                    <li class=" filtr" data-filter="1">Colegio</li>
                    <li class="filtr" data-filter="2">Docentes</li>
                    <li class=" filtr" data-filter="3">Actividades</li>
                </ul>
                <div class="row filtr-container">
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="1">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_1.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_1.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Colegio</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="2">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_2.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_2.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Docentes</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_3.jpeg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_3.jpeg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Actividades</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_4.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_4.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Actividades</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="2">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_5.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_5.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Docentes</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_6.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_6.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Actividades</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_7.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_7.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Actividades</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="1">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal_8.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal_8.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Colegio</h4>
                                <p>Por: Colegio Ann Goulden</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--Gallery area end-->

    <!--Childcare service area start-->
    <section class="childcare-service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-xl-6 offset-xl-1">
                    <!-- Añadido offset-xl-1 para posicionarlo a la izquierda con margen -->
                    <div class="inner-service" style="padding: 20px; margin-left: 0;">
                        <span>Sobre nosotros</span>
                        <h1 class="area-heading style-two">¿Cuál es nuestra misión?</h1>
                        <p style="font-size: 20px; line-height: 1.6; text-align: justify; margin-top: 15px;">
                            Somos una Institución Educativa estatal, del ámbito urbano en el sector Barrio
                            Sur de Piura, que atiende los niveles de educación Inicial y Primario, y ofrece
                            una educación integral e inclusiva, con personal docente capacitado pedagógica y
                            tecnológicamente, cuyo trabajo se sustenta en un Marco Curricular que responde a
                            los intereses y necesidades de los educandos. promoviendo en los niños y niñas una
                            educación en Derechos Humanos, en el marco de una educación centrada en valores
                            como la solidaridad, el respeto, la honradez y responsabilidad, que busca la
                            conservación del medio ambiente, espacios seguros , de sana convivencia y libres
                            de violencia , la prevención de riesgos en alianzas estratégicas con padres de
                            familia, aliados estratégicos, Instituciones educativas públicas y privadas, con
                            colegios profesionales, organizaciones de base comprometidos con una educación de
                            calidad que les permita actuar en una sociedad democrática y participativa.
                        </p>

                    </div>
                    <div class="inner-service" style="padding: 22px; margin: 0 auto;">
                        <h1 class="area-heading style-two">¿Cuál es nuestra visión?</h1>
                        <p style="font-size: 20px; line-height: 1.6; text-align: justify; margin-top: 15px;">
                            La Institución Educativa “Ann Goulden” del Barrio Sur de Piura, al 2026,
                            contribuirá a que todos nuestros estudiantes desarrollen su potencial
                            desde la primera infancia, accedan al mundo letrado , resuelven problemas,
                            practiquen valores , sepan seguir aprendiendo, asuman ser ciudadanos con
                            derechos y responsabilidades, enmarcado en una cultura de respeto a los
                            derechos , inclusividad , el cuidado en la conservación del medio ambiente,
                            con el propósito de formar personas que construyan una educación para la vida
                            siendo creativas, reflexivas, emprendedoras, con liderazgo, autonomía,
                            usen las tics , desarrollen competencias e innovaciones que consoliden
                            su proyecto de vida .
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Childcare service area end-->

    <!--Call to action area start-->
    <section class="call-to-action-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-w">Normas de Convivencia</h2>
                </div>
            </div>
        </div>
    </section>
    <!--Call to action area end-->

    <!--Normas gallery area start-->
    <section class="normas-gallery" id="normas">
        <div class="container-fluid">
            <div class="inner-container">
                <div class="row">
                    <!-- Primera fila: 4 normas -->
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N1.png') }}" alt="Norma 1">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N1.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 1</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N2.png') }}" alt="Norma 2">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N2.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 2</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N3.png') }}" alt="Norma 3">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N3.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 3</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N4.png') }}" alt="Norma 4">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N4.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 4</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: 4 normas -->
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N5.png') }}" alt="Norma 5">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N5.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 5</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N6.png') }}" alt="Norma 6">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N6.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 6</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N7.png') }}" alt="Norma 7">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N7.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 7</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N8.png') }}" alt="Norma 8">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N8.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 8</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tercera fila: 4 normas -->
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N9.png') }}" alt="Norma 9">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N9.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 9</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N10.png') }}" alt="Norma 10">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N10.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 10</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N11.png') }}" alt="Norma 11">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N11.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 11</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 mb-4">
                        <div class="norma-item">
                            <div class="norma-square">
                                <img src="{{ asset('assets/img/panel/gallery/N12.png') }}" alt="Norma 12">
                                <div class="norma-overlay">
                                    <a href="{{ asset('assets/img/panel/gallery/N12.png') }}"
                                        class="venobox vbox-item" data-gall="normas"><i class="fa fa-search"></i></a>
                                    <h5>Norma 12</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Normas gallery area end-->

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer2')
    @include('panel.includes.footer')
</body>

</html>
