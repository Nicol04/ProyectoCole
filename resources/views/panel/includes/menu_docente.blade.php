<!--Main menu area start-->
<section class="main-menu-area border-top">

    @if (auth()->check())
    @php
        $user = Auth::user();
        $roleId = $user->roles->first()?->id;
        
        // Obtener IDs de aulas del usuario
        $aulasIds = $user->usuario_aulas()
            ->pluck('aula_id')
            ->toArray();
            
        // Verificar si tiene aulas de primaria (ID 10-25)
        $tieneAulaPrimaria = array_filter($aulasIds, function($id) {
            return $id >= 10 && $id <= 25;
        });
        
        // Verificar si tiene otras aulas (ID 1-9)
        $tieneOtrasAulas = array_filter($aulasIds, function($id) {
            return $id >= 1 && $id <= 9;
        });

        // Obtener los cursos del usuario
        $cursos = [];
        if (!empty($aulasIds)) {
            $cursos = DB::table('aula_curso')
                ->whereIn('aula_id', $aulasIds)
                ->join('cursos', 'aula_curso.curso_id', '=', 'cursos.id')
                ->select('cursos.*')
                ->get();
        }
    @endphp
    

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-2">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('assets/img/panel/logo.png') }}" alt=""alt="" width="400">
                    </a>
                </div>
                <div class="accordion-wrapper hide-sm-up">
                    <a href="#" class="mobile-open"><i class="fa fa-bars"></i></a>

                    <!--Mobile Menu start-->
                    <ul id="mobilemenu" class="accordion">
                        <li class="mob-logo"><a href="{{ route('index') }}">
                                <img src="{{ asset('assets/img/panel/logo.png') }}" alt="" alt=""
                                    width="400">
                            </a></li>
                        <li><a class="closeme" href="#"><i class="fa fa-times"></i></a></li>
                        <li class="fc-red out-link"><a class="{{ route('index') }}" href="">Hogar</a></li>

                        @if(!empty($tieneAulaPrimaria))

                        <li>
                            <div class="link font-sky">Planificaciones<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-sky">
                                <li><a href="{{ route('sesiones.createSession') }}">Crear sesiones</a></li>
                                <li><a href="">Crear fichas de aprendizaje</a></li>
                                <li><a href="">Crear unidades</a></li>
                                <li><a href="">Planificaciones</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-orange">Mi aula<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-orange">
                                <li><a href="{{ route('panel.cursos') }}">Mis cursos</a>
                                </li>
                                <li><a href="{{ route('estudiantes.index') }}">Mis estudiantes</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-per"><a href="{{ route('calificacion.show') }}">Documentos</a></div>
                        </li>
                        <li>
                            <div class="link font-red"><a href="{{ route('calificacion.show') }}">Publicaciones</a></div>
                        </li>
                        @endif
                        @if(!empty($tieneOtrasAulas))
                        <li>
                            <div class="link font-sky">Paginas<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-sky">
                                <li><a href="{{ route('evaluacion.create') }}">Crear evaluaciones</a></li>
                                <li><a href="{{ route('retroalimentacion') }}">Retroalimentación IA</a></li>
                                <li><a href="{{ route('informativa') }}">Tutorial</a></li>
                                <li><a href="{{ route('comunicados.create') }}">Crear comunicados</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-orange">Mi aula<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-orange">
                                <li><a href="{{ route('panel.cursos') }}">Mis cursos</a>
                                </li>
                                <li><a href="{{ route('estudiantes.index') }}">Mis estudiantes</a></li>
                            </ul>
                        </li>

                        <li>
                            <div class="link font-per"><a href="{{ route('calificacion.show') }}">Calificaciones</a></div>
                        </li>
                        <li>
                            <div class="link font-per"><a href="{{ route('comunicados.index') }}">Comunicados</a></div>
                        </li>
                        <li>
                            <div class="link font-red"><a href="{{ route('recursos.index') }}">Recursos</a></div>
                        </li>
                        @endif
                        <li>
                            <div class="link font-per"><a href="{{ route('users.perfil') }}">Perfil</a></div>
                        </li>
                        <li>
                            <div class="top-contact-btn">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="kids-care-btn bg-sky">Salir</button>
                                </form>
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
                            <a href="{{ route('index') }}">Hogar</a>
                        </li>
                        <li class="fc-sky hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon2.png') }}"
                                alt=""><a href="#">Mi aula<i class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <h4><a href="{{ route('panel.cursos') }}"><span>Mis cursos</span></a></h4>
                                    <div class="mega-button">
                                        <ul>
                                            @forelse ($cursos as $curso)
                                                <a
                                                    href="{{ route('sesiones.index', ['id' => $curso->id]) }}"><span>{{ $curso->curso }}</span></a>
                                            @empty
                                                <li>No tienes cursos asignados</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="mega-catagory">
                                    <h4><a class="font-green" href="{{ route('estudiantes.index') }}"><span>Mis estudiantes</span></a>
                                    </h4>
                                </div>
                            </div>
                        </li>
                        
                        @if(!empty($tieneAulaPrimaria))
                        <li class="fc-red hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon1.png') }}"
                                alt=""><a href="#" class="font-red">Planificador<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <div class="mega-button">
                                        <a href="{{ route('sesiones.createSession') }}"><span>Crear sesiones</span></a>
                                        <a href="{{ route('retroalimentacion') }}"><span>Crear fichas de aprendizaje</span></a>
                                        <a href="{{ route('unidades.create') }}">Crear unidades</a>
                                        <a href="{{ route('comunicados.create') }}">Crear comunicados</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-green hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon4.png') }}"
                                alt=""><a href="{{ route('calificacion.show') }}">Documentos</a>
                        </li>
                        <li class="fc-per"><img src="{{ asset('assets/img/panel/icon/menu-icon5.png') }}"
                                alt=""><a href="{{ route('comunicados.index') }}">Publicaciones</a></li>
                        @endif
                        @if(!empty($tieneOtrasAulas))


                        <li class="fc-red hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon1.png') }}"
                                alt=""><a href="#" class="font-red">Paginas<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <div class="mega-button">
                                        <a href="{{ route('evaluacion.create') }}"><span>Crear evaluaciones</span></a>
                                        <a href="{{ route('retroalimentacion') }}"><span>Retroalimentación IA</span></a>
                                        <a href="{{ route('informativa') }}">Ver tutorial</a>
                                        <a href="{{ route('comunicados.create') }}">Crear comunicados</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-green hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon4.png') }}"
                                alt=""><a href="{{ route('calificacion.show') }}">Calificaciones</a>
                        </li>
                        <li class="fc-per"><img src="{{ asset('assets/img/panel/icon/menu-icon5.png') }}"
                                alt=""><a href="{{ route('comunicados.index') }}">Comunicados</a></li>
                        <li class="fc-orange hav-sub"> <img src="{{ asset('assets/img/panel/icon/menu-icon6.png') }}"
                                alt=""> <a href="{{ route('recursos.index') }}">Recursos</a>
                        </li>
                        @endif
                        <li class="fc-sky hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon7.png') }}"
                                alt=""><a href="{{ route('users.perfil') }}">Perfil</a></li>
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
                                        style="height: 70px; width: 60px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" alt="Avatar por defecto"
                                        class="avatar-img avatar-elevated"
                                        style="height: 70px; width: 60px; border-radius: 50%; object-fit: cover;">
                                @endif
                            </button>

                            <!-- Menú desplegable -->
                            <div class="dropdown-menu dropdown-menu-right text-center">
                                <span class="dropdown-item-text">
                                    <a href="{{ route('users.perfil') }}" class="link-red">
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
    @endif
</section>
<!--Main menu area end-->
