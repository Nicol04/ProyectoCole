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
                            <div class="slider-text">
                                <span class="animated"><img src="{{ asset('assets/img/panel/icon/slider-text.png') }}"
                                        alt="" height="120px"></span>
                                <p class="animated "style="color:rgb(243, 251, 92);">Estamos bendecidos y listos para aprender</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="item bg-11">
                <div class="container">
                    <div class="row">
                        <div class="offset-md-3 offset-xl-4 col-xl-7 slider-ext-wrap  animated fadeInUp">
                            <div class="slider-text sldr-two">
                                <!--<h1 class="animated flipInX">Jugamos y aprendemos</h1>
                                <p class="animated fadeInDown">¿Quién dijo que la educación era aburrida?</p>-->
                            </div>
                        </div>
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
                                <h3>Happy Environment</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non
                                    proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officia</p>
                            </div>
                        </div>
                        <!--Single Features-->
                        <div class="col-sm-6 col-xl-4 col-md-4">
                            <div class="single-features bg-sky wow fadeInUp" data-wow-delay=".6s">
                                <div class="fet-icon">
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-2.png') }}" alt="">
                                </div>

                                <h3>Active Learning</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non
                                    proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officia</p>

                            </div>
                        </div>
                        <!--Single Features-->
                        <div class="col-sm-6 col-xl-4 col-md-4">
                            <div class="single-features bg-per wow fadeInUp" data-wow-delay=".8s">
                                <div class="fet-icon">
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-3.png') }}" alt="">
                                </div>
                                <h3>Creative Lessons</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non
                                    proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officia</p>
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
                                    <h2 class="font-orange area-heading">BIENVENIDOS AL AULA VIRTUAL<br> DEL COLEGIO ANN GOULDEN!</h2>
                                    <p>Hola estudiantes, padres de familia y docentes, les damos la bienvenida a
                                        nuestra aula virtual. Aquí encontrarán un espacio para aprender, compartir y
                                        crecer juntos. Nuestro objetivo es brindarles una educación de calidad, adaptada a
                                        las necesidades de cada uno de ustedes. A través de esta plataforma, podrán acceder a
                                        recursos educativos, participar en actividades interactivas y comunicarse con sus
                                        compañeros y docentes. ¡Esperamos que disfruten de su experiencia en el aula virtual
                                        y aprovechen al máximo las oportunidades de aprendizaje que les ofrecemos!</p>
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
                            <p>Nuestra infraestructura está diseñada para proporcionar un espacio donde los niños pueden
                                explorar y aprender con confianza.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon4.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Health Meals</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non proident,
                                sunt in </p>
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
                    <h2 class="area-heading font-red st-two">FIRST DAY AT SCHOOL !</h2>
                    <p class="area-subline">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="row srart-popular-tes owl-carousel owl-theme  no-gutters">
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes color-per">
                                <div class="con-part">
                                    <h6>Active Learning</h6>
                                    <p>Lorem ipsum dolor sit amsectet urExcepteur sint occaecat cupidatat non proident,
                                        sunt in cuculpa qu officiaulpa qui officiacuculpa qui officiaLorem ipsum dolor
                                    </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c3.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Leonardo Cordova Lopez</h6>
                                        <p>Subdirector</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes color-red">
                                <div class="con-part">
                                    <h6>Active Learning</h6>
                                    <p>IE Ann Goulden se destaca por su enfoque en la formación integral de los
                                        estudiantes, incorporando valores como el respeto, la responsabilidad y la
                                        solidaridad. </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c2.png') }}" alt="">
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
                                    <h6>Active Learning</h6>
                                    <p>Lorem ipsum dolor sit amsectet urExcepteur sint occaecat cupidatat non proident,
                                        sunt in cuculpa qu officiaulpa qui officiacuculpa qui officiaLorem ipsum dolor
                                    </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c1.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Claudia María Montalbán Mena</h6>
                                        <p>Líderes docentes</p>
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
                    <h2 class="area-heading font-w st-two">Exclusive Photo Gallery</h2>
                    <p class="area-subline font-w">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat
                        cupidatat non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem
                        ipsum dolor sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="inner-container">
                <ul class="filter-menu filters">
                    <!-- For filtering controls add -->
                    <li class="filtr-active filtr" data-filter="all">All</li>
                    <li class=" filtr" data-filter="1">School</li>
                    <li class="filtr" data-filter="2">Kindergarten</li>
                    <li class=" filtr" data-filter="3">Picnic</li>
                </ul>
                <div class="row filtr-container">
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="1">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-1.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-1.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>School</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="2">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-2.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-2.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Kindergarten</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-3.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-3.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Picnics Gallery</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="1">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-4.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-4.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>School</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="2">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-5.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-5.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Kindergarten</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="3">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-6.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-6.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Picnics Gallery</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="1">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-7.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-7.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>School</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>
                    <!--Single gallery start-->
                    <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-3 filtr-item" data-category="2">
                        <div class="sin-gallery">
                            <img src="{{ asset('assets/img/panel/gallery/gal-8.jpg') }}" alt="">
                            <div class="gallery-overlay">
                                <div class="bg"></div>
                            </div>
                            <div class="gallery-content">
                                <a href="{{ asset('assets/img/panel/gallery/gal-8.jpg') }}" class="venobox vbox-item"
                                    data-gall="gallery1"><i class="fa fa-search"></i></a>
                                <h4>Kindergarten</h4>
                                <p>By: kidzcare Theme</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--Gallery area end-->

    <!--Countdown for upcoming event start-->
    <section class="up-event-countdown">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <h2><span>yahoo!</span> iT’s holiday tours!</h2>
                    <div class="count-down">
                        <div data-countdown="2020/03/11"></div>
                    </div>
                    <a href="#" class="kids-care-btn bg-red">BOOK YOUR SEAT</a>
                </div>
                <div class="col-xl-6">
                    <div class="up-event-img">
                        <img src="{{ asset('assets/img/panel/bg/count-down-child.png') }}" alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer2')
    @include('panel.includes.footer')
</body>

</html>
