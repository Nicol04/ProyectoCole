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

    <!--Estudiantes area start-->

    <div class="text-bread-crumb d-flex align-items-center style-six">
        <div class="container-fluid">
            <div class="row">
                <h2>Aula </h2> <!-- grado y seccion-->
                    <div class="bread-crumb-line"><span><a href="/panel/cursos">Mi aula / </a></span>Estudiantes</div>
                </div>
            </div>
        </div>
    </div>

    <!--Estudiantes area end-->

    <!--Staff style four sart-->
    <section class="stuff-area sc-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-sky">Estudiantes</h2>
                </div>
            </div>
            <div class="row justify-content-center no-gutters">
                <div class="col-xl-8">
                    <div class="row justify-content-center">
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".3s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-2.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Flumingo</h4>
                                    <span>English Teacher</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".4s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-3.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Philips kotler</h4>
                                    <span>Mathemetics expert</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".5s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-4.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Tresha R</h4>
                                    <span>Kitchen expert</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4  col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".6s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-7.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Jhone smith</h4>
                                    <span>Arts & Multimedia</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".7s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-6.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Richard gomez</h4>
                                    <span>Social Business</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".8s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-7.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>alexander</h4>
                                    <span>Zology Teacher</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".9s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-8.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>sherlock</h4>
                                    <span>Business Management</span>
                                </div>
                            </div>
                        </div>
                        <!--Single staff-->
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                            <div class="sin-staff wow fadeInUp" data-wow-delay=".99s">
                                <div class="staf-img">
                                    <img src="{{ asset('assets/img/panel/staff/staff-9.png') }}" alt="">
                                </div>
                                <div class="staf-det">
                                    <h4>Mirror</h4>
                                    <span>Accounting Teacher</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Staff style four end-->
    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>
</html>