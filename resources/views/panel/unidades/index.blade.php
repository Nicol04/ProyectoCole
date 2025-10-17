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

    <!--Breadcrumb area start-->
    <section class="text-bread-crumb bc-style-two">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Unidades de Aprendizaje</h2>
                    <div class="bread-crumb-line">Unidades de Aprendizaje</div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb area end-->

    <!-- Mensajes de estado -->
    @if(session('mensaje'))
    <div class="container-fluid mt-3">
        <div class="alert alert-{{ session('icono', 'success') }} alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!--Class area start-->
    <section class="choose-class-area ">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="area-heading font-orange mb-0 text-center flex-grow-1">
                            UNIDADES DE APRENDIZAJE
                            <img src="{{ asset('assets/img/panel/icon/pen-orange.png') }}" alt="">
                        </h2>

                        @php
                            $rolId = auth()->user()->roles->first()?->id;
                        @endphp

                        @if ($rolId == 2)
                            <!-- Solo Docente -->
                            <a href="{{ route('unidades.create') }}"
                                class="btn btn-circle-agregar d-flex align-items-center justify-content-center ms-3"
                                title="Crear nueva unidad">
                                <i class="fas fa-plus"></i>
                                <span class="btn-text-hover ms-2">Crear unidad</span>
                            </a>
                        @endif

                    </div>

                    @if ($unidades->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay unidades registradas</h4>
                            <p class="text-muted">Comienza creando tu primera unidad de aprendizaje</p>
                            @if ($rolId == 2)
                                <a href="{{ route('unidades.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i> Crear primera unidad
                                </a>
                            @endif
                        </div>
                    @else
                </div>
            </div>
            <div class="inner-container">
                <div class="row">
                    @foreach ($unidades as $unidad)
                        <!--Single class start-->
                        <div class="col-sm-6 col-xl-3">
                            <div class="single-class wow fadeInUp" data-wow-delay=".4s">
                                @php
                                    $imgNumber = $loop->iteration % 8 ?: 8;
                                @endphp
                                <img src="{{ asset('assets/img/panel/class/class' . $imgNumber . '.jpg') }}"
                                    alt="Unidad {{ $loop->iteration }}">
                                <div class="price red-drop">
                                    <p>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                                    <span>{{ $unidad->grado }}</span>
                                </div>
                                <div class="intro">
                                    <div class="intro-left">
                                        <h3><a href="{{ route('unidades.show', $unidad->id) }}">{{ Str::limit($unidad->nombre, 30) }}</a></h3>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt"></i> 
                                            {{ $unidad->fecha_inicio->format('d/m/Y') }} - {{ $unidad->fecha_fin->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> 
                                            {{ $unidad->fecha_inicio->diffInDays($unidad->fecha_fin) + 1 }} días
                                        </small>
                                    </div>
                                    
                                    @if($unidad->secciones && count($unidad->secciones) > 0)
                                        <div class="mb-2">
                                            <small class="text-info">
                                                <i class="fas fa-users"></i> 
                                                Secciones: {{ implode(', ', $unidad->secciones) }}
                                            </small>
                                        </div>
                                    @endif

                                    <p class="mb-2">{{ Str::limit($unidad->situacion_significativa, 60) }}</p>
                                    
                                    <div class="text-center mt-2">
                                        <a href="{{ route('unidades.show', $unidad->id) }}"
                                            class="kids-care-btn bgc-orange d-inline-block mb-1">
                                            <i class="fas fa-eye"></i> Ver detalle
                                        </a>
                                        
                                        @if (auth()->check() && auth()->user()->roles->first()?->id == 2)
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-outline-warning" title="Editar unidad">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form class="form-eliminar-unidad d-inline"
                                                action="#" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar unidad">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-center mt-4 w-100">
                        {{ $unidades->links() }}
                    </div>

                </div>
            </div>

        </div>
    </section>
    @endif
    <!--Class area end-->
    
    <script>
        document.querySelectorAll('.form-eliminar-unidad').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar unidad de aprendizaje?',
                    text: 'Se eliminarán también todos los datos relacionados.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Aquí implementarás la funcionalidad de eliminar
                        Swal.fire(
                            'Funcionalidad en desarrollo',
                            'La eliminación de unidades estará disponible próximamente.',
                            'info'
                        );
                    }
                });
            });
        });
    </script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
