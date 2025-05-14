<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
</head>
<body>
    <div class="preloader"></div>
    <div class="preloader"></div> <!-- cargaaaaa -->
    @if(auth()->check())
    @php
        $roleId = auth()->user()->roles->first()?->id;
    @endphp

    @if($roleId == 3)
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
                                <span class="animated"><img
                                        src="{{ asset('assets/img/panel/icon/slider-text.png') }}"
                                        alt="" height="120px"></span>
                                <p class="animated "style="color:rgb(243, 251, 92);">Estamos bendecidos y listos para aprender</p>
                                <a href="#" class="first-btn kids-care-btn bgc-orange">More about us</a>
                                <a href="#" class="sec-btn  kids-care-btn bg-blue">Our teachers</a>
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
                                <h1 class="animated flipInX">we play and learn</h1>
                                <p class="animated fadeInDown">WHO SAID EDUCATION WAS BORING?</p>
                                <a href="#" class="first-btn kids-care-btn bgc-orange animated fadeInRight">More
                                    about us</a>
                                <a href="#" class="first-btn  kids-care-btn bg-blue animated fadeInRight">Get
                                    Admission</a>
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
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-1.png') }}"
                                        alt="">
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
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-2.png') }}"
                                        alt="">
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
                                    <img src="{{ asset('assets/img/panel/icon/feature-icon-3.png') }}"
                                        alt="">
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
                                    <h2 class="font-orange area-heading">WELCOME TO<br>THE KINDERGARTEN!</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non
                                        proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem
                                        ipsum dolor sit amet,cuculpa qui officiacuculpa qui officiacuculpa qui
                                        officiaLorem ipsum dolor sit amet</p>
                                    <a href="#" class="kids-care-btn bg-red">Why Kindergarten?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Wellcome area end-->
    <!--Class area start-->
    <section class="choose-class-area bg-white">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-orange st-two">CHOOSE CLASSES FOR YOUR CHILD</h2>
                    <p class="area-subline">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class=" row">

                        <!--Single class start-->
                        <div class="col-sm-6 col-xl-3">
                            <div class="single-class style-two  wow fadeInUp" data-wow-delay=".4s">
                                <div class="class-img-two">
                                    <img src="{{ asset('assets/img/panel/class/class11.jpg') }}" alt="">
                                </div>

                                <div class="price red-drop">
                                    <p>$15</p>
                                    <span>per Day</span>
                                </div>
                                <div class="class-name">
                                    <h5><a href="">PG Class</a></h5>
                                </div>
                            </div>
                        </div>

                        <!--Single class start-->
                        <div class="col-sm-6 col-xl-3">
                            <div class="single-class style-two  wow fadeInUp" data-wow-delay=".6s">
                                <div class="class-img-two">
                                    <img src="{{ asset('assets/img/panel/class/class9.jpg') }}" alt="">
                                </div>
                                <div class="price red-drop">
                                    <p>$15</p>
                                    <span>per Day</span>
                                </div>
                                <div class="class-name style-two bg-red">
                                    <h5><a href="">KG Class</a></h5>
                                </div>
                            </div>
                        </div>

                        <!--Single class start-->
                        <div class="col-xl-3 col-sm-6">
                            <div class="single-class style-two wow fadeInUp" data-wow-delay=".8s">
                                <div class="class-img-two">
                                    <img src="{{ asset('assets/img/panel/class/class10.jpg') }}" alt="">
                                </div>
                                <div class="price red-drop">
                                    <p>$15</p>
                                    <span>per Day</span>
                                </div>
                                <div class="class-name bg-sky ">
                                    <h5><a href="">Math Class</a></h5>
                                </div>
                            </div>
                        </div>
                        <!--Single class start-->
                        <div class="col-xl-3 col-sm-6">
                            <div class="single-class style-two  wow fadeInUp" data-wow-delay=".8s">
                                <div class="class-img-two">
                                    <img src="{{ asset('assets/img/panel/class/class11.jpg') }}" alt="">
                                </div>
                                <div class="price red-drop">
                                    <p>$15</p>
                                    <span>per Day</span>
                                </div>
                                <div class="class-name style-two  bg-green">
                                    <h5><a href="">Art Classes</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Class area end-->

    <!--Expect area start-->
    <section class="expect-area bg-white">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-w st-two">What to Expect</h2>
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
                            <h5>Fast Delivery</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non proident,
                                sunt in </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon2.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>large playground</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non proident,
                                sunt in </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sin-expect wow fadeInUp" data-wow-delay=".6s">
                        <div class="ex-icon">
                            <img src="{{ asset('assets/img/panel/icon/ex-icon3.png') }}" alt="">
                        </div>
                        <div class="ex-detail">
                            <h5>Physical Activity</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat non proident,
                                sunt in </p>
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

    <!--Teachers area start-->
    <section class="kids-care-teachers-area style-3">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading st-two font-sky">OUR EXPERTS TEACHERS</h2>
                    <p class="area-subline">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="inner-container">
                <div class="row ">
                    <div class="teacher-car-start-two owl-carousel owl-theme">

                        <!--Single teacher-->
                        <div class="  col-xl-12 item">
                            <div class="single-teacher style-b">
                                <div class="teacher-img">
                                    <img src="{{ asset('assets/img/panel/teacher/team-b1.png') }}" alt="">
                                </div>
                                <div class="teacher-detail">
                                    <h4>Lily Carter</h4>
                                    <p>Active Learning Teacher</p>
                                    <div class="teacher-social">
                                        <ul>
                                            <li><a class="fb" href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li><a class="ins" href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li><a class="pin" href="#"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li><a class="linked" href="#"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--Single teacher-->

                        <div class="col-xl-12 item">
                            <div class="single-teacher style-b">
                                <div class="teacher-img">
                                    <img src="{{ asset('assets/img/panel/teacher/team-b2.png') }}" alt="">
                                </div>
                                <div class="teacher-detail">
                                    <h4>Ryan Austin</h4>
                                    <p>Active Learning Teacher</p>
                                    <div class="teacher-social">
                                        <ul>
                                            <li><a class="fb" href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li><a class="ins" href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li><a class="pin" href="#"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li><a class="linked" href="#"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Single teacher-->

                        <div class="single-teacher col-xl-12 item">
                            <div class="single-teacher style-b">
                                <div class="teacher-img">
                                    <img src="{{ asset('assets/img/panel/teacher/team-b3.png') }}" alt="">
                                </div>
                                <div class="teacher-detail">
                                    <h4>Lisa Gutierrez</h4>
                                    <p>Preschool Teach</p>
                                    <div class="teacher-social">
                                        <ul>
                                            <li><a class="fb" href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li><a class="ins" href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li><a class="pin" href="#"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li><a class="linked" href="#"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Single teacher-->

                        <div class="single-teacher col-xl-12 item">
                            <div class="single-teacher style-b">
                                <div class="teacher-img">
                                    <img src="{{ asset('assets/img/panel/teacher/team-b4.png') }}" alt="">
                                </div>
                                <div class="teacher-detail">
                                    <h4>Rose Wagner</h4>
                                    <p>Creative Director</p>
                                    <div class="teacher-social">
                                        <ul>
                                            <li><a class="fb" href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li><a class="ins" href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li><a class="pin" href="#"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li><a class="linked" href="#"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Teachers area end-->

    <!--Countdown area start-->
    <section class="countdown-one bol-bol-bg">
        <div class="img-left-tes flipInX wow " data-wow-delay=".5s">
            <img src="{{ asset('assets/img/panel/bg/children_hand.png') }}" alt="">
        </div>
        <div class="img-right-tes flipInX wow" data-wow-delay=".6s">
            <img src="{{ asset('assets/img/panel/bg/raising-hands.png') }}" alt="">
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-w st-two">FIRST DAY AT SCHOOL !</h2>
                    <p class="area-subline font-w">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat
                        cupidatat non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem
                        ipsum dolor sit amet,cuculpa qui officiacuculpa.</p>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="count-down">
                        <div data-countdown="2020/03/11"></div>
                    </div>

                </div>
                <div class="col-xl-12">
                    <a href="contact.html" class="kids-care-btn bg-red">ADMISSION NOW</a>
                </div>
            </div>
        </div>
    </section>
    <!--Countdown area end-->

    <!--Class routine area start-->
    <section class="kids-care-routine-area style-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-per st-two">Class Routine<img
                            src="{{ asset('assets/img/panel/icon/pen-per.png') }}" alt=""></h2>
                    <p class="area-subline">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="table-wrapper">
                        <table style="width:100%">

                            <tr class="table-time">
                                <td class="table-corner font-green">Day</td>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                                <th scope="col">8.00 am - 9.00 am</th>
                            </tr>
                            <tr>
                                <th scope="row">sat</th>
                                <td class="bgc-orange">Mathmetics</td>
                                <td class="bg-yellow">Art class</td>
                                <td class="bg-brick">Open</td>
                                <td class="bg-green">Sports</td>
                                <td class="bg-blue-two">Social awarness</td>
                                <td class="bg-per">Basic Skills</td>
                                <td class="bgc-orange">Geography</td>
                            </tr>
                            <tr>
                                <th scope="row">sun</th>
                                <td class="bg-yellow">Mathmetics</td>
                                <td class="bg-brick">Geography</td>
                                <td class="bg-green">Closed</td>
                                <td class="bg-blue-two">Art class</td>
                                <td class="bg-per">Basic Skills</td>
                                <td class="bgc-orange">Sports</td>
                                <td class="bg-yellow">Social awarness</td>
                            </tr>
                            <tr>
                                <th scope="row">mon</th>
                                <td class="bg-brick">Sports</td>
                                <td class="bg-green">Social</td>
                                <td class="bg-blue-two">Basic Skills</td>
                                <td class="bg-per">Mathmetics</td>
                                <td class="bgc-orange">Art class</td>
                                <td class="bg-yellow">Geography</td>
                                <td class="bg-brick">Social awarness</td>
                            </tr>
                            <tr>
                                <th scope="row">tue</th>
                                <td class="bg-green">Art class</td>
                                <td class="bg-blue-two">Geography</td>
                                <td class="bg-per">Basic Skills</td>
                                <td class="bgc-orange">Mathmetics</td>
                                <td class="bg-yellow">Art class</td>
                                <td class="bg-brick">Sports</td>
                                <td class="bg-green">Social awarness</td>
                            </tr>
                            <tr>
                                <th scope="row">wed</th>
                                <td class="bg-blue-two">Basic Skills</td>
                                <td class="bg-per">Geography</td>
                                <td class="bgc-orange">Sports</td>
                                <td class="bg-yellow">Social</td>
                                <td class="bg-brick">Art class</td>
                                <td class="bg-green">Social awarness</td>
                                <td class="bg-blue-two">Geography</td>
                            </tr>
                            <tr>
                                <th scope="row">thus</th>
                                <td class="bg-per">Social awarness</td>
                                <td class="bgc-orange">Social</td>
                                <td class="bg-yellow">Geography</td>
                                <td class="bg-brick">Mathmetics</td>
                                <td class="bg-green">Art class</td>
                                <td class="bg-blue-two">Sports</td>
                                <td class="bg-per">Basic Skills</td>
                            </tr>

                        </table>
                        <div class="routine-holiday"><span>Friday ( holidays )</span></div>
                    </div>
                    <div class="res-routine collapse-wrapper">
                        <div id="accordion" role="tablist">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingEight">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseEight"
                                            aria-expanded="true" aria-controls="collapseEight">Saturday </a>
                                    </h5>
                                </div>

                                <div id="collapseEight" class="collapse " role="tabpanel" data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">

                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" role="tab" id="headingTen">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseTen"
                                            aria-expanded="false" aria-controls="collapseTen">
                                            Sunday
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTen" class="collapse" role="tabpanel" aria-labelledby="headingFive"
                                    data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">

                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" role="tab" id="headingTwo">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Monday
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">

                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingThree">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            Tuesday
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" role="tabpanel"
                                    aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingFour">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            Wednesday
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseFour" class="collapse" role="tabpanel"
                                    aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">

                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" role="tab" id="headingFive">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            Thursday
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseFive" class="collapse" role="tabpanel"
                                    aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body row no-gutters">

                                        <div class="col-md-12">

                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">8.00 am - 9.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">9.00 am - 10.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Art class</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">10.00 am - 11.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Geography</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">11.00 am - 12.00 am</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-brick">Mathmetics</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">12.00 am - 1.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-per">Social awarness</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">1.00 pm - 2.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-orange">Basic skills</div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">2.00 pm - 3.00 pm</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="sin-sub bg-green">Mathmetics</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Class routine area end-->

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
                                        <h6 class="font-green">Kevin Boyd</h6>
                                        <p>UI / UX Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Single popular testimonial-->
                        <div class="col-xl-12 item">
                            <div class="sin-pop-tes color-red">
                                <div class="con-part">
                                    <h6>Active Learning</h6>
                                    <p>Lorem ipsum dolor sit amsectet urExcepteur sint occaecat cupidatat non proident,
                                        sunt in cuculpa qu officiaulpa qui officiacuculpa qui officiaLorem ipsum dolor
                                    </p>
                                </div>
                                <div class="img-part">
                                    <div class="pt-img">
                                        <img src="{{ asset('assets/img/panel/icon/tes-c2.png') }}" alt="">
                                    </div>
                                    <div class="pt-intro">
                                        <h6 class="font-green">Angela Estrada</h6>
                                        <p>UI / UX Designer</p>
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
                                        <h6 class="font-green">Catherine Hayes</h6>
                                        <p>UI / UX Designer</p>
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

    <!--Call to action area start-->
    <section class="call-to-action-area">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-sm-12 col-lg-9">
                    <h4>How To Enroll Your Child To a Class</h4>
                    <p>Interested in good preschool education for your child? Our kindergarten is the right decision!
                    </p>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <a href="#" class="kids-care-btn bg-red">Get Admission</a>
                </div>
            </div>
        </div>
    </section>
    <!--Call to action area end-->


    <!--Events area start-->
    <section class="kids-care-event-area">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading  st-two font-red">UPCOMING EVENTS</h2>
                    <p class="area-subline">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
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
                            <div class="price red-drop">
                                <p>$15</p>
                            </div>
                            <h6>Annual Sports and Misic Day...</h6>
                            <span>Mon-Tue-Fri , 8:00 am</span>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-green" href="#">booking now</a>
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
                            <div class="price red-drop">
                                <p>$15</p>
                            </div>
                            <h6>Annual Sports and Misic Day...</h6>
                            <span>Mon-Tue-Fri , 8:00 am</span>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-orange" href="#">booking now</a>
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
                            <div class="price red-drop">
                                <p>$15</p>
                            </div>
                            <h6>Annual Sports and Misic Day...</h6>
                            <span>Mon-Tue-Fri , 8:00 am</span>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-red" href="#">booking now</a>
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
                            <div class="price red-drop">
                                <p>$15</p>
                            </div>
                            <h6>Annual Sports and Misic Day...</h6>
                            <span>Mon-Tue-Fri , 8:00 am</span>
                            <p>Class aptent taciti sociosqu adtora torq uent per cbia mauris eros ntra.Class aptent
                                taciti sociosqu
                                citi sociosqu adtora.</p>
                            <a class="bg-sky" href="#">booking now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Events area end-->

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
                                <a href="{{ asset('assets/img/panel/gallery/gal-1.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-2.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-3.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-4.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-5.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-6.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-7.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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
                                <a href="{{ asset('assets/img/panel/gallery/gal-8.jpg') }}"
                                    class="venobox vbox-item" data-gall="gallery1"><i
                                        class="fa fa-search"></i></a>
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

    <!--Latest news three area start-->
    <section class="latest-news-three">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading st-two font-per">Latest News</h2>
                    <p class="area-subline ">Lorem ipsum dolor sit amet, consectetur Excepteur sint occaecat cupidatat
                        non proident, sunt in cuculpa qui officiacuculpa qui officiacuculpa qui officiaLorem ipsum dolor
                        sit amet,cuculpa qui officiacuculpa.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="sin-lat-n3">
                        <img src="{{ asset('assets/img/panel/latest-news/lnc1.png') }}" alt="">
                        <div class="ln3-cont">
                            <h5>Vestibulum Congue Massa.</h5>
                            <div class="aut-date">
                                <a href=""><span><i class="fa fa-user"></i>Jone Doe</span></a>
                                <a href=""><span><i class="fa fa-calendar" aria-hidden="true"></i>March
                                        21</span></a>
                            </div>
                            <p>Lorem ipsum dolor sit consectetur Excepteur sint occaecat cupidatat non proident, sunt in
                                cuculpa qui officiacuculpa</p>
                            <a href="#" class="kids-care-btn bgc-orange" style="">Read More</a>
                            <div class="lnc-meta">
                                <div class="sin-lnc">
                                    <span><i class="fa fa-thumbs-up"></i>like</span>
                                    <p>12</p>
                                </div>
                                <div class="sin-lnc">
                                    <span><i class="fa fa-comments"></i>comment</span>
                                    <p>09</p>
                                </div>
                                <div class="sin-lnc">
                                    <span><i class="fa fa-eye"></i>View</span>
                                    <p>123</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-lat-n3">
                        <img src="{{ asset('assets/img/panel/latest-news/lnc2.png') }}" alt="">
                        <div class="ln3-cont">
                            <h5>Vestibulum Congue Massa.</h5>
                            <div class="aut-date">
                                <a href=""><span><i class="fa fa-user"></i>Jone Doe</span></a>
                                <a href=""><span><i class="fa fa-calendar" aria-hidden="true"></i>March
                                        21</span></a>
                            </div>
                            <p>Lorem ipsum dolor sit consectetur Excepteur sint occaecat cupidatat non proident, sunt in
                                cuculpa qui officiacuculpa</p>
                            <a href="#" class="kids-care-btn bgc-orange" style="">Read More</a>
                            <div class="lnc-meta">
                                <div class="sin-lnc">
                                    <a href="#">
                                        <span><i class="fa fa-thumbs-up"></i>like</span>
                                        <p>12</p>

                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-comments"></i>comment</span>
                                        <p>09</p>
                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-eye"></i>View</span>
                                        <p>123</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-lat-n3">
                        <img src="{{ asset('assets/img/panel/latest-news/lnc3.png') }}" alt="">
                        <div class="ln3-cont">
                            <h5>Phasellus id tempor.</h5>
                            <div class="aut-date">
                                <a href=""><span><i class="fa fa-user"></i>Jone Doe</span></a>
                                <a href=""><span><i class="fa fa-calendar" aria-hidden="true"></i>March
                                        21</span></a>
                            </div>
                            <p>Lorem ipsum dolor sit consectetur Excepteur sint occaecat cupidatat non proident, sunt in
                                cuculpa qui officiacuculpa</p>
                            <a href="#" class="kids-care-btn bgc-orange" style="">Read More</a>
                            <div class="lnc-meta">
                                <div class="sin-lnc">
                                    <a href="#">
                                        <span><i class="fa fa-thumbs-up"></i>like</span>
                                        <p>12</p>

                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-comments"></i>comment</span>
                                        <p>09</p>
                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-eye"></i>View</span>
                                        <p>123</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="sin-lat-n3">
                        <img src="{{ asset('assets/img/panel/latest-news/lnc4.png') }}" alt="">
                        <div class="ln3-cont">
                            <h5>Aenean vehicula velit.</h5>
                            <div class="aut-date">
                                <a href=""><span><i class="fa fa-user"></i>Jone Doe</span></a>
                                <a href=""><span><i class="fa fa-calendar" aria-hidden="true"></i>March
                                        21</span></a>
                            </div>
                            <p>Lorem ipsum dolor sit consectetur Excepteur sint occaecat cupidatat non proident, sunt in
                                cuculpa qui officiacuculpa</p>
                            <a href="#" class="kids-care-btn bgc-orange" style="">Read More</a>
                            <div class="lnc-meta">
                                <div class="sin-lnc">
                                    <a href="#">
                                        <span><i class="fa fa-thumbs-up"></i>like</span>
                                        <p>12</p>

                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-comments"></i>comment</span>
                                        <p>09</p>
                                    </a>
                                </div>
                                <div class="sin-lnc">
                                    <a href="">
                                        <span><i class="fa fa-eye"></i>View</span>
                                        <p>123</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Latest news three area end-->

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