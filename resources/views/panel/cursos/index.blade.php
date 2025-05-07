<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
</head>
<body>
    <div class="preloader"></div>
    @include('panel.includes.header')
    <div class="preloader"></div>
    @include('panel.includes.menu')

    <!--CURSOS area Start-->
    <div class="image-breadcrumb">CURSOS</div>
    <div class="text-bread-crumb d-flex align-items-center bgc-orange">
        <div class="container-fluid">
            <div class="bread-crumb-line" style="text-align: center;"> AULA:
                <a> Docente: </a> <!-- Docente id nombre -->
            </div> <!-- Aula id grado seccion -->
        </div>
    </div>
    <!--CURSOS area start-->

    <!--Events area start-->
    <section class="kids-care-event-area">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading  st-two font-red">CURSOS</h2>
                    <p class="area-subline">Aquí podrás ver todas las materias que estudias en tu salón. En cada curso encontrarás clases, tareas y evaluaciones que te ayudarán a aprender de forma divertida. ¡Haz clic y descubre todo lo que puedes aprender!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="sin-upc-event-two">
                        <div class="sp-age bg-green">
                            <p>AGE: 2-5 Years</p>
                        </div>
                        <img src="{{ asset('assets/img/panel/facilities/ue-1.jpg') }}" alt="">

                        <div class="sin-up-content">
                            <h6>Annual Sports and Misic Day...</h6>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-green" href="">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-upc-event-two">
                        <div class="sp-age bg-orange">
                            <p>AGE: 2-5 Years</p>
                        </div>
                        <img src="{{ asset('assets/img/panel/facilities/ue-2.jpg') }}" alt="">
                        <div class="sin-up-content">
                            <h6>Annual Sports and Misic Day...</h6>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-orange" href="">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-upc-event-two">
                        <div class="sp-age bg-red">
                            <p>AGE: 2-5 Years</p>
                        </div>
                        <img src="{{ asset('assets/img/panel/facilities/ue-3.jpg') }}" alt="">
                        <div class="sin-up-content">
                            <h6>Annual Sports and Misic Day...</h6>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-red" href="">Ver más</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-upc-event-two">
                        <div class="sp-age bg-sky">
                            <p>AGE: 2-5 Years</p>
                        </div>
                        <img src="{{ asset('assets/img/panel/facilities/ue-4.jpg') }}" alt="">
                        <div class="sin-up-content">
                            <h6>Annual Sports and Misic Day...</h6>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-sky" href="">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Events area end-->

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
