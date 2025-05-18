<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>
    <div class="preloader"></div> <!-- carga -->
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

    <!--Breadcrumb area start-->
    <div class="text-bread-crumb d-flex align-items-center style-six blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Perfil</h2>
                    <div class="bread-crumb-line"><span>Hola {{ ucfirst($rol) }} !!</span></div>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    <!--Testimonial two area start-->
    <section class="testtimonial-two-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xl-8">
                    <div class="row align-items-center">
                        <!-- Columna izquierda: Datos personales -->
                        <div class="col-sm-6">
                            <div class="testi-two-carousel wow fadeInLeft" data-wow-delay=".3s">
                                <h3 style="font-size: 32px;">Datos personales</h3>
                                <div class="sin-staff-qulity">
                                    <p class="fs-4 fw-bold"><strong>DNI</strong>: {{ $persona->dni }}</p>
                                    <p class="fs-4"><strong>Nombres</strong>: {{ $persona->nombre }}</p>
                                    <p class="fs-4"><strong>Apellidos</strong>: {{ $persona->apellido }}</p>
                                    <p class="fs-4"><strong>Email</strong>: {{ $user->email ?? 'No tiene' }}</p>
                                    <p class="fs-4"><strong>Género</strong>: {{ $persona->genero }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha: Avatar + Info -->
                        <div class="col-sm-6">
                            <div class="position-relative sin-staff wow fadeInUp text-center" data-wow-delay=".6s">

                                <!-- Avatar -->
                                <div class="staf-img mb-4 mt-4">
                                    @if ($user->avatar && $user->avatar->path)
                                        <img src="{{ asset('storage/' . $user->avatar->path) }}"
                                            class="rounded-circle shadow" style="width: 220px; height: 220px;"
                                            alt="Avatar de {{ $user->name }}">
                                    @else
                                        <img src="{{ asset('assets/img/panel/staff/staff-8.png') }}"
                                            class="rounded-circle shadow" style="width: 220px; height: 220px;"
                                            alt="Avatar por defecto">
                                    @endif
                                </div>

                                <!-- Nombre y rol -->
                                <div class="staf-det">
                                    <p style="font-size: 22px;" class="mb-2">Nombre de usuario</p>
                                    <h4 style="font-size: 40px; font-weight: bold;">{{ $user->name }}</h4>
                                    <span style="font-size: 28px;">{{ ucfirst($rol) }}</span>
                                </div>

                                <!-- Estado del usuario -->
                                <div class="mt-3">
                                    @php
                                        $estado = $user->estado ?? 'inactivo';
                                        $activo = strtolower($estado) === 'activo';
                                    @endphp
                                    <span style="font-size: 20px;">
                                        Estado:
                                        <span class="d-inline-block rounded-circle me-2"
                                            style="width: 12px; height: 12px; background-color: {{ $activo ? 'green' : 'gray' }};"></span>
                                        {{ ucfirst($estado) }}
                                    </span>
                                </div>
                            </div>
                            <!-- Botón para editar avatar -->
                            <div class="mt-4">
                                <a href="{{ route('users.avatar.edit', $user->id) }}" class="btn btn-success" style="font-size: 18px;">
                                    <i class="fas fa-image"></i> Editar avatar
                                </a>
                            </div>
                        </div>
                    </div> <!-- fin row interna -->
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial two area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
