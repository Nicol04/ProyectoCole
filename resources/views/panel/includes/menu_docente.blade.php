<!--Main menu area start-->
<section class="main-menu-area border-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-2">
                <div class="logo">
                    <a href="">
                        <img src="{{ asset('assets/img/panel/logo.png') }}" alt=""alt="" width="400">
                    </a>
                </div>
                <div class="accordion-wrapper hide-sm-up">
                    <a href="#" class="mobile-open"><i class="fa fa-bars"></i></a>

                    <!--Mobile Menu start-->
                    <ul id="mobilemenu" class="accordion">
                        <li class="mob-logo"><a href="">
                                <img src="{{ asset('assets/img/panel/logo.png') }}" alt="" alt=""
                                    width="400">
                            </a></li>
                        <li><a class="closeme" href="#"><i class="fa fa-times"></i></a></li>
                        <li class="fc-red out-link"><a class="" href="">Hogar</a></li>
                        <li>
                            <div class="link font-sky">Paginas<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-sky">
                                <li><a href="">Crear evaluaciones</a></li>
                                <li><a href="">Retroalimentación IA</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-orange">Mi aula<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-orange">
                                <li><a href="/panel/cursos">Mis cursos</a></li>
                                <li><a href="/panel/estudiantes">Mis estudiantes</a></li>
                            </ul>
                        </li>

                        <li>
                            <div class="link font-per"><a href="">Evaluaciones IA</a></div>
                        </li>
                        <li>
                            <div class="link font-per"><a href="">Comunicados</a></div>
                        </li>
                        <li>
                            <div class="link font-red"><a href="/recursos">Recursos</a></div>
                        </li>
                        <li>
                            <div class="link font-per"><a href="/users/perfil">Perfil</a></div>
                        </li>
                        <li>
                            <div class="top-contact-btn">
                                <a href="" class="kids-care-btn bg-sky">Cerrar Sesion</a>
                            </div>
                        </li>

                    </ul>
                    <!--Mobile Menu end-->
                </div>
            </div>

            <!--Main menu start-->
            <div class="col-md-9 col-lg-9 col-xl-8">
                <div class="mainmenu float-right style-4">
                    <ul id="navigation">
                        <li class="fc-orange">
                            <img src="{{ asset('assets/img/panel/icon/menu-icon3.png') }}" alt="">
                            <a href="">Hogar</a>
                        </li>
                        <li class="fc-sky hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon2.png') }}"
                                alt=""><a href="#">Mi aula<i class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <h4><a href="/panel/cursos"><span>Mis cursos</span></a></h4>
                                </div>
                                <div class="mega-catagory">
                                    <h4><a class="font-green" href="/panel/estudiantes"><span>Mis estudiantes</span></a>
                                    </h4>
                                </div>
                            </div>
                        </li>
                        <li class="fc-red hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon1.png') }}"
                                alt=""><a href="#" class="font-red">Paginas<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <div class="mega-button">
                                        <a href="/evaluaciones/create"><span>Crear evaluaciones</span></a>
                                        <a href=""><span>Retroalimentación IA</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-green hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon4.png') }}"
                                alt=""><a href="">Evaluaciones IA</a>
                        </li>
                        <li class="fc-per"><img src="{{ asset('assets/img/panel/icon/menu-icon5.png') }}"
                                alt=""><a href="events.html">Comunicados</a></li>
                        <li class="fc-orange hav-sub"> <img src="{{ asset('assets/img/panel/icon/menu-icon6.png') }}"
                                alt=""> <a href="/recursos">Recursos</a>
                        </li>
                        <li class="fc-sky hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon7.png') }}"
                                alt=""><a href="/users/perfil">Perfil</a></li>
                    </ul>
                </div>
            </div>
            <!--Main menu end-->
            <div class="col-lg-3 col-xl-2">
                <div class="serch-wrapper float-right hide-sm">
                    <div class="top-contact-btn align-middle">
                        <!-- Menú desplegable activado por el avatar -->
                        <div class="dropdown">
                            <!-- Botón avatar -->
                            <button class="btn dropdown-toggle p-0 border-0 bg-transparent" type="button"
                                data-toggle="dropdown" aria-expanded="false">
                                @if (Auth::check() && Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar->path) }}" alt="Avatar"
                                        class="avatar-img avatar-elevated"
                                        style="width: 80px; height: 80px; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" alt="Avatar por defecto"
                                        class="avatar-img avatar-elevated"
                                        style="width: 80px; height: 80px; border-radius: 50%;">
                                @endif
                            </button>

                            <!-- Menú desplegable -->
                            <div class="dropdown-menu dropdown-menu-right text-center">
                                <span class="dropdown-item-text">
                                    <a href="/users/perfil" class="link-red">
                                        <i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }}
                                    </a>
                                </span>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-red">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>Salir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--fin-->
        </div>
    </div>
</section>
<!--Main menu area end-->