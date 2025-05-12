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
                                <img src="{{ asset('assets/img/panel/logo.png') }}" alt="" alt="" width="400">
                            </a></li>
                        <li><a class="closeme" href="#"><i class="fa fa-times"></i></a></li>
                        <li class="fc-red out-link"><a class="" href="">Hogar</a></li>
                        <li>
                            <div class="link font-sky">Paginas<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-sky">
                                <li><a href="">Mis evaluaciones</a></li>
                                <li><a href="">Retroalimentación IA</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-orange">Mi aula<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-orange">
                                <li><a href="#">Mis cursos</a></li>
                                <li><a href="#">Mi docente</a></li>
                                <li><a href="#">Mis compañeros</a></li>
                            </ul>
                        </li>

                        <li>
                            <div class="link font-per"><a href="">Evaluaciones</a></div>
                        </li>
                        <li>
                            <div class="link font-per"><a href="">Comunicados</a></div>
                        </li>
                        <li>
                            <div class="link font-red">Recursos<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-red">
                                <li><a href="#">Faq</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-per"><a href="">Perfil</a></div>
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
                            alt=""><a href="#" >Mi aula<i
                                class="fa fa-angle-down"></i></a>
                        <div class="mega-menu">
                            <div class="mega-catagory">
                                <h4><a href="/panel/cursos"><span>Mis cursos</span></a></h4>
                            </div>
                            <div class="mega-catagory">
                                <h4><a class="font-per"><span>Mi docente</span></a></h4>
                                <div class="mega-button">
                                </div>
                            </div>
                            <div class="mega-catagory">
                                <h4><a class="font-green"
                                    href="/panel/estudiantes"><span>Compañeros</span></a></h4>
                            </div>
                        </div>
                    </li>
                        <li class="fc-red hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon1.png') }}"
                                alt=""><a href="#" class="font-red">Paginas<i class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <div class="mega-button">
                                        <a href=""><span>Mis evaluaciones</span></a>
                                        <a href=""><span>Retroalimentación IA</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-green hav-sub"><img
                                src="{{ asset('assets/img/panel/icon/menu-icon4.png') }}" alt=""><a
                                href="">Evaluaciones</a>
                        </li>
                        <li class="fc-per"><img src="{{ asset('assets/img/panel/icon/menu-icon5.png') }}"
                                alt=""><a href="events.html">Comunicados</a></li>
                        <li class="fc-orange hav-sub"> <img
                                src="{{ asset('assets/img/panel/icon/menu-icon6.png') }}" alt=""> <a
                                href="">Recursos<i class="fa fa-angle-down"></i></a>
                            <div class="mega-menu mm-two">
                                <div class="mega-catagory">
                                    <h4><a href="blog.html"><span>Mensajes</span></a></h4>
                                    <div class="mega-button">
                                        <a href="blog.html"><span>Blog</span></a>
                                        <a href="blog-leftsidebar.html"><span>Blog with sidbar</span></a>
                                        <a href="blog-rightsidebar.html"><span>Blog right sidbar</span></a>
                                        <a href="blog-leftsidebar.html"><span>Blog left sidbar</span></a>
                                        <a href="single.html"><span>Single blog</span></a>
                                    </div>
                                </div>
                                <div class="mega-catagory">
                                    <h4><a class="font-per" href="shop.html"><span>Shop</span></a></h4>
                                    <div class="mega-button">
                                        <a href="shop.html"><span>Cart page</span></a>
                                        <a href="shop.html"><span>Shop page </span></a>
                                        <a href="admission.html"><span>Registration</span></a>
                                        <a href="shop.html"><span>Checkout</span></a>
                                        <a href="product.html"><span>Single shop</span></a>
                                    </div>
                                </div>
                                <div class="mega-catagory">
                                    <h4><a class="font-green" href="shop.html"><span>Recursos</span></a></h4>
                                    <div class="mega-button">
                                        <a href="product.html"><span>Single Product</span></a>
                                        <a href="shop.html"><span>Shop Page</span></a>
                                        <a href="admission.html"><span>Registration</span></a>
                                        <a href="contact.html"><span>Contact form</span></a>
                                        <a href="product.html"><span>Product</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-sky hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon7.png') }}"
                            alt=""><a href="">Perfil</a></li>
                    </ul>
                </div>
            </div>
            <!--Main menu end-->
            <div class="col-lg-3 col-xl-2">
                <div class="serch-wrapper float-right hide-sm">
                    <div class="search align-middle">
                        <input class="search-input" placeholder="Search" type="text">
                        <a href="javascript:void(0)"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="top-contact-btn align-middle">
                        <form action="{{ route('logout') }}" class="kids-care-btn bg-sky" method="POST">
                            @csrf
                            <button type="submit" class="logout-button kids-care-btn bg-sky">Salir</button>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section>
<!--Main menu area end-->