<!--Main menu area start-->
<section class="main-menu-area border-top">


    @if (auth()->check())
        @php
            $user = Auth::user();
            $roleId = $user->roles->first()?->id;

            $aula = $user->aulas()->first();

            $docente = null;
            if ($aula) {
                $docente = $aula
                    ->users()
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'docente');
                    })
                    ->first();
            }

            $nombreDocente = $docente ? $docente->persona->nombre . ' ' . $docente->persona->apellido : 'No asignado';
            $cursos = $aula ? $aula->cursos : collect();
        @endphp
    @endif
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
                                <li><a href="{{ route('estudiantes.show', Auth::id()) }}">Mis evaluaciones</a></li>
                                <li><a href="">Mi promedio</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="link font-orange">Mi aula<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu font-orange">
                                <li><a href="/panel/cursos">Mis cursos</a></li>
                                <li><a href="">Mi docente</a>
                                </li>
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
                                    <h4><a class="font-per"><span>Mi docente</span></a></h4>
                                    <div class="mega-button">
                                        <a><span>{{ $nombreDocente }}</span></a>
                                    </div>
                                </div>
                                <div class="mega-catagory">
                                    <h4><a class="font-green" href="/panel/estudiantes"><span>Compañeros</span></a></h4>
                                </div>
                            </div>
                        </li>
                        <li class="fc-red hav-sub"><img src="{{ asset('assets/img/panel/icon/menu-icon1.png') }}"
                                alt=""><a href="#" class="font-red">Paginas<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="mega-menu">
                                <div class="mega-catagory">
                                    <div class="mega-button">
                                        <a href="{{ route('estudiantes.show', Auth::id()) }}"><span>Mis
                                                calificaciones</span></a>
                                        <a href="{{ route('calificacion.index', Auth::id()) }}"><span>Mi
                                                promedio</span></a>
                                        <a href="{{ route('informativa') }}">Tutorial</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fc-green hav-sub">
                            <img src="{{ asset('assets/img/panel/icon/menu-icon4.png') }}" alt="">
                            <a href="/evaluaciones">
                                Evaluaciones
                                @if (isset($evaluacionesPendientesCount) && $evaluacionesPendientesCount > 0)
                                    <span class="ms-1 text-danger" style="font-weight: bold;">
                                        ({{ $evaluacionesPendientesCount }})
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="fc-per position-relative">
                            <img src="{{ asset('assets/img/panel/icon/menu-icon5.png') }}" alt="">
                            <a href="javascript:void(0)" id="btnToggleComunicados">
                                Comunicados
                                @if (Auth::check() && Auth::user()->roles->first()?->id == 3 && count($comunicadosNoVistos) > 0)
                                    <span id="noti-count" class="ms-1 text-danger"style="font-weight: bold;">
                                        ({{ count($comunicadosNoVistos) }})
                                    </span>
                                @endif
                            </a>

                            <!-- Panel flotante de comunicados -->
                            <div id="panelComunicados"
                                class="comunicados-dropdown d-none shadow bg-white rounded position-absolute mt-2"
                                style="min-width: 320px; z-index: 1000; right: 0;">
                                <div class="p-3 border-bottom">
                                    <strong>Comunicados recientes</strong>
                                </div>
                                <div class="comunicados-list max-h-300 overflow-auto">
                                    @forelse ($comunicadosNoVistos as $comunicado)
                                        <div class="p-3 border-bottom comunicado-item cursor-pointer ver-comunicado-btn"
                                            data-id="{{ $comunicado->id }}"
                                            data-mensaje="{{ $comunicado->mensaje }}">

                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="me-2" style="flex: 1;">
                                                    <p class="mb-1 fw-bold text-dark">
                                                        {{ Str::limit($comunicado->mensaje, 50) }}</p>
                                                    <small
                                                        class="text-muted">{{ $comunicado->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="ms-2">
                                                    <i class="fas fa-bell text-danger"></i>
                                                    <!-- Icono de notificación -->
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-3 text-muted text-center">
                                            <i class="fas fa-inbox-open text-secondary fs-4 mb-2 d-block"></i>
                                            No hay comunicados nuevos.
                                        </div>
                                    @endempty
                                    <div>
                                        <a href="{{ route('comunicados.index') }}" class="comunicado-link">Ver
                                            todos los comunicados</a>
                                    </div>
                            </div>
                        </div>
                    </li>

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
<div id="toastComunicado" class="toast-comunicado d-none position-fixed shadow-lg p-3 border-0 rounded-3"
style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1055; width: 420px; background-color: #fff7eb; font-family: 'Grandstander', cursive;">
<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="d-flex align-items-center">
        <i class="fas fa-envelope-open-text text-warning me-2 fs-4"></i>
        <strong class="fs-5" style="color: #8373ce;">Comunicado</strong>
    </div>
    <button onclick="cerrarToast()" class="btn btn-sm fs-4"
        style="background: none; border: none; color: #8373ce;">&times;</button>
</div>
<div id="toastMensaje" class="text-dark small" style="max-height: 300px; overflow-y: auto;"></div>
</div>


<!--Main menu area end-->
<script>
    function cerrarToast() {
        document.getElementById('toastComunicado').classList.add('d-none');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('btnToggleComunicados');
        const panel = document.getElementById('panelComunicados');

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            panel.classList.toggle('d-none');
        });

        document.addEventListener('click', function(e) {
            if (!panel.contains(e.target) && !btn.contains(e.target)) {
                panel.classList.add('d-none');
            }
        });

        // Mostrar toast y marcar como visto

        function mostrarToast(mensaje) {
            const toast = document.getElementById('toastComunicado');
            const mensajeDiv = document.getElementById('toastMensaje');

            mensajeDiv.textContent = mensaje;
            toast.classList.remove('d-none');

            // Cierra automáticamente después de 5 segundos
            setTimeout(cerrarToast, 5000);
        }


        document.querySelectorAll('.ver-comunicado-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const mensaje = this.dataset.mensaje;
                const item =
                    this;

                mostrarToast(mensaje);
                console.log("Enviando solicitud para marcar como visto: ", id);

                fetch(`/comunicados/${id}/visto`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                }).then(response => {
                    if (response.ok) {
                        item.classList.add('fade-out');
                        setTimeout(() => item.remove(), 300);

                        // Actualiza contador
                        const contador = document.getElementById('noti-count');
                        if (contador) {
                            let nuevoValor = parseInt(contador.textContent) - 1;
                            if (nuevoValor > 0) {
                                contador.textContent = nuevoValor;
                            } else {
                                contador.remove();
                            }
                        }
                    }
                }).catch(err => console.error('Error:', err));
            });
        });
    });
</script>
